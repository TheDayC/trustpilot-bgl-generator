<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReviewLink;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;

class PayloadController extends Controller
{
    protected $db_payloads;
    
    public function __construct(){
        // Must be logged in to see this
        $this->middleware('auth');
        
        // Decode and set keys from TrustPilot site.
        $encrypt_key = env('TP_ENCRYPT', false);
        $auth_key = env('TP_AUTH', false);
        $this->encrypt_key = base64_decode($encrypt_key);
        $this->auth_key = base64_decode($auth_key);
        
        $this->domain = env('TP_DOMAIN', false);
    }
    
    // Index
    public function index(Request $request){
        if(!$request->user()->authorizeRoles(['administrator'])){ return redirect()->route('account'); }
        // Fetch our payloads - only assign to index for now, move to constructor should we need it anywhere else.
        $this->db_payloads = DB::table('payloads')->distinct()->get();
        
        return view('payload')->with('payloads', $this->db_payloads);
    }
    
    /* Manual payload handler */
    public function manual(Request $request){
        // Return if no file found or not admin.
        if(!$request->input('payload') || $request->user()->authorizeRoles(['administrator']) === false){ return redirect()->route('payload'); }
        
        // Catch the payload request
        $payloads = $request->input('payload');
        
        // If there are any valid payloads generate our payload groups to be added to DB
        if($payloads){
            $payload_group = $this->generatePayloadGroups($payloads);
        }
        
        // If payload groups exist then add to our database
        if($payload_group){
            $final_payloads = $this->addBGL($payload_group);
        }
        
        // If we inserted anything then queue emails.
        if($final_payloads){
            $this->queueMail($final_payloads);
        }
        
        // Redirect back to our payload list
        return redirect()->route('payload');
    }
    
    /* File upload handler */
    public function file(Request $request){
        // Return if no file found.
        if(!$request->file('payload_file') || $request->user()->authorizeRoles(['administrator']) === false){ return redirect()->route('payload'); }
        
        // Get file data
        $file_data = file_get_contents($request->file('payload_file')->path());
        
        // Parse CSV
        $payloads = $this->parseCSV($file_data);
        
        // If there are any valid payloads generate our payload groups to be added to DB
        if($payloads){
            $payload_group = $this->generatePayloadGroups($payloads);
        }
        
        // If payload groups exist then add to our database
        if($payload_group){
            $final_payloads = $this->addBGL($payload_group);
        }
        
        // If we inserted anything then queue emails.
        if($final_payloads){
            $this->queueMail($final_payloads);
        }
        
        // Redirect back to our payload list
        return redirect()->route('payload');
    }
    
    /* Re-send emails handler */
    public function send(Request $request){
        // Set response template and initial response code.
        $code = 400;
        $response = array(
        "status" => "error",
        "message" => ""
        );
        
        // Return if we don't find any payload ids
        if(!$request->input('payload_ids')){
            $response["message"] = "No payload ids";
            return response()->json($response, $code);
        }
        
        // Set payload ids
        $payload_ids = $request->input('payload_ids');
        
        if($request){
            // Fetch payloads from database in the id array.
            $payload_group = DB::table('payloads')->whereIn('id', $payload_ids)->get();
            
            // If we get a result back...
            if($payload_group){
                // ... map the payload and send
                $mapped_payloads = $this->map_sql_obj($payload_group);
                $this->queueMail($mapped_payloads);
                
                // Set success message and code
                $response = array(
                "status" => "success",
                "message" => "Email's sent!"
                );
                $code = 200;
            }
        }else{
            // ... else add an error message
            $response["message"] = "Couldn't send the emails.";
        }
        
        // Return JSON for AJAX request
        return response()->json($response, $code);
    }
    
    // Private functions
    private function generatePayloadGroups($payloads){
        $payload_group = array();
        
        foreach($payloads as $payload){
            // Encode payload into a JSON string for encryption
            $payload_json = json_encode($payload);
            $cf_exclusions = array('name', 'email');
            
            // Encrypt payload
            $encrypted_payload = $this->encryptPayload($payload_json, $this->encrypt_key, $this->auth_key);
            
            // Concat payload and domain to bgl eval url
            $bgl = "https://www.trustpilot.com/evaluate-bgl/".$this->domain."?p=".$encrypted_payload;
            
            // Generate payload group
            if($bgl){
                // Generate custom fields
                foreach($payload as $key => $value){
                    if(!in_array($key, $cf_exclusions)){
                        $payload_temp[$key] = $value;
                    }
                }
                
                // Assign payload group and add custom fields.
                if(array_key_exists("name", $payload) && array_key_exists("email", $payload) && array_key_exists("uid", $payload)){
                    $payload_group[] = array(
                    "name" => $payload["name"],
                    "email" => $payload["email"],
                    "uid" => $payload["uid"],
                    "payload" => $payload_json,
                    "bgl" => $bgl,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "custom_fields" => $payload_temp
                    );
                }
            }
        }
        
        return $payload_group;
    }
    
    private function encryptPayload($payload, $encrypt_key, $auth_key){
        // Generate an Initialization Vector (IV) according to the block size (128 bits)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CBC'));
        
        // Encrypting the JSON with the encryptkey and IV with AES-CBC with key size of 256 bits, openssl_encrypt uses PKCS7 padding as default
        $payload_encrypted = openssl_encrypt($payload, 'AES-256-CBC', $encrypt_key, OPENSSL_RAW_DATA, $iv);
        
        // Create a signature of the ciphertext.
        $HMAC = hash_hmac('sha256', ($iv . $payload_encrypted), $auth_key, true);
        
        // Now base64-encode the IV + ciphertext + HMAC:
        $base64_payload = base64_encode(($iv . $payload_encrypted . $HMAC));
        
        return urlencode($base64_payload);
    }
    
    private function addBGL($payload_group){
        // Extract all of our emails
        $emails = array_column($payload_group, "email");
        
        // Check the database to see if any of our emails exist already
        $existing_payloads = DB::table('payloads')->whereIn('email', $emails)->get();
        
        // If there are existing payloads, move them to an array of objects for array column search
        $existing_payloads = $this->map_sql_obj($existing_payloads);
        $existing_payload_emails = array_column($existing_payloads, "email");
        
        // Declare final payloads
        $final_payloads = array();
        
        // Loop through our payload group
        foreach($payload_group as $payload){
            // Only insert payload if not in our existing payloads
            if(!in_array($payload["email"], $existing_payload_emails)){
                // Store and unset custom fields
                $custom_fields = $payload["custom_fields"];
                unset($payload["custom_fields"]);
                
                // Assign remaining payload to final payloads
                $final_payloads[] = $payload;
                
                // Insert payload and fetch id line by line
                $id = DB::table('payloads')->insertGetId($payload);
                
                // If the id exists then we can insert custom fields
                if($id && $custom_fields){
                    $custom_fields_db = array();
                    foreach($custom_fields as $key => $value){
                        $custom_fields_db[] = array(
                        'payload_id' => $id,
                        'key' => $key,
                        'value' => $value
                        );
                    }
                    DB::table('payload_values')->insert($custom_fields_db);
                }
            }
        }
        
        return $final_payloads;
    }
    
    // Map a larvael sql obj to an array for comparison
    private function map_sql_obj($existing_payloads){
        $payloads = array();
        foreach($existing_payloads as $payload){
            $payloads[] = (array) $payload;
        }
        return $payloads;
    }
    
    // Queue emails
    private function queueMail($payload_group){
        foreach($payload_group as $payload){
            Mail::to($payload["email"])->send(new SendReviewLink($payload));
        }
    }
    
    // Parse CSV file
    private function parseCSV($file_data){
        // Get rows split by new line chars
        $csv_rows = str_getcsv($file_data, "\n");
        
        // Setup data arrays
        $csv_data = array();
        $csv_keys = array();
        
        // Loop through found rows
        if($csv_rows){
            foreach($csv_rows as $index => $row){
                // If this is our first row then these are our keys.
                if($index == 0){
                    $csv_keys = str_getcsv($row, ",");
                }else{
                    // Get fields by comma separation
                    $fields = str_getcsv($row, ",");
                    
                    // Assign field to key based on index.
                    foreach($fields as $field_index => $field){
                        $csv_data[$index - 1][$csv_keys[$field_index]] = $field;
                    }
                }
            }
        }
        
        return $csv_data;
    }
}
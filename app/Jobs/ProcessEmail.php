<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $payload_id;
    
    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(PayloadID $payload_id){
        $this->payload_id = $payload_id;
    }
    
    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        // Get the payload
        //$payload = $this->getPayload($this->payload_id);

        // Send out the email

    }
    
    // Retrieve the payload
    /*private function getPayload($payload_id){
        $payload = DB::table('payloads')->where('id', '=', $payload_id)->get();
        return $payload;
    }*/
}
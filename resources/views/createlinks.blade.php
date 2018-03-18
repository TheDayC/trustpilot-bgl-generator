@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <h1 class="no-margin-top">Create Links</h1>
    <p>Use these tools to generate and encrypt payloads into links.</p>
  </div>
  <div id="payload-repeater" class="row">
    <h3>Enter details</h3>
    <form action="{{ route('payload-manual') }}" method="POST">
      {{ csrf_field() }}
      <div class="payload-row row no-gutter">
        <div class="input-collection col s12 no-gutter">
          <div class="input-field col s12 m4">
            <input type="text" class="validate" placeholder="ID" name="payload[0][uid]" id="uid" required>
          </div>
          <div class="input-field col s12 m4">
            <input type="text" class="validate" placeholder="Name" name="payload[0][name]" id="name" required>
          </div>
          <div class="input-field col s12 m4">
            <input type="email" class="validate" placeholder="Email" name="payload[0][email]" id="email" required>
          </div>
        </div>
      </div>
      <div class="button-row row">
        <button class="btn secondary add-row right">Add row</button>
      </div>
      <div class="submit-row row">
        <input type="submit" value="Submit Payload" class="btn">
      </div>
    </form>
  </div>
  <div class="row">
    <h3>Upload CSV file</h3>
     <form action="{{ route('payload-file') }}" method="POST" enctype="multipart/form-data">
       {{ csrf_field() }}
      <div class="file-field input-field">        
        <div class="btn secondary">
          <span>File</span>
          <input name="payload_file" type="file">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>
      </div>
      <div class="input-field no-gutter">
        <input type="submit" value="Submit File" class="btn">
      </div>
    </form>
  </div>
</div>
@endsection

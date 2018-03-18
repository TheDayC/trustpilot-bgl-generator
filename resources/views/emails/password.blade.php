@extends('layouts.email')

@section('header')
  <tr>
    <td align="center" valign="top">
      <img src="" id="logo" width="250" />
    </td>
  </tr>
@endsection

@section('body')
  <tr>
    <td align="left" valign="top">
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">Dear {{ $email_details["name"] }}</p>
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">Your password for your BGL account is: {{ $email_details["password"] }}</p>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif; font-weight:bold; margin: 0 0 8px 0;">Best Regards</p>
      <p style="color:#0069AA; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif; margin:0;">
        <a href="" target="_blank" style="color:#0069AA; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">BGL Generator</a>
      </p>
    </td>
  </tr>

@endsection
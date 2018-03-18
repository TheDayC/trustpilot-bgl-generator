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
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">Dear {{ $payload["name"] }}</p>
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">To improve your customer experience we have partnered with Trustpilot, the online review community, to collect reviews.</p>
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">We would appreciate any feedback you might have.</p>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding:24px 0 8px 0;">
      <h3 style="margin:0; color:#0069AA; font-size:18px; line-height:1.2em; font-weight:normal; font-family:Arial, sans-serif;">
        <a href="<?php echo $payload["bgl"]; ?>" target="_blank" style="color:#0069AA; font-size:18px; line-height:1.2em; font-weight:normal; font-family:Arial, sans-serif;">Click here to review us on Trustpilot</a>
      </h3>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding:24px 0;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td align="left" valign="top" style="padding-bottom:24px;">
            <a href="<?php echo $payload["bgl"]; ?>" target="_blank">
              <img src="{{ asset('img/trustpilot/five-star-260x48.png') }}" />
            </a>
          </td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-bottom:24px;">
            <a href="<?php echo $payload["bgl"]; ?>" target="_blank">
              <img src="{{ asset('img/trustpilot/four-star-260x48.png') }}" />
            </a>
          </td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-bottom:24px;">
            <a href="<?php echo $payload["bgl"]; ?>" target="_blank">
              <img src="{{ asset('img/trustpilot/three-star-260x48.png') }}" />
            </a>
          </td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding-bottom:24px;">
            <a href="<?php echo $payload["bgl"]; ?>" target="_blank">
              <img src="{{ asset('img/trustpilot/two-star-260x48.png') }}" />
            </a>
          </td>
        </tr>
        <tr>
          <td align="left" valign="top">
            <a href="<?php echo $payload["bgl"]; ?>" target="_blank">
              <img src="{{ asset('img/trustpilot/one-star-260x48.png') }}" />
            </a>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="left" valign="top">
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif; margin:0 0 24px 0;">All reviews, good, bad or otherwise will be visible immediately.</p>
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif; margin:0 0 24px 0;">Thanks for your time</p>
      <p style="color:#595959; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif; font-weight:bold; margin: 0 0 8px 0;">Best Regards</p>
      <p style="color:#0069AA; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif; margin:0;">
        <a href="" target="_blank" style="color:#0069AA; font-size:16px; line-height:1.5em; font-family:Arial, sans-serif;">BGL Generator</a>
      </p>
    </td>
  </tr>

@endsection
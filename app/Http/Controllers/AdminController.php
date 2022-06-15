<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;

class AdminController extends Controller
{
    public function send($mobile,$pattern,$data)
    {

        $username = "danial-keighobadi";
        $password = '123456789';
        $from = "+98100020400";
        $pattern_code = "139";
        $to = array($mobile);
        $input_data = array(
            "tracking-code" => "1054 4-41",
            "name" => $data);
        $url = "http://37.130.202.188/patterns/pattern?username="
            . $username
            . "&password="
            . urlencode($password)
            . "&from=$from&to="
            . json_encode($to)
            . "&input_data="
            . urlencode(json_encode($input_data))
            . "&pattern_code=$pattern_code";

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);













        /*$client = new SoapClient("http://37.130.202.188/class/sms/wsdlservice/server.php?wsdl");
        $user = "danial-keighobadi";
        $pass = "123456789";
        $fromNum = "+98100020400";
        $toNum = array($mobile);
        $pattern_code = $pattern;
        $input_data = array(
            "validation_code"   => "12588",
            "login_code"        => "rewwwe14",
            "tracking_code"     => "qxq3ecv" );

        echo $client->sendPatternSms($fromNum,$toNum,$user,$pass,$pattern_code,$input_data);
   */ }
}

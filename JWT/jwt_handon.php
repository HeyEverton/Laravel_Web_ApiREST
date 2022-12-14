<?php

//APPLICATION KEY
$key = '123456789';


//HEADER TOKEN
$header = [
    'typ' =>'JWT',
    'alg' => 'HS256'
];

//PAYLOAD   
$payload = [
    'exp' => (new DateTime("now"))->getTimestamp(),
    'uid' => 1,
    'email' => 'email@email.com',
];


//JSON

$header = json_encode($header);
$payload = json_encode($payload);


//BASE 64
$header = base64_encode($header);
$payload = base64_encode($payload);


//SIGNATURE
$sign = hash_hmac('sha256', $header .".". $payload, $key, true);
$sign = base64_encode($sign);


//TOKEN 
$token =  $header . '.' . $payload . '.' . $sign;
print $token;
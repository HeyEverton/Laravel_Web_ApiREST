<?php

require __DIR__ . '/vendor/autoload.php';

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;

$signer = new Sha256();
$time = date('Y:m:d H:i:s');

$token = (new Builder())->issuedBy('http://example.com')
                        ->permittedFor('http://example.org')
                        ->issuedAt($time + 1)
                        ->canOnlyBeUsedAfter($time + 60)
                        ->expiresAt($time + 3600)
                        ->withClaim('uid', 1)
                        ->withClaim('email', 'email@email.com')
                        ->getToken($signer, new Key('testing'));

print $token;                        

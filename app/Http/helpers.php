<?php

function validateLicense($key, $email)
{
    $client = new \GuzzleHttp\Client();
    $url = 'http://topdogimsolutions.com/licensing/?pl_type=video_intro&licensekey='.$key
        .'&domainname='.$_SERVER['HTTP_HOST'].'&email='.$email;
    $res = $client->request('GET', $url);
    $result = json_decode($res->getBody());
    if ($result->valid == 1) {
        return true;
    }
    
    return false;
}

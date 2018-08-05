<?php
    error_reporting(0);
    set_time_limit(0);
    $token = '';
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://graph.facebook.com/me/friends?access_token=' . $token
    ));
    $response = json_decode(curl_exec($ch));
    curl_close($ch);

    print_r($response->data);
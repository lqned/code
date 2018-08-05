<?php
    //2018-08-05 07:22:21
    set_time_limit(0);
    error_reporting(0);
    $post_id = '';
    $limit = 1000;
    $token = '';
    
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://graph.facebook.com/$post_id/comments?limit=$limit&access_token=$token"
    ));

    $response = json_decode(curl_exec($ch));

    curl_close($ch);

    print_r($response);
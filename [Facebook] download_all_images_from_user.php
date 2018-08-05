<?php
    error_reporting(0);
    set_time_limit(0);

    $user_id = '';
    $token = '';

    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://graph.facebook.com/$user_id?fields=photos.limit(999999){images}&access_token=$token"
    ));

    $response = json_decode(curl_exec($ch))->photos->data;

    curl_close($ch);

    mkdir(dirname(__FILE__) . "/$user_id/");

    for ($i = 0; $i < count($response); $i++){
        $id = $response[$i]->id;
        file_put_contents(dirname(__FILE__) . "/$user_id/$id.jpg", file_get_contents($response[$i]->images[0]->source));
        echo $response[$i]->images[0]->source . PHP_EOL;
    }

    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://graph.facebook.com/$user_id?fields=posts.limit(999999){type,full_picture}&access_token=$token"
    ));

    $response = json_decode(curl_exec($ch))->posts->data;

    curl_close($ch);

    for ($i = 0; $i < count($response); $i++){
        $id = $response[$i]->id;
        if ($response[$i]->type == 'photo')
            file_put_contents(dirname(__FILE__) . "/$user_id/$id.jpg", file_get_contents($response[$i]->full_picture));
        echo $response[$i]->full_picture . PHP_EOL;
    }

    echo 'Done!';
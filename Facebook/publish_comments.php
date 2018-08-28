<?php
    error_reporting(0);
    set_time_limit(0);

    $post_id = '';
    $token = '';

    function curl($url){
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));

        $response = json_decode(curl_exec($ch));

        curl_close($ch);

        return $response;
    }

    $path_of_content = dirname(__FILE__) . "/data/content.txt";

    $file = fopen($path_of_content, 'r');

    while (($line = fgets($file)) !== false){
        if ($line == null) continue;
        echo $line . PHP_EOL;
        $line = rawurlencode($line);
        curl("https://graph.facebook.com/$post_id/comments?message=$line&method=post&access_token=$token");
        sleep(2);
    }

    echo 'Done!';

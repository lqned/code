<?php
    error_reporting(0);
    set_time_limit(0);

    $user_id = '';
    $react_count = 5;
    $type = 'SAD';
    $token = '';

    function curl($url){
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response);
    }

    $posts = curl("https://graph.facebook.com/$user_id/posts?limit=999999&access_token=$token");

    $posts = $posts->data;

    for ($i = 0; $i < count($posts); $i++){
        $id = $posts[$i]->id;
        $response = curl("https://graph.facebook.com/$id/reactions?summary=true&access_token=$token");
        if ($response->summary->viewer_reaction != $type){
            curl("https://graph.facebook.com/$id/reactions?type=$type&method=post&access_token=$token");
            echo $id . PHP_EOL;
            $react_count--;
            sleep(2);
        }
        if (!$react_count) break;
    }

    echo 'Done!';
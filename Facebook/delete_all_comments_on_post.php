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

    $comments = curl("https://graph.facebook.com/$post_id/comments?limit=999999&access_token=$token")->data;

    for ($i = 0; $i < count($comments); $i++)
        if ($comments[$i]->can_remove == 1){
            $comment_id = $comments[$i]->id;
            curl("https://graph.facebook.com/$comment_id?method=delete&access_token=$token");
            echo $comment_id . PHP_EOL;
        }
    echo 'Done!';
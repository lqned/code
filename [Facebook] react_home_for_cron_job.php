<?php
    error_reporting(0);
    set_time_limit(0);

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

    $token = '';

    $friends = curl("https://graph.facebook.com/me/friends?access_token=$token")->data;

    $posts = curl("https://graph.facebook.com/v3.1/me/home?fields=from,message,status_type&limit=20&access_token=$token")->data;
    for ($i = 0; $i < count($posts); $i++){
        $id = $posts[$i]->id;
        $react = curl("https://graph.facebook.com/$id/reactions?summary=true&access_token=$token");
        if ($react->summary->viewer_reaction != "NONE") continue;
        for ($j = 0; $j < count($friends); $j++)
            if ($friends[$j]->id == $posts[$i]->from->id){
                curl("https://graph.facebook.com/$id/reactions?type=LIKE&method=post&access_token=$token");
                sleep(2);
                break;
            }
        
    }
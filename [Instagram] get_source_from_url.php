<?php
    error_reporting(0);
    set_time_limit(0);

    $url = '';
    
    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url
    ));

    $html = curl_exec($ch);

    curl_close($ch);

	for ($i = strpos($html, 'window._sharedData') + 22; $html[$i] != '<'; $i++) $json = $json . $html[$i - 1];
	$json = json_decode($json);
	$json = $json->entry_data->PostPage[0]->graphql->shortcode_media;

	if ($json->__typename == 'GraphImage'){
        $response[0][type] = 'image';
		$response[0][url] = $json->display_url;
	}
	if ($json->__typename == 'GraphVideo'){
        $response[0][type] = 'video';
        $response[0][url] = $json->video_url;
        $response[0][display_url] = $json->display_url;
	}
	if ($json->__typename == 'GraphSidecar'){
		$json = $json->edge_sidecar_to_children->edges;
		for ($i = 0; $i < count($json); $i++){
			$node = $json[$i]->node;
			if ($node->__typename == 'GraphImage'){
				$response[$i][type] = 'image';
		        $response[$i][url] = $node->display_url;
			}
			if ($node->__typename == 'GraphVideo'){
				$response[$i][type] = 'video';
                $response[$i][url] = $node->video_url;
                $response[$i][display_url] = $node->display_url;
			}
		}
	}

    print_r(json_encode($response));
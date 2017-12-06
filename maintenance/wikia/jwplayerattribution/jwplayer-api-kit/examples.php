<?php
header('Content-type: text/plain; charset=utf-8');

require_once('botr/api.php');
// Please update xxxx with your key and yyyy with your secret
$botr_api = new BotrAPI('cGlKNUnj', 'z85xqAqnqtS7PzjKVwPcBGOa');

// Here's an example call that lists all videos.
print_r($botr_api->call("/videos/list"));

// Video details example; update zzzz with a video_key listed by the call above.
// print_r($botr_api->call("/videos/show", array('video_key' => 'zzzzzzzz')));

// Thumbnail upload example; again replace zzzz with your video key.
/*
$response = $botr_api->call("/videos/thumbnails/update", array('video_key' => 'zzzzzzzz'));
if ($response['status'] == "error") {
    print_r($response);
} else {
    $response = $botr_api->upload($response['link'], "./thumbnail.jpg");
    print_r($response);
}
*/
?>

{{RequestForm4|
| Wiki title = <?= $params["request_title"] ?>
| Wiki name = <?= $params["request_name"] ?>
| language = <?= $languages[$params["request_language"]] ?>
| languagecode = <?= $params["request_language"] ?>
| username = <?= $username ?>
| Description = <?= $params["request_description_international"] ?>
| Description English = <?= $params["request_description_english"] ?>
| Community = <?= $params["request_community"] ?>
| Category = <?= $params["request_category"] ?>
| More information = <?php
$urls = explode("\n", $params['request_moreinfo']);
foreach ($urls as $url) {
	$url = explode('=', $url);
	echo "{$url[0]} - {$url[1]}<br/>";
}

?>
| Extra information = <?= $params["request_extrainfo"] ?>
| Request ID = <?= $request_id ?>
| Request date = <?= date('F d, Y', strtotime($params["request_timestamp"])); ?>
| Request closed = ###REQUEST_CLOSED###
}}
[[Category:Open requests]]
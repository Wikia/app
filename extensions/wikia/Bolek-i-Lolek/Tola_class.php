<?php

class Tola {
	const URL = "http://api.magcloud.com";

	static private function generateSecurityHash($method, $call, $data, $authTicket) {
		global $wgMCSecret;

		if (is_array($data) && array_key_exists("issueContent", $data)) return null;

		if (!is_array($data)) $data = array();

												  $stringToSign  = "{$method}\n";
												  $stringToSign .= "{$call}\n";
		foreach ($data as $key => $val) $stringToSign .= "{$key}{$val}\n";
		if (!empty($authTicket))        $stringToSign .= "{$authTicket}\n";
												  $stringToSign .= "{$wgMCSecret}\n";

		$securityHash = base64_encode(sha1(utf8_encode($stringToSign), true));

		return $securityHash;
	}

	static private function post($call, $data, $authTicket) {
		$securityHash = self::generateSecurityHash("POST", $call, $data, $authTicket);

		$httpHeader = array();
		if (!empty($securityHash)) $httpHeader[] = "X-MCSecurity: {$securityHash}";
		if (!empty($authTicket))   $httpHeader[] = "X-MCAuthorization: {$authTicket}";

		$c = curl_init(self::URL . $call);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_HTTPHEADER, $httpHeader);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $data);

		ob_start();
		curl_exec( $c );
		$text = ob_get_contents();
		ob_end_clean();

#echo htmlspecialchars($text); echo "\n";

		curl_close($c);

		$res = new SimpleXMLElement($text);

		return $res;
	}

	static private function put($call, $body, $authTicket) {
		$securityHash = self::generateSecurityHash("PUT", $call, $body, $authTicket);

		$httpHeader = array();
		if (!empty($securityHash)) $httpHeader[] = "X-MCSecurity: {$securityHash}";
		if (!empty($authTicket))   $httpHeader[] = "X-MCAuthorization: {$authTicket}";

#$f = fopen("/tmp/put.log", "w");
#fwrite($f, $body);
#fclose($f);
#
#$f = fopen("/tmp/put.log", "r");
$f = tmpfile();
fwrite($f, $body);
fseek($f, 0);

		$c = curl_init(self::URL . $call);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_HTTPHEADER, $httpHeader);
		curl_setopt($c, CURLOPT_PUT, true);
		curl_setopt($c, CURLOPT_INFILE, $f);
		curl_setopt($c, CURLOPT_INFILESIZE, strlen($body));

		ob_start();
		curl_exec( $c );
		$text = ob_get_contents();
		ob_end_clean();

#echo htmlspecialchars($text); echo "\n";

		curl_close($c);

fclose($f);

		$res = new SimpleXMLElement($text);

		return $res;
	}

	static private function LoginAs($token) {
		global $wgMCPrivateApiKey;

		$res = self::post("/1.0/LoginAs", array("apiKey" => $wgMCPrivateApiKey, "token" => $token), null);

		return $res;
	}

	static private function Publication($authTicket) {
$body = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>
<publication>
<id>0</id>
<username />
<name>Wikia</name>
<subtitle>Subtitle</subtitle>
<logoImageUrl>http://www.example.org/a.jpg</logoImageUrl>
<category>Some category</category>
<visibleToPublic>True</visibleToPublic>
<subscribableToPublic>True</subscribableToPublic>
<description>Description</description>
</publication>";

		$res = self::put("/1.0/Publication", $body, $authTicket);

		return $res;
	}

	static private function Issue($authTicket, $publicationId, $name, $description, $tags) {
$body = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>
<issue>
<id>0</id>
<username />
<issueNumber>1</issueNumber>
<description>{$description}</description>
<tags>tag</tags>
<name>{$name}</name>
<issueDate>2009-08-06 00:00:00Z</issueDate>
<publicationId>{$publicationId}</publicationId>
<visibleToPublic>True</visibleToPublic>
<pageCount>0</pageCount>
<previewUrl />
<thumbnailUrl />
<previewLimit>0</previewLimit>
<imageUrlQueryParam />
<isPublished>False</isPublished>
</issue>";
#echo htmlspecialchars($body); echo "\n";

		$res = self::put("/1.0/Issue", $body, $authTicket);

		return $res;
	}

	static private function IssueUpload($authTicket, $issueId, $pdf) {
		$res = self::post("/1.0/Issue/{$issueId}/Upload", array("issueContent" => "@{$pdf};type=application/pdf"), $authTicket);

		return $res;
	}

	static private function IssuePublish($authTicket, $issueId) {
		$res = self::post("/1.0/Issue/{$issueId}/Publish", array(), $authTicket);

		return $res;
	}

	static private function get($call, $data, $authTicket) {
		$securityHash = self::generateSecurityHash("GET", $call, $data, $authTicket);

		$httpHeader = array();
		if (!empty($securityHash)) $httpHeader[] = "X-MCSecurity: {$securityHash}";
		if (!empty($authTicket))   $httpHeader[] = "X-MCAuthorization: {$authTicket}";

		$c = curl_init(self::URL . $call);
		curl_setopt($c, CURLOPT_HEADER, false);
		curl_setopt($c, CURLOPT_HTTPHEADER, $httpHeader);

		ob_start();
		curl_exec( $c );
		$text = ob_get_contents();
		ob_end_clean();

#echo htmlspecialchars($text); echo "\n";

		curl_close($c);

		$res = new SimpleXMLElement($text);

		return $res;
	}

	static private function getPublications($authTicket, $username) {
		// FIXME check and paginate if > 1000
		$res = self::get("/1.0/User/{$username}/Publications?offset=0&pagesize=1000", array(), $authTicket);

		return $res;
	}

	static private function getIssues($authTicket, $publicationId) {
		// FIXME check and paginate if > 1000
		$res = self::get("/1.0/Publication/{$publicationId}/Issues?offset=0&pagesize=1000", array(), $authTicket);

		return $res;
	}

	static private function UploadStatus($authTicket, $uploadJobId) {
		$res = self::get("/1.0/UploadStatus/{$uploadJobId}", array(), $authTicket);

		return $res;
	}

	static function publish() {
		global $wgRequest, $wgUploadDirectory, $wgUploadPath;

		$bolek_id  = $wgRequest->getVal("bolek_id");
		$timestamp = $wgRequest->getVal("timestamp");
		$token     = $wgRequest->getVal("token");

		if (empty($bolek_id) || empty($timestamp) || empty($token)) return "not enough data.";

		$fname = "{$bolek_id}-{$timestamp}.pdf";
		if (!file_exists("{$wgUploadDirectory}/lolek/{$fname}")) return "no pdf. Please create it first.";

#echo "<pre>";
#$d = fopen("/tmp/curl.log", "w");

		$res = self::LoginAs($token);
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

$username   = $res->user->username;
$authTicket = $res->authTicket;

		$res = self::getPublications($authTicket, $username);
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

$publicationId = 0;
// FIXME test if no publication!
if (!empty($res->publication)) {
	foreach ($res->publication as $r) {
		if ("Wikia" == "{$r->name}") {
#print_r(array("r->name" => $r->name, "r->id" => $r->id)); echo "\n";
			$publicationId = $r->id;
			break;
		}
	}
}
#print_r(array("publicationId" => $publicationId)); echo "\n";

if (empty($publicationId)) {
		$res = self::Publication($authTicket);
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

$publicationId = $res->id;
}

$magazineTitle = "magazine title";
$magazineSubtitle = "magazine subtitle";
$tags = array("a", "b", "wikia:hub=Entertainment", "wikia:wiki=Futurama Wiki", "c", "d");

// FIXME skip this step for new publication
		$res = self::getIssues($authTicket, $publicationId);
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

$title_i = 0;
// FIXME test if no issue!
if (!empty($res->issue)) {
	foreach ($res->issue as $r) {
		if (preg_match("/^{$magazineTitle}(?: \(([0-9]+)\))?$/", "{$r->name}", $match)) {
#print_r(array("r->name" => $r->name, "match" => $match)); echo "\n";
			if (empty($match[1])) $match[1] = 1;
			if ($title_i < $match[1]) $title_i = $match[1];
		}
	}
}

if (!empty($title_i)) $magazineTitle .= " (" . ++$title_i . ")";

		$res = self::Issue($authTicket, $publicationId, $magazineTitle, $magazineSubtitle, join(",", $tags));
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

$issueId = $res->id;

		$res = self::IssueUpload($authTicket, $issueId, "{$wgUploadDirectory}/lolek/{$fname}");
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

		$uploadJobId = $res->uploadJobId;

		$iteration = 20; // prevent infinite loop
		do {
			sleep(3);

			$res = self::UploadStatus($authTicket, $uploadJobId);
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

			$processingFinished = ("{$res->processingFinished}" == "True") ? true : false;
		} while (--$iteration && !$processingFinished);
		if (!$processingFinished) return "remote backend processing not finished in allotted time.";

		$res = self::IssuePublish($authTicket, $issueId);
#print_r($res); echo "\n";
if (!empty($res->code)) return "error {$res->code}: {$res->message}.";

#fclose($d);
#echo "</pre>";
#exit;

#echo $issueId;
		return "{$issueId}"; // it's SimpleXMLElement object really, cast is needed
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "Tola::publish";


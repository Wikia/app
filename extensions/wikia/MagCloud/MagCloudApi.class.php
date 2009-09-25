<?php

class MagCloudApi {
	const URL = "http://api.magcloud.com";

	static private function generateSecurityHash($method, $call, $data, $authTicket) {
		global $wgMagCloudSecret;

		if (is_array($data) && array_key_exists("issueContent", $data)) {
			return null;
		}

		if (!is_array($data)) {
			$data = array();
		}

		$stringToSign = "{$method}\n";
		$stringToSign .= "{$call}\n";

		foreach ($data as $key => $val) {
			$stringToSign .= "{$key}{$val}\n";
		}

		if (!empty($authTicket)) {
			$stringToSign .= "{$authTicket}\n";
		}

		$stringToSign .= "{$wgMagCloudSecret}\n";

		$securityHash = base64_encode(sha1(utf8_encode($stringToSign), true));

		return $securityHash;
	}

	static private function post($call, $data, $authTicket) {
		wfDebug(__METHOD__ . " {$call}\n");

		$securityHash = self::generateSecurityHash("POST", $call, $data, $authTicket);

		$httpHeader = array();
		if (!empty($securityHash)) {
			$httpHeader[] = "X-MCSecurity: {$securityHash}";
		}

		if (!empty($authTicket)) {
			$httpHeader[] = "X-MCAuthorization: {$authTicket}";
		}

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

		if ($text == '') {
			$res = (object) array(
				'code' => 'Wikia',
				'message' => 'Empty response from MagCloud',
			);
		}
		else {
			$res = new SimpleXMLElement($text);
		}

		return $res;
	}

	static private function put($call, $body, $authTicket) {
		wfDebug(__METHOD__ . " {$call}\n");

		$securityHash = self::generateSecurityHash("PUT", $call, $body, $authTicket);

		$httpHeader = array();
		if (!empty($securityHash)) {
			$httpHeader[] = "X-MCSecurity: {$securityHash}";
		}

		if (!empty($authTicket)) {
			$httpHeader[] = "X-MCAuthorization: {$authTicket}";
		}

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

	static public function LoginAs($token) {
		global $wgMagCloudPrivateApiKey;

		$res = self::post("/1.0/LoginAs", array("apiKey" => $wgMagCloudPrivateApiKey, "token" => $token), null);

		return $res;
	}

	static public function Publication($authTicket) {
$body = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>
<publication>
<id>0</id>
<username />
<name>Wikia " . mt_rand() . "</name>
<subtitle>Wikia publication subtitle</subtitle>
<logoImageUrl></logoImageUrl>
<category>Wikia</category>
<visibleToPublic>True</visibleToPublic>
<subscribableToPublic>True</subscribableToPublic>
<description>Wikia publication description</description>
</publication>";
#echo htmlspecialchars($body);

		$res = self::put("/1.0/Publication", $body, $authTicket);

		return $res;
	}

	static public function Issue($authTicket, $publicationId, $issueName, $issueDescription, $issueTags) {

		// escpae XML string
		$issueName = htmlspecialchars($issueName);
		$issueDescription = htmlspecialchars($issueDescription);
		$issueTags        = htmlspecialchars($issueTags);

$body = "<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"yes\"?>
<issue>
<id>0</id>
<username />
<issueNumber>1</issueNumber>
<description>{$issueDescription}</description>
<tags>{$issueTags}</tags>
<name>{$issueName}</name>
<issueDate>" . date("c") . "</issueDate>
<publicationId>{$publicationId}</publicationId>
<visibleToPublic>True</visibleToPublic>
<pageCount>0</pageCount>
<previewUrl />
<thumbnailUrl />
<previewLimit>0</previewLimit>
<imageUrlQueryParam />
<isPublished>False</isPublished>
</issue>";
#echo htmlspecialchars($body);

		$res = self::put("/1.0/Issue", $body, $authTicket);

		return $res;
	}

	static public function IssueUpload($authTicket, $issueId, $pdf) {
		$res = self::post("/1.0/Issue/{$issueId}/Upload", array("issueContent" => "@{$pdf};type=application/pdf"), $authTicket);

		return $res;
	}

	static public function IssuePublish($authTicket, $issueId) {
		$res = self::post("/1.0/Issue/{$issueId}/Publish", array(), $authTicket);

		return $res;
	}
}

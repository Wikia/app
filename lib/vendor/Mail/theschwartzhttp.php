<?php

class Mail_theschwartzhttp extends Mail {

	var $proxy = "";
	var $envelope_from = "";

	function Mail_theschwartzhttp($params) {
		if (isset($params['url']))
			$this->url = $params['url'];
		if (isset($params['proxy']))
			$this->proxy = $params['proxy'];
		if (isset($params['envelope_from']))
			$this->envelope_from = $params['envelope_from'];
	}

	function send( $recipients, $headers, $body ) {

		global $wgVersion;

		$this->_sanitizeHeaders( $headers );
		$headerElements = $this->prepareHeaders( $headers );
		list( $from, $textHeaders ) = $headerElements;

		foreach ($recipients as $recipient) {
			if ( version_compare( $wgVersion, '1.16', '>=' ) ) {
				$status = Http::post( "http://theschwartz/theschwartz/inject",
					array(
						"postData" => array ( "rcpt" => "$recipient", "env_from" => $from, "msg" => "$textHeaders" . "\n\n" . "$body" )
					)
				);
			}
			else {
				$status = Http::post( "http://theschwartz/theschwartz/inject",
					'default',
					array ( CURLOPT_POSTFIELDS => array ( "rcpt" => "$recipient", "env_from" => $from, "msg" => "$textHeaders" . "\n\n" . "$body" ) )
				);
			}
			wfDebugLog( "enotif", __METHOD__ . ": injecting http://theschwartz/theschwartz/inject with params: $recipient $from {$headers['Subject']}", true );
		}
	}
}

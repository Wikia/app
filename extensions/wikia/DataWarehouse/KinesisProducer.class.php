<?php
class AwsCredentialScope {
	function __construct( $timestamp, $region, $service ) {
		$this->parts = array(
			date( 'Ymd', $timestamp ),
			$region,
			$service,
			'aws4_request'
		);
	}

	function describe() {
		return implode( '/', $this->parts );
	}

	/*
	 * https://docs.aws.amazon.com/general/latest/gr/signature-v4-examples.html#signature-v4-examples-other
	 */
	function sign( $secretKey ) {
		$key = 'AWS4'.$secretKey;
		foreach ( $this->parts as $part ) {
			$key = hash_hmac('sha256', $part, $key, true);
		}
		return $key;
	}
}

class KinesisProducer {
	const SERVICE_NAME = 'kinesis';
	const PUT_RECORD_AMZ_TARGET = 'Kinesis_20131202.PutRecord';
	const CONTENT_TYPE = 'application/x-amz-json-1.1';
	const SIGNING_ALGORITHM = 'AWS4-HMAC-SHA256';
	const SIGNED_HEADERS = 'content-type;host;x-amz-date;x-amz-target';

	function __construct( $accessKey, $secretKey, $region = 'us-east-1' ) {
		$this->accessKey = $accessKey;
		$this->secretKey = $secretKey;
		$this->region = $region;
		$this->host = 'kinesis.' . $region . '.amazonaws.com';
	}

	private function getCanonicalHeaders( $timestamp ) {
		return sprintf(
			"content-type:%s\nhost:%s\nx-amz-date:%s\nx-amz-target:%s\n",
			self::CONTENT_TYPE,
			$this->host,
			date( 'Ymd\THis\Z', $timestamp ),
			self::PUT_RECORD_AMZ_TARGET
		);
	}

	private function getCanonicalRequest( $timestamp, $requestHash ) {
		return sprintf(
			"POST\n/\n\n%s\n%s\n%s",
			$this->getCanonicalHeaders( $timestamp ),
			self::SIGNED_HEADERS,
			$requestHash
		);
	}

	private function getSignature( $credentialScope, $timestamp, $requestHash ) {
		$signingKey = $credentialScope->sign( $this->secretKey );
		$stringToSign = implode( "\n", array(
			self::SIGNING_ALGORITHM,
			date( 'Ymd\THis\Z', $timestamp ),
			$credentialScope->describe(),
			hash( 'sha256', $this->getCanonicalRequest( $timestamp, $requestHash ) )
		));
		return hash_hmac( 'sha256', $stringToSign, $signingKey );
	}

	private function getAuthorizationHeader( $timestamp, $requestHash ) {
		$credentialScope = new AwsCredentialScope( $timestamp, $this->region, self::SERVICE_NAME );
		return sprintf(
			'%s Credential=%s/%s, SignedHeaders=%s, Signature=%s',
			self::SIGNING_ALGORITHM,
			$this->accessKey,
			$credentialScope->describe(),
			self::SIGNED_HEADERS,
			$this->getSignature( $credentialScope, $timestamp, $requestHash )
		);
	}

	public function putRecord( $streamName, $message, $partitionKey = '0' ) {
		$timestamp = time();
		$requestBody = json_encode( array(
			'StreamName' => $streamName,
			'Data' => base64_encode( $message ),
			'PartitionKey' => '0'
		));
		$requestHash = hash( 'sha256', $requestBody );

		$requestHeaders = array(
			'Content-Type: ' . self::CONTENT_TYPE,
			'X-Amz-Date: ' . date( 'Ymd\THis\Z', $timestamp ),
			'X-Amz-Target: ' . self::PUT_RECORD_AMZ_TARGET,
			'Authorization: ' . $this->getAuthorizationHeader( $timestamp, $requestHash )
		);

		$context = stream_context_create( array(
			'http' => array(
				'method'        => 'POST',
				'content'       => $requestBody,
				'ignore_errors' => true,
                		'header'        => $requestHeaders,
			),
		));
		$url = 'https://'.$this->host;
		$response = @file_get_contents( $url, null, $context );
		if ( false === $response ) {
			throw new \RuntimeException( sprintf('Could not connect to %s', $url) );
		}
		if ( 'HTTP/1.1 200 OK' !== $http_response_header[0] ) {
			throw new \RuntimeException( sprintf('Unable to put record into kinesis: %s', $response) );
		}
		return json_decode( $response );
	}
}

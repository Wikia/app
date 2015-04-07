<?php
use Wikia\Util\Consul\ConsulConfig;
use Wikia\Util\Consul\ConsulService;
use Wikia\Util\Consul\ExternalServicesQuery;

class InfoboxServiceConnector {

	const SERIVCE_QUERY_PATH = 'parse';
	const SERVICE_NAME = 'infobox';
	const SERVICE_DC = 'sjc';
	protected $consulService;

	public function __construct() {
		$this->consulService = new ConsulService( new ConsulConfig( self::SERVICE_DC, self::SERVICE_NAME, "testing" ) );
	}

	public function getJsonBySource( $sourceCode, $templateData ) {
		$extQuery = new ExternalServicesQuery( $this->consulService );
		$url = $extQuery->getUrl( self::SERIVCE_QUERY_PATH );
		$postData = $this->getPostData( $sourceCode, $templateData );

		$response = Http::post( $url, [
			"postData" => $postData,
			"noProxy" => true,
			"headers" => $this->getHeaders() ] );

		if ( !$response ) {
			//TODO: log error
		}
		return $response;
	}

	protected function getHeaders() {
		return [
			"Content-Type" => "application/x-www-form-urlencoded",
			"Accept" => "application/json"
		];
	}

	protected function getPostData( $sourceCode, $templateData ) {
		return strtr('infobox={code}&data={data}', [
			"{code}" => urlencode($sourceCode),
			"{data}" => urlencode(json_encode( $templateData ))
		]);
	}
}

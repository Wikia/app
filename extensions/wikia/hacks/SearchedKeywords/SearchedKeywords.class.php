<?php

class SearchedKeywords {
	const CACHE_KEY = 'SearchedKeywords';
	const CACHE_TTL = 1209600; // 14 days

	/**
	 * @var WikiaApp
	 */
	private $app;

	public function __construct() {
		$this->app = F::app();
	}

	public function recordKeyword( $keyword ) {
		$keyword = strtolower( $keyword );

		$memc = $this->app->wg->Memc;
		$cacheKey = wfMemcKey( self::CACHE_KEY );

		$data = $memc->get( $cacheKey );
		if(empty($data)) {
			$data = $this->createData();
		}
		else {
			$data = json_decode( $data );
		}

		$hash = 'K-' . md5( $keyword );
		if( isset( $data->keywords->$hash ) ) {
			$data->keywords->$hash->c++;
			$data->keywords->$hash->ts = time();
		}
		else {
			$data->keywords->$hash = new stdClass();
			$data->keywords->$hash->c = 1;
			$data->keywords->$hash->k = $keyword;
			$data->keywords->$hash->ts = time();
		}

		$data->updateTs = time();
//var_dump( json_encode( $data ) );
//exit;

		$memc->set( $cacheKey, json_encode( $data ), self::CACHE_TTL );
	}

	private function createData() {
		$data = new stdClass();
		$data->keywords = new stdClass();
		$data->createTs = time();
		$data->updateTs = time();

		return $data;
	}
};
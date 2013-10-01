<?php

class ArticleContentApiController extends WikiaApiController {

	public function test() {
		print_r( '<pre>' );
		$service = new ArticleService( 50 );
		print_r( $service->getWikiText() );
		die;
	}
}
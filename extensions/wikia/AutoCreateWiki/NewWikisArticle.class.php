<?php

class NewWikisArticle extends Article {

	protected $app = null;
	protected $pageNo = 1;
	protected $method = null;

	public function setApp( WikiaApp $app ) {
		$this->app = $app;
	}

	public function setPageNo( $pageNo ) {
		$this->pageNo = $pageNo;
	}

	public function setMethod( $method ) {
		$this->method = $method;
	}

	public function view() {
		$out = $this->app->getGlobal( 'wgOut' );

		$out->addHTML( $this->app->renderView( 'NewWikis', $this->method, array( 'pageNo' => $this->pageNo ) ) );

		//return "Hello World!";
	}

}
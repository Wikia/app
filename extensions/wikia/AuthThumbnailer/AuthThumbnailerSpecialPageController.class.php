<?php

/**
 * This is an example use of SpecialPage controller
 * @author MoLi
 *
 */
class AuthThumbnailerSpecialPageController extends WikiaSpecialPageController {

	private $businessLogic = null;
	private $controllerData = array();

	public function __construct() {
		parent::__construct( 'AuthThumbnailer', '', false );
	}

	/**
	 * this is default method, which in this example just redirects to helloWorld method
	 */
	public function index() {
		$this->forward( 'AuthThumbnailerSpecialPage', 'getThumb' );
	}

	/**
	 * helloWorld method
	 *
	 * @requestParam int $wikiId
	 * @responseParam string $header
	 * @responseParam array $wikiData
	 */
	public function getThumb() {
		$this->wf->profileIn( __METHOD__ );

		if ( $this->wg->User->isLoggedIn() ) {
			# make proper thumb path: c/central/images/thumb/....
			$path = sprintf( "%s/%s/images", substr( $this->wg->DBname, 0, 1 ), $this->wg->DBname );
			# take thumb request from request
			$img_thumb = $this->getVal( 'thumb' );
			# and build proper thumb url for thumbnailer
			$thumb_url = sprintf( "%s/%s/%s", $this->wg->ThumbnailerService, $path, $img_thumb );
			
			# call thumbnailer 
			$options = array( 'method' => 'GET', 'timeout' => 'default', 'noProxy' => 1 );
			$thumb_request = HttpRequest::factory( $thumb_url, $options );
			$status = $thumb_request->execute();
			$headers = $thumb_request->getResponseHeaders();

			if ( $status->isOK() ) {
				if ( !empty( $headers ) ) {
					foreach ( $headers as $header_name => $header_value ) {
						if ( is_array( $header_value ) ) {
							list( $value ) = $header_value;
						} else {
							$value = $header_value;
						}
						header( sprintf( "%s: %s", $header_name, $value ) );
					}
				}
				echo $thumb_request->getContent();
				exit;
			} else {
				$this->wf->debug("Cannot generate auth thumb");
				$this->wg->Out->showErrorPage( 'img-auth-accessdenied', 'img-auth-nofile' );
			}
		} else {
			#$this->wg->Out->showErrorPage( $this->wf->Msg('img-auth-accessdenied'), $this->wf->Msg('img-auth-public'));
			$this->displayRestrictionError($this->wg->User);
			$this->skipRendering();
		}

		$this->wf->profileOut( __METHOD__ );
	}
}

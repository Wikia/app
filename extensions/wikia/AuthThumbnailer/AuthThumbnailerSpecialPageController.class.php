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
		$this->controllerData[] = 'foo';
		$this->controllerData[] = 'bar';
		$this->controllerData[] = 'baz';

		// standard SpecialPage constructor call
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

			$path = sprintf( "%s/%s/images", substr( $this->wg->DBname, 0, 1 ), $this->wg->DBname );
			$img_thumb = $this->getVal( 'thumb' );
			$thumb_url = sprintf( "%s/%s/%s", $this->wg->ThumbnailerService, $path, $img_thumb );
			
			$content = Http::get( $thumb_url );
			if ( $content ) {
				$this->wf->ResetOutputBuffers();
				$magic = F::build( 'MimeMagic', array(), 'singleton');
				$ext = strrchr($img_thumb, '.');
				$ext = $ext === false ? '' : strtolower( substr( $ext, 1 ) );				
				$type = $magic->guessTypesForExtension( $ext );
				if ( $type and $type!="unknown/unknown") {
					header("Content-type: $type");
				} else {
					header('Content-type: application/x-wiki');
				}
				echo $content;
				exit;			
			} else {
				$this->wf->debug("Cannot generate auth thumb");
				$this->wg->Out->showErrorPage( $this->wf->Msg('img-auth-accessdenied'), $this->wf->Msg('img-auth-nofile'));
			}
		} else {
			#$this->wg->Out->showErrorPage( $this->wf->Msg('img-auth-accessdenied'), $this->wf->Msg('img-auth-public'));
			$this->displayRestrictionError($this->wg->User);
			$this->skipRendering();
		}

		$this->wf->profileOut( __METHOD__ );
		return false;
	}
}

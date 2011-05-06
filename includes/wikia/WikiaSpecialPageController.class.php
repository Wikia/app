<?php
class WikiaSpecialPageController extends WikiaController {
	protected $specialPage = null;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		$this->specialPage = F::build( 'SpecialPage', array( $name, $restriction, $listed, $function, $file, $includable ) );
	}

	public function execute( $par ) {
		$app = F::build( 'App' );
		$out = $app->getGlobal( 'wgOut' );
		$response = $app->sendRequest( substr( get_class( $this ), 0, -10 ), null, array( 'par' => $par /* to be compatibile with MW core */ ) + $_POST + $_GET, false );

		if( $response->getFormat() == 'html' ) {
			try {
				$out->addHTML( $response->toString() );
			} catch( Exception $exception ) {
				// in case of exception thrown by WikiaView, just render standard error controller response
				$response->setException( $exception );
				$out->addHTML( $app->getView( 'WikiaError', 'error', array( 'response' => $response ) )->render() );
			}
		}
		else {
			// @todo try to refactor it without calling exit
			$response->sendHeaders();
			$response->render();
			exit;
		}
	}

	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->specialPage, $method ), $args );
	}

	public function __get( $propertyName ) {
		return $this->specialPage->$propertyName;
	}

	public function __set( $propertyName, $value ) {
		$this->specialPage->$propertyName = $value;
	}
}

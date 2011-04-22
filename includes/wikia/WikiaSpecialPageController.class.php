<?php
class WikiaSpecialPageController extends WikiaController {
	protected $specialPage = null;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		$this->specialPage = F::build( 'SpecialPage', array( $name, $restriction, $listed, $function, $file, $includable ) );
	}

	public function execute() {
		$app = F::build( 'App' );
		$response = $app->dispatch( ( array( 'controller' => substr( get_class( $this ), 0, -10 ) ) + $_POST + $_GET ) );
		if( $response->getFormat() == 'html' ) {
			$app->getGlobal( 'wgOut' )->addHTML( (string) $response );
		}
		else {
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

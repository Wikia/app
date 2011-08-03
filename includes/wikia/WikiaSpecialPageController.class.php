<?php

/**
 * Nirvana Framework - SpecialPage controller class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaSpecialPageController extends WikiaController {
	protected $specialPage = null;

	public function __construct( $name = '', $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		$this->specialPage = F::build( 'SpecialPage', array( $name, $restriction, $listed, $function, $file, $includable ) );
	}

	public function execute( $par ) {
		$this->app = F::app();
		$out = $this->app->wg->Out;
		$response = $this->sendRequest( get_class( $this ), null, array( 'par' => $par /* to be compatibile with MW core */ ), false );
		$this->response = $response;
		
		if( $response->getFormat() == WikiaResponse::FORMAT_HTML ) {
			try {
				$out->addHTML( $response->toString() );
			} catch( Exception $exception ) {
				// in case of exception thrown by WikiaView, just render standard error controller response
				$response->setException( $exception );
				$out->addHTML( $this->app->getView( 'WikiaError', 'error', array( 'response' => $response, 'devel' => $this->app->wg->DevelEnvironment ) )->render() );
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

	// Override WikiaBaseController magic getter and setter because this is a wrapper for a SpecialPage object
	// Check special page properties first, then Controller properties, then request properties
	public function __get( $propertyName ) {
		if (property_exists($this->specialPage, $propertyName))
			return $this->specialPage->$propertyName;
		else if (property_exists($this, $propertyName))
			return $this->$propertyName;
		else 
			return $this->response->getVal($propertyName);
	}

	// Allow magic setting of template variables so we don't have to do $this->response->setVal
	// Check special page properties first, then Controller properties, then request properties
	public function __set($propertyName, $value) {
		if (property_exists($this->specialPage, $propertyName))
			$this->specialPage->$propertyName = $value;
		else if (property_exists($this, $propertyName))
			$this->$propertyName = $value;
		else 
			$this->response->setVal( $propertyName, $value );
	}
}

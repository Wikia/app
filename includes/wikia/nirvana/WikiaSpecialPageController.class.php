<?php

/**
 * Nirvana Framework - SpecialPage controller class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 *
 * Methods automagically called from SpecialPage class via __call method:
 * @method checkPermissions()
 * @method checkReadOnly()
 * @method displayRestrictionError()
 * @method mixed file( $x = null )
 * @method mixed func( $x = null )
 * #method IContextSource|RequestContext getContext()
 * @method string getDescription()
 * @method string getFile()
 * @method Title getFullTitle()
 * @method Language getLang()
 * @method Language getLanguage()
 * @method string getLocalName()
 * @method string getName()
 * @method OutputPage getOutput()
 * #method WebRequest getRequest()
 * @method string getRestriction()
 * @method Skin getSkin()
 * @method Title getTitle( $subpage = false )
 * @method User getUser()
 * @method mixed includable( $x = null )
 * @method bool including( $x = null )
 * @method bool isExpensive()
 * @method bool isIncludable()
 * @method bool isListed()
 * @method bool isRestricted()
 * @method bool listed( $x = null )
 * @method Message msg()
 * @method mixed name( $x = null )
 * @method outputHeader( $summaryMessageKey = '' )
 * @method mixed restriction( $x = null )
 * #method setContext( IContextSource $context )
 * @method setHeaders()
 * @method bool setListed( $listed )
 * @method bool userCanExecute( User $user )
 * @method void checkIfUserIsBlocked()
 */
class WikiaSpecialPageController extends WikiaController {
	protected $specialPage = null;

	const PAR = 'par';

	public function getPar(){
		return $this->getVal( self::PAR );
	}

	public function __construct( $name = null, $restriction = '', $listed = true, $function = false, $file = 'default', $includable = false ) {
		if ($name == null) {
			throw new WikiaException('First parameter of WikiaSpecialPage constructor must not be null');
		}
		$this->specialPage = new SpecialPage( $name, $restriction, $listed, $function, $file, $includable );
		parent::__construct();
	}

	public function execute( $par ) {
		$params = array_merge( $_GET, $_POST, [
			self::PAR => $par /* to be compatibile with MW core */
		]);
		unset($params['controller']);
		unset($params['method']);

		$response = $this->sendExternalRequest( get_class( $this ), null, $params, WikiaRequest::EXCEPTION_MODE_THROW );
		$this->response = $response;

		if( $response->getFormat() == WikiaResponse::FORMAT_HTML ) {
			try {
				if ( $response->isCaching() ) {
					Wikia::log( __METHOD__, false, $this->specialPage->getName() . ' is an HTML-formatted special page with caching set through the response. Use WikiaSpecialPageController::setVarnishCacheTime instead.' );
				}
				$this->wg->Out->addHTML( $response->toString() );
			} catch( Exception $exception ) {
				// in case of exception thrown by WikiaView, just render standard error controller response
				$response->setException( $exception );
				$this->wg->Out->addHTML( $this->app->getView( 'WikiaError', 'error', array( 'response' => $response, 'devel' => $this->wg->DevelEnvironment ) )->render() );
			}
		}
		else {
			// @todo try to refactor it without calling exit
			$response->sendHeaders();
			$response->render();
			exit;
		}
	}

	/**
	 * This method is used to manually set varnish caching on special pages.
	 * Special pages are sent through OutputPage, and headers set in the request are ignored.
	 * @param int $seconds
	 */
	protected function setVarnishCacheTime( $seconds ) {
		$this->wg->Out->mSquidMaxage = $seconds;
	}

	/**
	 * Any functions that we do not implement, call directly on our specialPage object
	 * @param String $method
	 * @param String $args
	 * @return mixed
	 */
	public function __call( $method, $args ) {
		return call_user_func_array( array( $this->specialPage, $method ), $args );
	}
}

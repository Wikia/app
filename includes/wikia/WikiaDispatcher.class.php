<?php


/**
 * Nirvana Framework - Dispatcher class, this is where all magic happens
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaDispatcher {

	const DEFAULT_METHOD_NAME = 'index';

	/**
	 * @param WikiaRequest $request
	 * @return mixed
	 */
	protected function getMethodName( WikiaRequest $request ) {
		return $request->getVal( 'method', self::DEFAULT_METHOD_NAME );
	}

	/**
	 * @param WikiaRequest $request
	 * @return mixed
	 */
	protected function getControllerName( WikiaRequest $request ) {
		return $request->getVal( 'controller' );
	}

	/**
	 * @param $controllerName
	 * @return null|string
	 */
	protected function getControllerClassName( $controllerName ) {
		return !empty( $controllerName ) ? ( "{$controllerName}Controller" ) : null;
	}

	/**
	 * dispatch the request
	 *
	 * @param WikiaApp $app
	 * @param WikiaRequest $request
	 * @return WikiaResponse
	 */
	public function dispatch( WikiaApp $app, WikiaRequest $request ) {
		$autoloadClasses = $app->wg->AutoloadClasses;
		if (empty($autoloadClasses)) {
			throw new WikiaException( "wgAutoloadClasses is empty, cannot dispatch Request" );
		}
		$format = $request->getVal( 'format', WikiaResponse::FORMAT_HTML );
		$response = F::build( 'WikiaResponse', array( 'format' => $format, 'request' => $request ) );
		if ( $app->wg->EnableSkinTemplateOverride && $app->isSkinInitialized() ) {
			$response->setSkinName( $app->wg->User->getSkin()->getSkinName() );
		}

		// Main dispatch is a loop because Controllers can forward to each other
		// Error condition is also handled via dispatching to the error controller
		do {
			$request->setDispatched(true);

			try {
				$method = $this->getMethodName( $request );
				$controllerName = $this->getControllerName( $request );
				$controllerLegacyName = $app->getControllerLegacyName( $controllerName );
				$controllerClassName = null;

				if (
					(
						$app->isService( $controllerName ) ||
						$app->isController( $controllerName ) ||
						$app->isModule( $controllerName )
					) &&
					!empty( $autoloadClasses[$controllerName] )
				) {
					$controllerClassName = $controllerName;
				}

				if ( empty( $controllerClassName ) ) {
					$controllerClassName = $this->getControllerClassName( $controllerLegacyName );
				}

				if( empty( $controllerClassName ) ) {
					throw new WikiaException( "Invalid controller name: {$controllerName}" );
				}

				$fname = __METHOD__ . " ({$controllerName}_{$method})";

				$app->wf->profileIn($fname);
				$response->setControllerName( $controllerName );
				$response->setMethodName( $method );

				if ( empty( $autoloadClasses[$controllerClassName] ) ) {
					throw new WikiaException( "Controller does not exist: {$controllerClassName}" );
				}

				$controller = F::build( $controllerClassName ); /* @var $controller WikiaController */

				// Temporary remap of executeX methods for modules
				if (!method_exists($controller, $method)) {
					$method = ucfirst( $method );
					$moduleTemplatePath = dirname( $autoloadClasses[$controllerClassName] ) . "/templates/{$controllerName}_{$method}.php";
					$response->getView()->setTemplatePath( $moduleTemplatePath );

					$method = "execute{$method}";
					$params = $request->getParams();
				}

				if (
					( !$request->isInternal() && !$controller->allowsExternalRequests() ) ||
					in_array( $method, array(
						'allowsExternalRequests',
						'getRequest',
						'setRequest',
						'getResponse',
						'setResponse',
						'getApp',
						'setApp',
						'init'
					) ) ||
					!method_exists( $controller, $method ) ||
					!is_callable( array( $controller, $method ) )
				) {
					throw new WikiaException( "Could not dispatch {$controllerClassName}::{$method}" );
				}

				// Initialize the RequestContext object if it is not already set
				// SpecialPageController context is already set by SpecialPageFactory::execute by the time it gets here
				if ($controller->getContext() === null) {
					$controller->setContext( RequestContext::getMain() );
				}

				// If a SpecialPageController is dispatching a request to itself, preserve the original request context
				// TODO: come up with a better fix for this (it's because of the setInstance call in WikiaSpecialPageController)
				$originalRequest = $controller->getRequest();
				$originalResponse = $controller->getResponse();

				$controller->setRequest( $request );
				$controller->setResponse( $response );
				$controller->setApp( $app );
				$controller->init();

				// BugId:5125 - keep old hooks naming convention
				$originalMethod = ucfirst( $this->getMethodName( $request ) );

				$hookResult = $app->runHook( ( "{$controllerName}{$originalMethod}BeforeExecute" ), array( &$controller, &$params ) );

				if ( $controllerName != $controllerLegacyName ) {
					$hookResult = ( $hookResult && $app->runHook( ( "{$controllerLegacyName}{$originalMethod}BeforeExecute" ), array( &$controller, &$params ) ) );
				}

				if ( $hookResult ) {
					$result = $controller->$method( $params );

					if($result === false) {
						// skip template rendering when false returned
						$controller->skipRendering();
					}
				}
				// Preserve original request (this happens for SpecialPageControllers)
				if ($originalRequest != null) {
					$controller->setRequest($originalRequest);
				}
				if ($originalResponse != null) {
					$controller->setResponse($originalResponse);
				}

				$app->runHook( ( "{$controllerName}{$originalMethod}AfterExecute" ), array( &$controller, &$params ) );

				if ( $controllerName != $controllerLegacyName ) {
					$app->runHook( ( "{$controllerLegacyName}{$originalMethod}AfterExecute" ), array( &$controller, &$params ) );
				}
				$app->wf->profileOut($fname);
			} catch ( Exception $e ) {
				$app->wf->profileOut($fname);

				$response->setException($e);
				Wikia::log(__METHOD__, $e->getMessage() );

				if ( $controllerClassName != 'WikiaErrorController' && $method != 'error' ) {
					// Work around for module dispatching until modules are renamed
					$response->getView()->setTemplatePath( null );
					$request->setVal( 'controller', 'WikiaError' );
					$request->setVal( 'method', 'error' );
					$request->setDispatched( false );
				}
			}

		} while ( !$request->isDispatched() );

		if ( $request->isInternal() && $response->hasException() ) {
			Wikia::logBacktrace(__METHOD__ . '::exception');
			throw new WikiaDispatchedException( "Internal Throw ({$response->getException()->getMessage()})", $response->getException() );
		}

		return $response;
	}
}

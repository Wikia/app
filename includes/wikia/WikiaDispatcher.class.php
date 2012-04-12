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

	protected function getMethodName( WikiaRequest $request ) {
		return $request->getVal( 'method', self::DEFAULT_METHOD_NAME );
	}

	protected function getControllerName( WikiaRequest $request ) {
		return $request->getVal( 'controller' );
	}

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

				// Work around for module dispatching until modules are renamed
				if ( empty( $autoloadClasses[$controllerClassName] ) || $app->isModule( $controllerName ) ) {
					$controllerClassName = "{$controllerLegacyName}Module";
					$method = ucfirst( $method );

					if ( !empty( $autoloadClasses[$controllerClassName] ) ) {
						$moduleTemplatePath = dirname( $autoloadClasses[$controllerClassName] ) . "/templates/{$controllerLegacyName}_{$method}.php";
						$response->getView()->setTemplatePath( $moduleTemplatePath );
					}					
					$params = $request->getParams();
				}

				$app->wf->profileIn ( __METHOD__ . " ({$controllerName}_{$method})" );
				$response->setControllerName( $controllerName );
				$response->setMethodName( $method );

				if ( empty( $autoloadClasses[$controllerClassName] ) ) {
					throw new WikiaException( "Controller does not exist: {$controllerClassName}" );
				}

				$controller = F::build( $controllerClassName );

				// Temporary remap of executeX methods for modules
				if ($app->isModule( $controllerClassName ) && !method_exists($controller, $method)) {
					$method = "execute{$method}";
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

				$app->runHook( ( "{$controllerName}{$originalMethod}AfterExecute" ), array( &$controller, &$params ) );

				if ( $controllerName != $controllerLegacyName ) {
					$app->runHook( ( "{$controllerLegacyName}{$originalMethod}AfterExecute" ), array( &$controller, &$params ) );
				}
				$app->wf->profileOut ( __METHOD__ . " ({$controllerName}_{$method})" );
			} catch ( Exception $e ) {
				$app->wf->profileOut ( __METHOD__ . " ({$controllerName}_{$method})" );

				// Work around for errors thrown inside modules -- remove when modules go away
				if ( $response instanceof Module ) {
					$response = F::build( 'WikiaResponse', array( 'format' => $format ) );
				}

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
			throw new WikiaDispatchedException( 'Internal Throw', $response->getException() );
		}

		return $response;
	}
}

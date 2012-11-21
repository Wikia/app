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

				// Determine the "base" name for the controller, stripping off Controller/Service/Module
				$controllerName = $app->getBaseName( $request->getVal( 'controller' ) );
				
				// Service classes must be dispatched by full name otherwise we look for a controller.
				if ($app->isService($request->getVal('controller'))) {
					$controllerClassName = $app->getServiceClassName( $controllerName );
				} else {
					$controllerClassName = $app->getControllerClassName( $controllerName );
				}

				$profilename = __METHOD__ . " ({$controllerName}_{$method})";

				if( empty( $controllerName ) ) {
					throw new WikiaException( "Invalid controller name: {$controllerName}" );
				}

				if ( empty( $autoloadClasses[$controllerClassName] ) ) {
					throw new WikiaException( "Controller class does not exist: {$controllerClassName}" );
				}

				$app->wf->profileIn($profilename);
				$response->setControllerName( $controllerClassName );
				$response->setMethodName( $method );

				$controller = F::build( $controllerClassName ); /* @var $controller WikiaController */

				// map X to executeX method names for things that used to be modules
				if (!method_exists($controller, $method)) {
					$method = ucfirst( $method );
					// This will throw an exception if the template is missing
					// Refactor the offending class to not use executeXYZ methods or set format in request params
					if ($format == WikiaResponse::FORMAT_HTML) {
						$response->getView()->setTemplate( $controllerName, $method );
					}
					$method = "execute{$method}";
					$params = $request->getParams();  // old modules expect params in a different place
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
				$hookMethod = ucfirst( $this->getMethodName( $request ) );

				$hookResult = $app->runHook( ( "{$controllerName}{$hookMethod}BeforeExecute" ), array( &$controller, &$params ) );

				if ( $hookResult ) {
					$result = $controller->$method( $params );

					if($result === false) {
						// skip template rendering when false returned
						$controller->skipRendering();
					}
				}
				// Preserve original request (this is for SpecialPageControllers)
				if ($originalRequest != null) {
					$controller->setRequest($originalRequest);
				}
				if ($originalResponse != null) {
					$controller->setResponse($originalResponse);
				}

				// we ignore the result of the AfterExecute hook
				$app->runHook( ( "{$controllerName}{$hookMethod}AfterExecute" ), array( &$controller, &$params ) );

				$app->wf->profileOut($profilename);
			} catch ( WikiaHttpException $e ) {
				$app->wf->profileOut($profilename);

				if ( !$request->isInternal() ) {
					$response->setFormat( 'json' );
				}

				$response->setHeader(
					'HTTP/1.1',
					$e->getCode(),
					true
				);

				$response->setVal( 'error', get_class( $e ) );

				$details = $e->getDetails();

				if( !empty( $details ) ) {
					$response->setVal( 'message', $details );
				}

			} catch ( Exception $e ) {
				$app->wf->profileOut($profilename);

				$response->setException($e);
				Wikia::log(__METHOD__, $e->getMessage() );

				// if we catch an exception, redirect to the WikiaError controller
				if ( $controllerClassName != 'WikiaErrorController' && $method != 'error' ) {
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

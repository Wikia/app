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
	private $routes = array();

	/**
	 * @param WikiaApp $app
	 * @param WikiaResponse $response
	 * @param string $className Full class name (with Controller/Service suffix)
	 * @param string $methodName Base method name from requeset
	 * @return mixed $callStack if post-controller routing is involved, otherwise false
	 */
	protected function applyRouting( WikiaApp $app, WikiaResponse $response, $className, $methodName ) {

		// PLATFORM-1527: sanitize method name
		$methodName = basename( $methodName );

		// Starting with requested or default method name which is passed in by dispatch
		$response->setControllerName( $className );
		$response->setMethodName( $methodName );
		$callNext = array();

		// Check to see if we have a defined route for this controller to another controller
		if ( isset( $this->routes[$className]["*"])) {
			$route = $this->routes[$className]["*"];
		}
		// Check for method overrides
		else if ( isset( $this->routes[$className][$methodName] ) ) {
			$route = $this->routes[$className][$methodName];
		} else {
			return false;
		}

		// skin routing, also allows possibility to override template
		if ( ( isset( $route['notSkin'] ) && !$app->checkSkin( $route['notSkin'] ) ) ||
			( isset( $route['skin'] ) && $app->checkSkin( $route['skin'] ) ) ){
			if ( isset( $route['controller'] ) ) $response->setControllerName( $route['controller'] );
			if ( isset( $route['method'] ) ) $response->setMethodName( $route['method'] );
			if ( isset( $route['template'] ) ) $response->getView()->setTemplate( $className, $route['template'] );
			if ( isset( $route['after'] ) ) $callNext = $route['after'];
		}
		// global var routing should probably only be for controllers and methods
		if (isset( $route['global'] ) && isset( $app->wg->{$route['global']} ) ) {
			if ( isset( $route['controller'] ) ) $response->setControllerName( $route['controller'] );
			if ( isset( $route['method'] ) ) $response->setMethodName( $route['method'] );
			if ( isset( $route['after'] ) ) $callNext = $route['after'];
		}
		return $callNext;
	}

	public function addRouting( $className, array $routes ) {
		$this->routes[$className] = $routes;
	}

	/**
	 * dispatch the request
	 *
	 * @param WikiaApp $app
	 * @param WikiaRequest $request
	 * @throws WikiaException
	 * @throws Exception
	 * @throws WikiaHttpException
	 * @throws WikiaDispatchedException
	 * @return WikiaResponse
	 */
	public function dispatch( WikiaApp $app, WikiaRequest $request ) {
		wfProfileIn(__METHOD__);
		global $wgAutoloadClasses;
		if (empty($wgAutoloadClasses)) {
			wfProfileOut(__METHOD__);
			throw new WikiaException( "wgAutoloadClasses is empty, cannot dispatch Request" );
		}
		$format = $request->getVal( 'format', WikiaResponse::FORMAT_HTML );
		$response = new WikiaResponse( $format, $request );
		$controller = null;
		$profilename = 'unset';

		// Main dispatch is a loop because Controllers can forward to each other
		// Error condition is also handled via forwarding to the error controller
		do {
			// First time through the loop we skip this section
			// If we got through the dispatch loop and have a nextCall, then call it.
			// Request and Response are re-used, Response data can be optionally reset
			if ( $controller && $controller->hasNext() ) {
				$nextCall = $controller->getNext();
				$request->setVal( 'controller', $nextCall['controller'] );
				$request->setVal( 'method', $nextCall['method'] );
				if ( $nextCall['reset'] ) $response->resetData();
			}

			$profilename = null;
			try {

				// Determine the "base" name for the controller, stripping off Controller/Service/Module
				$controllerName = $app->getBaseName( $request->getVal( 'controller' ) );
				if( empty( $controllerName ) ) {
					throw new WikiaException( "Controller parameter missing or invalid: {$controllerName}" );
				}

				// Service classes must be dispatched by full name otherwise we look for a controller.
				if ($app->isService($request->getVal('controller'))) {
					$controllerClassName = $app->getServiceClassName( $controllerName );
				} else {
					$controllerClassName = $app->getControllerClassName( $controllerName );
				}

				if ( empty( $wgAutoloadClasses[$controllerClassName] ) ) {
					throw new ControllerNotFoundException($controllerName);
				}

				// Determine the final name for the controller and method based on any routing rules
				$callNext = $this->applyRouting( $app, $response, $controllerClassName, $request->getVal( 'method', self::DEFAULT_METHOD_NAME ) );
				$controllerClassName = $response->getControllerName();		// might have been changed
				$controllerName = $app->getBaseName($controllerClassName);  // chop off Service/Controller
				$method = $response->getMethodName();						// might have been changed

				$profilename = __METHOD__ . " ({$controllerClassName}_{$method})";
				wfProfileIn($profilename);

				$controller = new $controllerClassName; /* @var $controller WikiaController */
				$response->setTemplateEngine($controllerClassName::DEFAULT_TEMPLATE_ENGINE);

				// uopz can not override classes returned by new operator when the class name is passed as a string
				global $wgRunningUnitTests;
				if ( $wgRunningUnitTests && function_exists( 'uopz_get_mock' ) ) {
					$instance = uopz_get_mock( $controllerClassName );
					if ( $instance ) {
						$controller  = $instance;
					}
				}

				if ( $callNext ) {
					list ($nextController, $nextMethod, $resetData) = explode("::", $callNext);
					$controller->forward($nextController, $nextMethod, $resetData);
				}
				// map X to executeX method names for things that used to be modules
				if (!method_exists($controller, $method)) {
					$method = ucfirst( $method );
					$hookMethod = $method; // the original module hook naming scheme does not use the "Execute" part

					// This will throw an exception if the template is missing
					// Refactor the offending class to not use executeXYZ methods or set format in request params
					// Warning: this means you can't use the new Dispatcher routing to switch templates in modules
					if ($format == WikiaResponse::FORMAT_HTML) {
						try {
							$response->getView()->setTemplate( $controllerName, $method );
						} catch (WikiaException $e) {
							throw new MethodNotFoundException( "{$controllerClassName}::{$method}" );
						}
					}
					$method = "execute{$method}";
					$params = $request->getParams();  // old modules expect params in a different place
				} else {
					$hookMethod = $method;
					$params = array();
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
					throw new MethodNotFoundException("{$controllerClassName}::{$method}");
				}

				if ( !$request->isInternal() ) {
					$this->testIfUserHasPermissionsOrThrow($app, $controller, $method);
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

				if ( method_exists( $controller, 'preventBlockedUsage' ) && $controller->preventBlockedUsage( $controller->getContext()->getUser(), $method ) ) {
					$result = false;
				} elseif ( method_exists( $controller, 'userAllowedRequirementCheck' ) && $controller->userAllowedRequirementCheck( $controller->getContext()->getUser(), $method ) ) {
					$result = false;
				} else {
					// Actually call the controller::method!
					$result = $controller->$method( $params );
				}

				if($result === false) {
				   // skip template rendering when false returned
				   $controller->skipRendering();
				}

				// Preserve original request (this is for SpecialPageControllers)
				if ($originalRequest != null) {
					$controller->setRequest($originalRequest);
				}
				if ($originalResponse != null) {
					$controller->setResponse($originalResponse);
				}

				// keep the AfterExecute hooks for now, refactor later using "after" dispatching
				$app->runHook( ( "{$controllerName}{$hookMethod}AfterExecute" ), array( &$controller, &$params ) );

				wfProfileOut($profilename);

			} catch ( WikiaHttpException $e ) {
				if ( $request->isInternal() ) {
					//if it is internal call rethrow it so we can apply normal handling

					wfProfileOut(__METHOD__);
					throw $e;

				} else {
					wfProfileOut($profilename);
					$response->setException($e);
					$response->setFormat( 'json' );
					$response->setCode($e->getCode());

					$response->setVal( 'error', get_class( $e ) );

					$details = $e->getDetails();

					if( !empty( $details ) ) {
						$response->setVal( 'message', $details );
					}
				}
			} catch ( Exception $e ) {
				if ($profilename) {
					wfProfileOut($profilename);
				}

				$response->setException($e);

				Wikia\Logger\WikiaLogger::instance()->error(
					__METHOD__ . " - {$controllerClassName} controller dispatch exception",
					[
						'exception' => $e,
						'controller_name' => $controllerClassName,
						'method_name' => $method
					]
				);

				// if we catch an exception, forward to the WikiaError controller unless we are already dispatching Error
				if ( empty($controllerClassName) || $controllerClassName != 'WikiaErrorController' ) {
					$controller = new WikiaErrorController();
					$controller->forward('WikiaError', 'error', false);  // keep params for error controller
					$response->getView()->setTemplatePath( null );  	// response is re-used so skip the original template
				}
			}

		} while ( $controller && $controller->hasNext() );

		if ( $response->hasException() ) {
			$exception = $response->getException();
			\Wikia\Logger\WikiaLogger::instance()->error(
				sprintf( "%s - %s - %s - %s", __METHOD__, 'Exception', get_class( $exception ), $exception->getMessage() ),
				[
					'exception' => $exception
				] );

			switch ( $request->getEffectiveExceptionMode() ) {
				case WikiaRequest::EXCEPTION_MODE_RETURN:
					// noop here
					break;
				case WikiaRequest::EXCEPTION_MODE_THROW:
					wfProfileOut(__METHOD__);
					throw $response->getException();
				case WikiaRequest::EXCEPTION_MODE_WRAP_AND_THROW:
				default:
					wfProfileOut(__METHOD__);
					$ex = $response->getException();
					$ex_class = get_class( $ex );
					throw new WikiaDispatchedException( "Internal Throw ({$ex_class}: {$ex->getMessage()})", $ex );
			}
		}

		wfProfileOut(__METHOD__);
		return $response;
	}

	/**
	 * @param WikiaApp $app
	 * @param $controller WikiaController
	 * @param $method
	 * @throws PermissionsException
	 */
	private function testIfUserHasPermissionsOrThrow( WikiaApp $app, $controller, $method ) {
		$nirvanaAccessRules = WikiaAccessRules::instance();
		$permissions = $nirvanaAccessRules->getRequiredPermissionsFor( get_class( $controller ), $method );
		foreach ( $permissions as $permission ) {
			if ( !( $app->wg->User->isAllowed( $permission ) || $controller->isAnonAccessAllowedInCurrentContext() ) ) {
				throw new PermissionsException( $permission );
			}
		}
	}
}


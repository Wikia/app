<?php
/**
 * Special Page Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

abstract class DataCenterController {

	/* Members */

	// Destinations
	public $types = array();
	public $actions = array();
	public $trail = array();

	/* Abstract Functions */

	public abstract function __construct( array $path );
}

abstract class DataCenterView {

	/* Members */

	protected $controller;

	/* Functions */

	public function __construct( $controller ) {
		$this->controller = $controller;
	}
}

class DataCenterPage extends SpecialPage {

	/* Private Static Members */

	/*
	 * The path given to the special page is a string of text including any text
	 * that was passed through the URL following the name of the special page
	 * and a forward slash. This string is then broken up into parts delimited
	 * by forward slashes and colons, each part of which has a special meaning,
	 * and is placed into an associative array. This array defines the keys of
	 * that array, as well as the order in which the path is interpreted.
	 *
	 * The path is broken up into:
	 * 		part1/part2 ...
	 * Each part is broken up into:
	 * 		part1:part2:part3 ...
	 * So given the current values in the array below:
	 * 		// Shows a page for viewing space #2
	 * 		assets:space:2/view
	 * 		// Shows a page for creating a space inside location #1
	 * 		assets:space/create:1
	 */
	private static $steps = array(
		array( 'page', 'type', 'id' ),
		array( 'action', 'parameter' ),
		array( 'limit', 'offset' ),
	);

	/*
	 * Once the path is interpreted it is determined if the request specified a
	 * page. If the request did not specify a page, the first page in this array
	 * is used. When attempting to construct instances of a page and page user
	 * interface classes that corrospond to the requested page this array is
	 * used as a lookup table to determine if the page exists, and what classes
	 * should be used to create the instances. Finally, the user interface
	 * recieves a copy of this array which is then interpreted as a list of
	 * destinations which is useful in menu generation.
	 */
	private static $pages = array(
		'overview' => array(
			'controller' => 'DataCenterControllerOverview',
			'view' => 'DataCenterViewOverview',
			'display' => true,
		),
		'facilities' => array(
			'controller' => 'DataCenterControllerFacilities',
			'view' => 'DataCenterViewFacilities',
			'types' => array(
				'location' => 'DataCenterViewFacilitiesLocation',
				'space' => 'DataCenterViewFacilitiesSpace',
			),
			'default' => 'location',
			'display' => true,
		),
		'plans' => array(
			'controller' => 'DataCenterControllerPlans',
			'view' => 'DataCenterViewPlans',
			'types' => array(
				'plan' => 'DataCenterViewPlansPlan',
				'rack' => 'DataCenterViewPlansRack',
				'object' => 'DataCenterViewPlansObject',
			),
			'display' => true,
		),
		'assets' => array(
			'controller' => 'DataCenterControllerAssets',
			'view' => 'DataCenterViewAssets',
			'default' => 'object',
			'display' => true,
		),
		'models' => array(
			'controller' => 'DataCenterControllerModels',
			'view' => 'DataCenterViewModels',
			'default' => 'object',
			'display' => true,
		),
		'settings' => array(
			'controller' => 'DataCenterControllerSettings',
			'view' => 'DataCenterViewSettings',
			'types' => array(
				'field' => 'DataCenterViewSettingsField',
			),
			'default' => 'meta',
			'display' => true,
		),
		'search' => array(
			'controller' => 'DataCenterControllerSearch',
			'view' => 'DataCenterViewSearch',
			'display' => false,
		)
	);

	private static $state = array(
		'private' => array( 'last-page' => null ),
		'public' => array()
	);

	private static $path;
	private static $rights;

	/* Private Static Functions */

	private static function urlToSub( $url ) {
		global $wgTitle;
		$start = stripos( $url, $wgTitle->getBaseText() );
		if ( $start !== false ) {
			$url = substr( $url, $start );
			$start = strpos( $url, '/' );
			if ( $start !== false ) {
				return substr( $url, $start );
			}
		}
		return $url;
	}

	private static function subToPath( $sub ) {
		$path = array();
		// Removes leading or trailing slashes, sanitizing hand-entered URLs
		$sub = trim( $sub, '/');
		// Breaks path into into parts
		$pathParts = explode( '/', $sub );
		// Translate "part:part/part:part" into a flat array using steps table
		foreach ( self::$steps as $stepIndex => $stepParts ) {
			if ( isset( $pathParts[$stepIndex] ) ) {
				$pathSubParts = explode( ':', $pathParts[$stepIndex] );
				foreach ( $stepParts as $stepPartIndex => $stepPartName ) {
					if (
						isset( $pathSubParts[$stepPartIndex] ) &&
						 $pathSubParts[$stepPartIndex] != ''
					) {
						$splitPos = strpos( $pathSubParts[$stepPartIndex], ',' );
						if ( $splitPos !== false ) {
							$path[$stepPartName] = explode(
								',', $pathSubParts[$stepPartIndex]
							);
						} else {
							$path[$stepPartName] = $pathSubParts[$stepPartIndex];
						}
					} else {
						$path[$stepPartName] = null;
					}
				}
			} else {
				foreach ( $stepParts as $stepPartName ) {
					$path[$stepPartName] = null;
				}
			}
		}
		return $path;
	}

	private static function loadState() {
		// Checks if state information is in the session
		if ( isset( $_SESSION['DATA_CENTER_STATE'] ) ) {
			// Load state from session
			self::$state = $_SESSION['DATA_CENTER_STATE'];
		} else {
			// Use fallbacks for expected values where possible
			self::$state['private']['last-page'] = $_SERVER['PHP_SELF'];
		}
	}

	private static function saveState() {
		// Automatically keep track of the last page
		self::$state['private']['last-page'] = $_SERVER['PHP_SELF'];
		// Store the state in the user's session
		$_SESSION['DATA_CENTER_STATE'] = self::$state;
	}

	/* Public Static Functions */

	public static function getState( $key ) {
		if ( isset( self::$state['public'][$key] ) ) {
			return self::$state['public'][$key];
		} else {
			return null;
		}
	}

	public static function setState( $key, $value ) {
		self::$state['public'][$key] = $value;
	}

	public static function getRefererPath() {
		return self::subToPath(
			self::urlToSub( self::$state['private']['last-page'] )
		);
	}

	public static function getPath() {
		if ( !self::$path ) {
			self::$path = self::subToPath(
				self::urlToSub( $_SERVER['PHP_SELF'] )
			);
		}
		return self::$path;
	}

	public static function userCan( $action ) {
		if ( is_array( $action ) ) {
			if ( count( $action ) > 0 ) {
				foreach ( $action as $right ) {
					if ( !in_array( 'datacenter-' . $right, self::$rights  ) ) {
						return false;
					}
				}
				return true;
			}
			return false;
		}
		return in_array( 'datacenter-' . $action, self::$rights );
	}

	/* Functions */

	public function __construct() {
		// Initialize special page
		parent::__construct( 'DataCenter' );
		// Internationalization
		wfLoadExtensionMessages( 'DataCenter' );
	}

	public function execute( $sub ) {
		global $wgOut, $wgScriptPath, $wgUser, $wgRequest;
		// Checks if the user is logged in
		if ( !$wgUser->isLoggedIn() ) {
			// Lets them know they need to
			$wgOut->loginToUse();
			// Returns true so MediaWiki can move on
			return true;
		}
		// Gets user rights
		self::$rights = $wgUser->getRights();
		if ( !self::userCan( 'view' ) ) {
			$wgOut->permissionRequired( 'datacenter-view' );
			return true;
		}
		// Keeps some state between pages
		self::loadState();
		// Begins output
		$this->setHeaders();
		// Checks if the path is empty
		if ( $sub == '' ) {
			// Uses the first page in the array as a default
			$sub = current( array_keys( self::$pages ) );
		}
		// Gets path from sub
		$path = self::subToPath( $sub );
		// Verifies page name and parameters
		if ( isset( self::$pages[$path['page']] ) ) {
			// Makes shortcut to page classes
			$pageClasses = self::$pages[$path['page']];
			// Makes shortcut to controller class
			$controllerClass = $pageClasses['controller'];
			// Verifies existence of page class
			if( class_exists( $controllerClass ) ) {
				// Creates instance of page class
				$controller = new $controllerClass( $path );
				// Checks if the view is empty
				if ( $path['action'] === null ) {
					// Uses default action
					$path['action'] = 'main';
				}
				// Checks if the type is empty
				if ( $path['type'] === null ) {
					// Checks if default type is available
					if ( isset( self::$pages[$path['page']]['default'] ) ) {
						// Uses default type
						$path['type'] = self::$pages[$path['page']]['default'];
					}
				}
				// Verifies instance inherited the correct parent class
				if ( $controller instanceof DataCenterController ) {
					// Verifies the current edit token matches any passed token
					$token = $wgRequest->getText( 'token' );
					if ( $wgUser->matchEditToken( $token ) ) {
						// Gets the action to be performed
						$do = $wgRequest->getText( 'do' );
						// Verifies handler is not the instance's constructor and
						// that action exists in the instance
						if (
							$do !== '__constructor' &&
							is_callable( array( $controllerClass, $do ) )
						) {
							if ( $wgRequest->getCheck( 'cancel' ) ) {
								// Redirects to success URL without acting
								$wgOut->redirect(
									$wgRequest->getText( 'cancellation' )
								);
							} else {
								// Gets submitted data
								$data = array(
									'row' => $wgRequest->getArray( 'row' ),
									'meta' => $wgRequest->getArray( 'meta' ),
									'change' => $wgRequest->getArray( 'change' )
								);
								// Delegates handling of form submissions
								$status = $controller->$do(
									$data, $path['type']
								);
								// Checks if status is not null
								if ( $status !== null ) {
									// Redirects to success or failure URL
									$wgOut->redirect(
										$wgRequest->getText(
											$status ? 'success' : 'failure'
										)
									);
								}
							}
						}
					}
					// Sets destinations for menus
					DataCenterUI::setDestinations(
						self::$pages, $controller, $path
					);
					$viewClass = null;
					// Checks if specialized view exists
					if ( isset( $pageClasses['types'][$path['type']] ) ) {
						// Uses specialized view
						$viewClass = $pageClasses['types'][$path['type']];
						// Verifies specialized view can handle action
						$renderFunction = array( $viewClass, $path['action'] );
						if ( !is_callable( $renderFunction ) ) {
							$viewClass = null;
						}
					}
					// Checks if a view class has been not selected yet
					if ( !$viewClass ) {
						// Uses generic view
						$viewClass = $pageClasses['view'];
						// Verifies generic view can handle action
						$renderFunction = array( $viewClass, $path['action'] );
						if ( !is_callable( $renderFunction ) ) {
							$viewClass = null;
						}
					}
					// Verifies page user interface class exists
					if( $viewClass && class_exists( $viewClass ) ) {
						// Creates instance of page user interface class
						$view = new $viewClass( $controller );
						// Verifies the action is not the instance's constructor
						if ( $path['action'] !== '__constructor' ) {
							// Renders view of instance
							$renderFunction = array( $view, $path['action'] );
							DataCenterUI::addContent(
								call_user_func( $renderFunction, $path )
							);
						}
					}
				}
			}
		}
		DataCenterUI::render();
		// Keeps some state between pages
		self::saveState();
	}
}

<?php
/**
 * Interacts with the various metric gathering systems by adding information about handled request context
 */


class TransactionTracer {
	//Transaction names
	const TRANSACTION_PAGE_MAIN = 'page/main';
	const TRANSACTION_PAGE_FILE = 'page/file';
	const TRANSACTION_PAGE_MESSAGE_WALL = 'page/message_wall';
	const TRANSACTION_PAGE_CATEGORY = 'page/category';
	const TRANSACTION_PAGE_OTHER = 'page/other';
	const TRANSACTION_SPECIAL_PAGE = 'special_page';
	const TRANSACTION_RESOURCE_LOADER = 'assets/resource_loader';
	const TRANSACTION_ASSETS_MANAGER = 'assets/assets_manager';
	const TRANSACTION_NIRVANA = 'api/nirvana';
	const TRANSACTION_AJAX = 'api/ajax';
	const TRANSACTION_API = 'api/api';

	//Parameters
	const PARAM_LOGGED_IN = 'logged_in';
	const PARAM_PARSER_CACHE_USED = 'parser_cache_used';
	const PARAM_SIZE_CATEGORY = 'size_category';
	const PARAM_ACTION = 'action';
	const PARAM_SKIN = 'skin';
	const PARAM_VERSION = 'version';
	const PARAM_VIEW_TYPE = 'view_type'; //For Category only
	const PARAM_CONTROLLER = 'controller';
	const PARAM_METHOD = 'method';
	const PARAM_FUNCTION = 'function';
	const PARAM_SPECIAL_PAGE_NAME = 'special_page';
	const PARAM_API_ACTION = 'api_action';

	const PSEUDO_PARAM_TYPE = 'transaction';

	//Definition of different size categories
	const SIZE_CATEGORY_SIMPLE = 'simple';
	const SIZE_CATEGORY_AVERAGE = 'average';
	const SIZE_CATEGORY_COMPLEX = 'complex';

	const ACTION_VIEW = 'view';
	const ACTION_EDIT = 'edit';
	const ACTION_SUBMIT = 'submit';
	const ACTION_OTHER = 'other';

	protected static $IMPORTANT_SPECIAL_PAGES = array(
		'Search',
		'HealthCheck',
		'WikiActivity',
		'Our404Handler',
		'Recentchanges',
		'UserLogin',
		'UserSignup',
		'Chat',
		'Newimages',
	);
	protected static $IMPORTANT_CONTROLLERS = array(
		'Rail',
		'RelatedPagesApi',
		'VideosModule',
		'ArticleComments',
		'WallNotificationsController',
		'JSMessages',
		'WikiaSearchIndexer',
		'LatestActivity',
	);

	protected static $IMPORTANT_AJAX_FUNCTIONS = array(
		'getLinkSuggest',
		'CategoryExhibitionAjax',
		'ChatAjax',
		'ActivityFeedAjax',
		'RTEAjax',
		'EditPageLayoutAjax',
		'WMU',
		'WikiaPhotoGalleryAjax',
	);

	protected static $IMPORTANT_API_CALLS = array(
		'query',
		'opensearch',
		'parse',
		'lyrics',
	);

	protected static $name = null;
	protected static $type = null;
	protected static $attributes = array();

	/**
	 * Sets the name of the transaction currently processed, so the measured times can be categorized
	 *
	 * @param $transactionType String: Name of the current transaction - should be one of the defines TYPE_XXX
	 */
	public static function setType($transactionType) {
		wfDebug(__CLASS__.": transaction type set - ".$transactionType."\n");
		self::$type = $transactionType;

		self::updateName();
	}

	/**
	 * Sets a parameters value so that measured times can be better tracked
	 *
	 * @param $parameterKey String: Name of the parameter. The key should be on of the defines PARAM_XXX
	 * @param $parameterValue String: Value of the parameter
	 */
	public static function setAttribute($parameterKey, $parameterValue) {
		if ( $parameterValue === null ) {
			return;
		}

		wfDebug(__CLASS__.": parameter set - key: ".$parameterKey.", value: ".$parameterValue."\n");
		self::$attributes[$parameterKey] = $parameterValue;

		if ( function_exists( 'newrelic_add_custom_parameter' ) ) {
			if ( is_bool( $parameterValue ) ) {
				$parameterValue = $parameterValue ? "yes" : "no";
			}
			newrelic_add_custom_parameter( $parameterKey, $parameterValue );
		}

		self::updateName();
	}

	protected static function updateName() {
		if ( self::$type !== null ) {
			$transactionName = self::$type;
			$attributes = self::$attributes;

			switch ( self::$type ) {
				// article in main namespace
				case self::TRANSACTION_PAGE_MAIN:
					// action is set
					if ( isset($attributes[self::PARAM_ACTION]) ) {
						$transactionName .= sprintf("/%s", $attributes[self::PARAM_ACTION]);
						// action: view
						if ( $attributes[self::PARAM_ACTION] === self::ACTION_VIEW ) {
							// skin and parser_cached_used flag
							if ( isset($attributes[self::PARAM_SKIN]) && isset($attributes[self::PARAM_PARSER_CACHE_USED]) ) {
								$transactionName .= sprintf("/%s/%s",
									$attributes[self::PARAM_SKIN],
									$attributes[self::PARAM_PARSER_CACHE_USED] ? 'no_parser' : 'parser' );
								// page size
								if ( $attributes[self::PARAM_PARSER_CACHE_USED] === false && isset($attributes[self::PARAM_SIZE_CATEGORY]) ) {
									$transactionName .= sprintf("/%s",
										$attributes[self::PARAM_SIZE_CATEGORY]);
								}
							}
						}
					}
					break;
				// special page
				case self::TRANSACTION_SPECIAL_PAGE:
					// special page name was reported
					if ( isset($attributes[self::PARAM_SPECIAL_PAGE_NAME]) ) {
						$specialPage = $attributes[self::PARAM_SPECIAL_PAGE_NAME];
						// it is an important special page
						if ( in_array($specialPage, self::$IMPORTANT_SPECIAL_PAGES) ) {
							$transactionName .= sprintf("/%s", $specialPage );
						} else {
							$transactionName .= "/other";
						}
					}
					break;
				// nirvana call
				case self::TRANSACTION_NIRVANA:
					// controller was reported
					if ( isset($attributes[self::PARAM_CONTROLLER]) ) {
						$controller = $attributes[self::PARAM_CONTROLLER];
						// it is an important controller
						if ( in_array($controller, self::$IMPORTANT_CONTROLLERS) ) {
							$transactionName .= sprintf("/%s", $controller );
						} else {
							$transactionName .= "/other";
						}
					}
					break;
				// ajax call
				case self::TRANSACTION_AJAX:
					// controller was reported
					if ( isset($attributes[self::PARAM_FUNCTION]) ) {
						$function = $attributes[self::PARAM_FUNCTION];
						// it is an important controller
						if ( in_array($function, self::$IMPORTANT_AJAX_FUNCTIONS) ) {
							$transactionName .= sprintf("/%s", $function );
						} else {
							$transactionName .= "/other";
						}
					}
					break;
				// api.php call
				case self::TRANSACTION_API:
					// controller was reported
					if ( isset($attributes[self::PARAM_API_ACTION]) ) {
						$action = $attributes[self::PARAM_API_ACTION];
						// it is an important controller
						if ( in_array($action, self::$IMPORTANT_API_CALLS) ) {
							$transactionName .= sprintf("/%s", $action );
						} else {
							$transactionName .= "/other";
						}
					}
					break;
			}

			if ( $transactionName !== self::$name ) {
				wfDebug(__CLASS__.": transaction name updated to: \"".$transactionName."\"\n");
				self::$name = $transactionName;
				if ( function_exists( 'newrelic_name_transaction' ) ) {
					newrelic_name_transaction( $transactionName );
				}
			}
		}
	}

	public static function getType() {
		return self::$type;
	}

	public static function getAttributes() {
		return self::$attributes;
	}

	public static function getContext() {
		return array_merge(
			(self::$type !== null) ? array( self::PSEUDO_PARAM_TYPE => self::$type ) : array(),
			self::$attributes
		);
	}

	public static function onArticleViewAddParserOutput( Article $article, ParserOutput $parserOutput ) {
		$wikitextSize = $parserOutput->getPerformanceStats( 'wikitextSize' );
		$htmlSize = $parserOutput->getPerformanceStats( 'htmlSize' );
		$expFuncCount = $parserOutput->getPerformanceStats( 'expFuncCount' );
		$nodeCount = $parserOutput->getPerformanceStats( 'nodeCount' );

		if ( !is_numeric($wikitextSize) || !is_numeric($htmlSize) || !is_numeric($expFuncCount) || !is_numeric($nodeCount) ) {
			return true;
		}

		TransactionTracer::setAttribute( TransactionTracer::PARAM_SIZE_CATEGORY,
			( $wikitextSize < 3000 && $htmlSize < 5000 && $expFuncCount == 0 && $nodeCount < 100 ) ?
				TransactionTracer::SIZE_CATEGORY_SIMPLE : (
			( $wikitextSize < 30000 && $htmlSize < 50000 && $expFuncCount <= 4 && $nodeCount < 3000 ) ?
				TransactionTracer::SIZE_CATEGORY_AVERAGE :
			// else
				TransactionTracer::SIZE_CATEGORY_COMPLEX
			));

		return true;
	}
}
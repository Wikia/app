<?php
/**
 * Interacts with the various metric gathering systems by adding information about handled request context
 */


class MetricManager {
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

	//Definition of different size categories
	const PARAM_SIZE_CATEGORY_SIMPLE = 'simple';
	const PARAM_SIZE_CATEGORY_AVERAGE = 'average';
	const PARAM_SIZE_CATEGORY_COMPLEX = 'complex';

	protected static $transactionType = null;
	protected static $transactionParameters = array();

	/**
	 * Sets the name of the transaction currently processed, so the measured times can be categorized
	 *
	 * @param $transactionType String: Name of the current transaction - should be one of the defines TYPE_XXX
	 */
	public static function setTransactionType($transactionType) {
		wfDebug("MetricManager: transaction type set - ".$transactionType."\n");
		self::$transactionType = $transactionType;

		if ( function_exists( 'newrelic_name_transaction' ) ) {
			newrelic_name_transaction( $transactionType );
		}
	}

	/**
	 * Sets a parameters value so that measured times can be better tracked
	 *
	 * @param $parameterKey String: Name of the parameter. The key should be on of the defines PARAM_XXX
	 * @param $parameterValue String: Value of the parameter
	 */
	public static function setTransactionParameter($parameterKey, $parameterValue) {
		if ( is_bool( $parameterValue ) ) {
			$parameterValue = $parameterValue ? "yes" : "no";
		}

		wfDebug("MetricManager: parameter set - key: ".$parameterKey.", value: ".$parameterValue."\n");
		self::$transactionParameters[$parameterKey] = $parameterValue;

		if ( function_exists( 'newrelic_add_custom_parameter' ) ) {
			newrelic_add_custom_parameter( $parameterKey, $parameterValue );
		}
	}

	public static function getTransactionType() {
		return self::$transactionType;
	}

	public static function getTransactionParameters() {
		return self::$transactionParameters;
	}

	public static function onArticleViewAfterParser( Article $article, ParserOutput $parserOutput ) {

		$wikitextSize = $parserOutput->getPerformanceStats( 'wikitextSize' );
		$htmlSize = $parserOutput->getPerformanceStats( 'htmlSize' );
		$expFuncCount = $parserOutput->getPerformanceStats( 'expFuncCount' );
		$nodeCount = $parserOutput->getPerformanceStats( 'nodeCount' );

		if ( $wikitextSize < 3000 && $htmlSize < 5000 && $expFuncCount == 0 && $nodeCount < 100) {
			MetricManager::setTransactionParameter( MetricManager::PARAM_SIZE_CATEGORY, MetricManager::PARAM_SIZE_CATEGORY_SIMPLE );
		} elseif ( $wikitextSize < 30000 && $htmlSize < 50000 && $expFuncCount <= 4 && $nodeCount < 3000) {
			MetricManager::setTransactionParameter( MetricManager::PARAM_SIZE_CATEGORY, MetricManager::PARAM_SIZE_CATEGORY_AVERAGE );
		} else {
			MetricManager::setTransactionParameter( MetricManager::PARAM_SIZE_CATEGORY, MetricManager::PARAM_SIZE_CATEGORY_COMPLEX );
		}

		return true;
	}
}
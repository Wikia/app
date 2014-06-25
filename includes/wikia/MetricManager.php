<?php
/**
 * Interacts with the various metric gathering systems by adding information about handled request context
 */


class MetricManager {
    //Transaction names
    const TYPE_PAGE_MAIN = '/mw/Page/Main';
    const TYPE_PAGE_SPECIAL = '/mw/Page/Special';
    const TYPE_PAGE_FILE = '/mw/Page/File';
    const TYPE_PAGE_MESSAGE_WALL = '/mw/Page/MessageWall';
    const TYPE_PAGE_CATEGORY = '/mw/Page/Category';
    const TYPE_PAGE_OTHER = '/mw/Page/Other';

    //Parameters
    const PARAM_LOGGED_IN = 'LoggedIn';
    const PARAM_IS_FROM_PARSER_CACHE = 'IsFromParserCache';
    const PARAM_SIZE_CATEGORY = 'SizeCategory';
    const PARAM_ACTION = 'Action';
    const PARAM_SKIN = 'Skin';
    const PARAM_VERSION = 'Version';
    const PARAM_VIEW_TYPE = 'ViewType'; //For Category only

    //Definition of different size categories
    const PARAM_SIZE_CATEGORY_SIMPLE = 'Simple';
    const PARAM_SIZE_CATEGORY_AVERAGE = 'Average';
    const PARAM_SIZE_CATEGORY_COMPLEX = 'Complex';

    /**
     * Sets the name of the transaction currently processed, so the measured times can be categorized
     *
     * @param $transactionType String: Name of the current transaction - should be one of the defines TYPE_XXX
     */
    public static function setTransactionType($transactionType) {

        wfDebug("MetricManager: transaction type set - ".$transactionType."\n");

        if( function_exists( 'newrelic_name_transaction' ) ) {
            newrelic_name_transaction($transactionType);
        }
    }

    /**
     * Sets a parameters value so that measured times can be better tracked
     *
     * @param $parameterKey String: Name of the parameter. The key should be on of the defines PARAM_XXX
     * @param $parameterValue String: Value of the parameter
     */
    public static function setTransactionParameter($parameterKey, $parameterValue) {
        if (is_bool($parameterValue))
            $parameterValue = $parameterValue ? "Yes" : "No";

        wfDebug("MetricManager: parameter set - key: ".$parameterKey.", value: ".$parameterValue."\n");

        if( function_exists( 'newrelic_name_transaction' ) ) {
            newrelic_add_custom_parameter($parameterKey, $parameterValue);
        }
    }
} 
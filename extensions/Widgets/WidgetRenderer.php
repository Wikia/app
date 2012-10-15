<?php
/**
 * Class holding functions for displaying widgets.
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This file is not a valid entry point.";
    exit( 1 );
}

class WidgetRenderer {

public static function renderWidget ( &$parser, $widgetName ) {
	global $IP;

	$smarty = new Smarty;
	$smarty->left_delimiter = '<!--{';
	$smarty->right_delimiter = '}-->';
	$smarty->compile_dir  = "$IP/extensions/Widgets/compiled_templates/";

	// registering custom Smarty plugins
	$smarty->plugins_dir[] = "$IP/extensions/Widgets/smarty_plugins/";

	$smarty->security = true;
	$smarty->security_settings = array(
		'IF_FUNCS' => array(
				'is_array',
				'isset',
				'array',
				'list',
				'count',
				'sizeof',
				'in_array',
				'true',
				'false',
				'null'
				),
		'MODIFIER_FUNCS' => array( 'validate' )
	);

	// register the resource name "db"
	$smarty->register_resource(
		'wiki',
		array(
			array('WidgetRenderer', 'wiki_get_template'),
			array('WidgetRenderer', 'wiki_get_timestamp'),
			array('WidgetRenderer', 'wiki_get_secure'),
			array('WidgetRenderer', 'wiki_get_trusted')
		)
	);

	$params = func_get_args();
	array_shift( $params ); # first one is parser - we don't need it
	array_shift( $params ); # second one is widget name

	$params_tree = array();

	foreach ( $params as $param ) {
		$pair = explode('=', $param, 2);

		if ( count( $pair ) == 2 ) {
			$key = trim($pair[0]);
			$val = trim($pair[1]);
		} else {
			$key = $param;
			$val = true;
		}

		if ( $val == 'false' ) {
			$val = false;
		}

		/* If the name of the parameter has object notation

			a.b.c.d

		   then we assign stuff to hash of hashes, not scalar

		*/
		$keys = explode( '.', $key );

		// $subtree will be moved from top to the bottom and at the end will point to the last level
		$subtree =& $params_tree;

		// go throught all the keys but last one
		$last_key = array_pop( $keys );

		foreach ( $keys as $subkey ) {
			// if next level of subtree doesn't exist yet, create an empty one
			if ( !array_key_exists( $subkey, $subtree ) ) {
				$subtree[$subkey] = array();
			}

			// move to the lower level
			$subtree =& $subtree[$subkey];
		}

		// last portion of the key points to itself
		if ( isset( $subtree[$last_key] ) ) {
			// if already an array, push into it, otherwise, convert into array first
			if ( !is_array( $subtree[$last_key] ) ) {
				$subtree[$last_key] = array( $subtree[$last_key] );
			}

			$subtree[$last_key][] = $val;
		} else {
			// doesn't exist yet, just setting a value
			$subtree[$last_key] = $val;
		}
	}

	$smarty->assign( $params_tree );

	try {
		$output = $smarty->fetch( "wiki:$widgetName" );
	} catch ( Exception $e ) {
		wfLoadExtensionMessages( 'Widgets' );
		return '<div class=\"error\">' . wfMsgExt( 'widgets-desc', array( 'parsemag' ), htmlentities($widgetName) ) . '</div>';
	}

	// Hide the widget from the parser
	$output = 'ENCODED_CONTENT '.base64_encode($output).' END_ENCODED_CONTENT';
	return $output;
}

public static function processEncodedWidgetOutput( &$out, &$text ) {
	// Find all hidden content and restore to normal
	$text = preg_replace(
		'/ENCODED_CONTENT ([0-9a-zA-Z\/+]+=*)* END_ENCODED_CONTENT/esm',
		'base64_decode("$1")',
		$text
	);

	return true;
}

	// the following four functions are all registered with Smarty
	public static function wiki_get_template( $widgetName, &$widgetCode, &$smarty_obj ) {
		global $wgWidgetsUseFlaggedRevs;
	
		$widgetTitle = Title::newFromText($widgetName, NS_WIDGET);
		if ( $widgetTitle && $widgetTitle->exists() ) {
			if ($wgWidgetsUseFlaggedRevs)
			{
				$flaggedWidgetArticle = FlaggedArticle::getTitleInstance( $widgetTitle );
				$flaggedWidgetArticleRevision = $flaggedWidgetArticle->getStableRev();
				if ($flaggedWidgetArticleRevision)
				{
					$widgetCode = $flaggedWidgetArticleRevision->getRevText();
				}
				else
				{
					$widgetCode = '';
				}
			}
			else
			{
				$widgetArticle = new Article( $widgetTitle, 0 );
				$widgetCode = $widgetArticle->getContent();
			}

			// Remove <noinclude> sections and <includeonly> tags from form definition
			$widgetCode = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $widgetCode );
			$widgetCode = strtr( $widgetCode, array( '<includeonly>' => '', '</includeonly>' => '' ) );

			return true;
		} else {
			return false;
		}
	}

	public static function wiki_get_timestamp( $widgetName, &$widgetTimestamp, &$smarty_obj ) {
		$widgetTitle = Title::newFromText( $widgetName, NS_WIDGET );
		if ($widgetTitle && $widgetTitle->exists()) {
			$widgetArticle = new Article( $widgetTitle, 0 );
			$widgetTimestamp = $widgetArticle->getTouched();

			return true;
		} else {
			return false;
		}
	}

	public static function wiki_get_secure( $tpl_name, &$smarty_obj ) {
		// assume all templates are secure
		return true;
	}

	public static function wiki_get_trusted( $tpl_name, &$smarty_obj ) {
		// not used for templates
	}

}

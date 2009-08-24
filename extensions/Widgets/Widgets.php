<?php
/**
 *
 * {{#widget:<WidgetName>|<name1>=<value1>|<name2>=<value2>}}
 *
 * @author Sergey Chernyshev
 * @version $Id: Widgets.php 15 2008-06-25 21:22:40Z sergey.chernyshev $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This file is not a valid entry point.";
    exit( 1 );
}

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Widgets',
        'description' => 'Allows wiki administrators to add free-form widgets to wiki by just editing pages within Widget namespace. Originally developed for [http://www.ardorado.com Ardorado.com]',
	'version' => '0.8.6',
        'author' => '[http://www.sergeychernyshev.com Sergey Chernyshev] (for [http://www.semanticcommunities.com Semantic Communities LLC.])',
        'url' => 'http://www.mediawiki.org/wiki/Extension:Widgets'
);

/**
 * Set this to the index of the Widget namespace
 */
if ( !defined( 'NS_WIDGET' ) ) {
   define( 'NS_WIDGET', 274 );
}
if ( !defined( 'NS_WIDGET_TALK' ) ) {
   define( 'NS_WIDGET_TALK', NS_WIDGET + 1 );
} elseif ( NS_WIDGET_TALK != NS_WIDGET + 1 ) {
   throw new MWException( 'Configuration error. Do not define NS_WIDGET_TALK, it is automatically set based on NS_WIDGET.' );
}

// Initialize Smarty
require dirname(__FILE__)."/smarty/Smarty.class.php";

// Parser function registration
$wgExtensionFunctions[] = 'widgetNamespacesInit';
$wgHooks['LanguageGetMagic'][] = 'widgetLanguageGetMagic';
$wgHooks['ParserFirstCallInit'][] = 'widgetParserFunctions';

function widgetParserFunctions( &$parser )
{
    $parser->setFunctionHook('widget', 'renderWidget');

    return true;
}

function widgetLanguageGetMagic( &$magicWords, $langCode = "en" )
{
	switch ( $langCode ) {
	default:
		$magicWords['widget']	= array ( 0, 'widget' );
	}
	return true;
}

function renderWidget (&$parser, $widgetName)
{
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
		'MODIFIER_FUNCS' => array('validate')
	);

	// register the resource name "db"
	$smarty->register_resource("wiki", array("wiki_get_template",
					       "wiki_get_timestamp",
					       "wiki_get_secure",
					       "wiki_get_trusted"));

        $params = func_get_args();
        array_shift($params); # first one is parser - we don't need it
        array_shift($params); # second one is widget name

	$params_tree = array();

        foreach ($params as $param)
        {
                $pair = explode('=', $param, 2);

                if (count($pair) == 2)
                {
			$key = trim($pair[0]);
			$val = trim($pair[1]);
		}
		else
		{
			$key = $param;
			$val = true;
		}

		if ($val == 'false')
		{
			$val = false;
		}

		/* If the name of the parameter has object notation

			a.b.c.d

		   then we assign stuff to hash of hashes, not scalar

		*/
		$keys = explode('.', $key);

		// $subtree will be moved from top to the bottom and at the end will point to the last level
		$subtree =& $params_tree;

		// go throught all the keys but last one
		$last_key = array_pop($keys);

		foreach ($keys as $subkey)
		{
			// if next level of subtree doesn't exist yet, create an empty one
			if (!array_key_exists($subkey, $subtree))
			{
				$subtree[$subkey] = array();
			}

			// move to the lower level
			$subtree =& $subtree[$subkey];
		}

		// last portion of the key points to itself
		if (isset($subtree[$last_key]))
		{
			// if already an array, push into it, otherwise, convert into array first
			if (!is_array($subtree[$last_key]))
			{
				$subtree[$last_key] = array($subtree[$last_key]);
			}

			$subtree[$last_key][] = $val;
		}
		else
		{
			// doesn't exist yet, just setting a value
			$subtree[$last_key] = $val;
		}
        }

	$smarty->assign($params_tree);

	try
	{
		$output = $smarty->fetch("wiki:$widgetName");
	}
	catch (Exception $e)
	{
		return "<div class=\"error\">Error in [[Widget:$widgetName]]</div>";
	}

	return $parser->insertStripItem( $output, $parser->mStripState );
}

function widgetNamespacesInit() {
	global $wgExtraNamespaces, $wgNamespacesWithSubpages,
			$wgGroupPermissions, $wgNamespaceProtection;

	// Register namespace identifiers
	if (!is_array($wgExtraNamespaces)) { $wgExtraNamespaces=array(); }
	$wgExtraNamespaces = $wgExtraNamespaces + array(NS_WIDGET => 'Widget', NS_WIDGET_TALK => 'Widget_talk');

	// Support subpages only for talk pages by default
	$wgNamespacesWithSubpages = $wgNamespacesWithSubpages + array(
		      NS_WIDGET_TALK => true
	);

	// Assign editing to 3idgeteditor group only (widgets can be dangerous so we do it here, not in LocalSettings)
	$wgGroupPermissions['*']['editwidgets'] = false;
	$wgGroupPermissions['widgeteditor']['editwidgets'] = true;

	// Setting required namespace permission rights
	$wgNamespaceProtection[NS_WIDGET] = array( 'editwidgets' );
}

// put these function somewhere in your application
function wiki_get_template ($widgetName, &$widgetCode, &$smarty_obj)
{
	$widgetTitle = Title::newFromText($widgetName, NS_WIDGET);
	if ($widgetTitle && $widgetTitle->exists())
	{
		$widgetArticle = new Article($widgetTitle, 0);
		$widgetCode = $widgetArticle->getContent();

		// Remove <noinclude> sections and <includeonly> tags from form definition
		$widgetCode = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $widgetCode);
		$widgetCode = strtr($widgetCode, array('<includeonly>' => '', '</includeonly>' => ''));

		return true;
	}
	else
	{
		return false;
	}
}

function wiki_get_timestamp($widgetName, &$widgetTimestamp, &$smarty_obj)
{
	$widgetTitle = Title::newFromText($widgetName, NS_WIDGET);
	if ($widgetTitle && $widgetTitle->exists())
	{
		$widgetArticle = new Article($widgetTitle, 0);
		$widgetTimestamp = $widgetArticle->getTouched();

		return true;
	}
	else
	{
		return false;
	}
}

function wiki_get_secure($tpl_name, &$smarty_obj)
{
    // assume all templates are secure
    return true;
}

function wiki_get_trusted($tpl_name, &$smarty_obj)
{
    // not used for templates
}


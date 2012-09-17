<?php
/**********************************************************************************
Copyright (C) 2007-08 Sean Colombo (sean@lyricwiki.org)
Copyright (C) 2007-08 Bradley Pesicka (teknomunk@bluebottle.com)


This extension will provide optional (and sometimes automatically-generated) templates to create most information for
a new page for LyricWiki.

To install, put this script in the /extensions/ directory in MediaWiki then add the following line to the
LocalSettings.php file (it's in the main directory, not in extensions):
require_once("extensions/Templates.php");


Tested on
# MediaWiki: 1.7.1, 1.11.1

***********************************************************************************

Changelog:

0.1.4 2008-10-28
 * Added a default template for _talk pages (because of the page-ranking system).

0.1.3	2008-03-03
* Split messages off to separate file - teknomunk
* BUGFIX: no longer functions outside the main namespace - teknomunk
* BUGFIX: no longer returns &lt;SongTemplate&gt; if the system message associated with the template does not exist - teknomunk

0.1.2	2007-12-12
* modify to get templates from database instead of hardcoding them to allow administrator edits - teknomunk

0.1.1	2007-04-05
* create - Sean Colombo

*/

///////////////////////////////////////////////////////////////////////////////
// Extension Credits Definition
if(isset($wgScriptPath)){
	$wgExtensionCredits["parserhook"][] = array(
	  'name' => 'LyricWiki New-Page Templates Extension',
	  'version' => '0.1.3',
	  'url' => 'http://lyrics.wikia.com/User:Sean_Colombo',
	  'author' => '[http://www.seancolombo.com Sean Colombo]',
	  'description' => 'Creates basic templates for new-pages to make adding easier for new users and quicker all around.'
	);
}

require_once 'Parser_LWMagicWords.php';
require_once 'extras.php';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['lwTemplates'] = $dir.'Templates.i18n.php';
$wgHooks['EditFormPreloadText'][] = array('lw_templatePreload');

/**
 * Fills the textbox of a new page with content.
 */
function lw_templatePreload(&$textbox, Title &$title)
{
	$lwVars = getLyricWikiVariables();

	$titleStr = $title->getText();

	// only use templates in the main namespace
	$ns = $title->getNamespace();
	if(($ns != NS_MAIN) && ($ns != NS_TALK)){
		return true;
	}

	$tempType = "";
	$pageType = "";
	if(isset($_GET['template']))
	{
		$pageType = strtolower($_GET['template']);
	}
	if( $pageType == "" )
	{
		$pageType = $lwVars["pagetype"];
	}

	# pull template from database and replace placeholds
	if( $pageType == "none" )
	{
		$textbox = "";
	}
	else
	{
		$extra = trim(wfMsgForContentNoTrans("lwtemp-extra-templates"));
		if( $extra != "" )
		{
			$extras = explode("\n",$extra);
			foreach($extras as $item)
			{
				if( strpos($item,"|") )
				{
					$parts = explode("|",$item);
					if( 0 < preg_match("/{$parts[0]}/",$titleStr,$m) )
					{
						$pageType = $parts[1];
					}
				}
			}
		}
		$template = wfMsgForContentNoTrans("lwtemp-{$pageType}-template");

		// only display a template if the template actually exists
		if( $template != "<{$pageType}Template>" and $template != "&lt;{$pageType}Template&gt;" )
		{
			$textbox = $template;
			$lwVars = getLyricWikiVariables();

			$replace = array();
			$with = array();

			foreach( $lwVars as $key=>$value )
			{
				$replace[] = "{{".strtoupper($key)."}}";
				$with[] = $value;
			}

			$textbox = str_replace( $replace, $with, $textbox );
		}
	}
	return true;
} // end lw_templatePreload()

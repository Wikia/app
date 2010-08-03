<?php

/**
 * A MediaWiki extension that adds a Specialpage for Chemical sources.
 *
 * The i18n file is required for operation!
 * Installation: copy this file and ChemFunctions.i18n.php into the extensions directory
 *   and add 'require_once( "$IP/extensions/SpecialChemicalsources.php" );' to localsettings.php (using the correct path)
 *
 * i18n is retrieved from ChemFunctions.i18n.php
 * wfSpecialChemicalSources (adds the specialpage)
 * Class SpecialChemicalsources is an extension of SpecialPage
 * Parameter checking is performed in the function "TransposeAndCheckParams"
 *
 * @addtogroup SpecialPage
 * @addtogroup Extensions
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Adapting this listpage to your own listpage
 *
 * 1) Write your own i18n file (see instructions there)
 * 2) copy this file to the name of your specialpage, and in that file:
 * 3) make the line "require_once( 'ChemFunctions.i18n.php' );" call your i18n file
 * 4) Replace all the occurences of the word 'chemicalsources' with the name of your specialpage
 * 5) Replace every occurence of the word ChemFunctions with your chosen prefix from your i18n.
 * 6) rewrite the function TransposeAndCheckParams
 *	  You will get a list $Params which contains: $Params['paramname']='value'
 *	  You have to return a list which contains: $transParams['thestringtoreplaceinyourpage'] = 'withwhatitshouldbereplaced'
 */

if (!defined('MEDIAWIKI')) die();

# Credentials.
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Special:Chemicalsources',
	'svn-date' => '$LastChangedDate: 2008-09-04 16:56:36 +0200 (czw, 04 wrz 2008) $',
	'svn-revision' => '$LastChangedRevision: 40434 $',
	'description' => '[[Special:Chemicalsources|Special page]] for Chemical sources',
	'author' => 'Dirk Beetstra',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Chemistry/ChemFunctions.php'
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['SpecialChemicalsources'] = $dir . 'SpecialChemicalsources_body.php';
$wgExtensionMessagesFiles['SpecialChemicalsources'] = $dir . 'ChemFunctions.i18n.php';
$wgExtensionAliasesFiles['ChemicalSources'] = $dir . 'ChemicalSources.alias.php';
$wgSpecialPages['ChemicalSources'] = 'SpecialChemicalsources';

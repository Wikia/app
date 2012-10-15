<?php
/**
 * WikiCitation extension for Mediawiki.
 *
 * The extension implements a parser function to create and use citations
 * in various styling standards, such as the Chicago Manual of Style, MLA, APA,
 * Bluebook, etc.
 * A citation has the following Backus-Naur form:
 * @code
 * <citation>   ::= "{{#cite:" <data> "}}"
 * <data>       ::= <flags> "|" <parameters>
 *                | <parameters>
 * <flags>      ::= <flag>
 *                | <flag> "|" <flags>
 * <parameters> ::= <parameter>
 *                | <parameter> "|" <parameters>
 * @endcode
 * 
 * By default, the first citation to any reference is cited in "long" form, while
 * any subsequent citations are in "short" form. However, "long" and "short" citations
 * can be forced by the use of "long" and "short" as flags.
 * 
 * The extension also implements the following tag extension (in English):
 * @code
 * <biblio style="..." type="...">...</biblio>
 * @endcode
 * where the style and type attributes define the citation style (e.g.
 * Chicago Manual of style) and type (e.g., author-date). Citations within
 * this biblio tag will be sorted alphabetically.
 * For more detailed documentation, see the extension's MediaWiki entry at
 * http://www.mediawiki.org/wiki/Extension:WikiCitation
 *
 * The extension also implements the following tag extension for endnotes:
 * @code
 * <note style="..." type="...">...</note>
 * @endcode
 * where the style and type attributes define the style of citaitons within
 * the endnote. By default, citations within notes follow the "note" style.
 * 
 * @defgroup WikiCitation
 * @author 'COGDEN' and others
 * @copyright Copyright (c) 2011 by authors
 * @license http://www.gnu.org/copyright/gpl.html
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * See http://www.gnu.org/copyright/gpl.html
 */

/**
 * Setup file for WikiCitation extension.
 *
 * @file
 */


if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "Not a valid entry point.\n" );
	die( 1 );
}


$wgExtensionCredits[ 'parserhook' ][] = array(
	'path' => __FILE__,
	'name' => 'WikiCitation',
	'author' => array( 'COGDEN' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiCitation',
	'descriptionmsg' => 'wc-description',
	'version' => '0.8.1'
);


/**
 * Global settings
 */

/**
 * This variable determines whether citation parameters are validated ( = True )
 * or simply ignored ( = False ).
 * @var boolean
 */
$wikiCitationValidateArguments = False;

/**
 * Setting to define allowable referencing styles, and to set the default style.
 *
 * Array of recognized children of WCCitation, keyed to magic words used to
 * invoke that style. For example, the magic word 'wc_Chicago'
 * ('Chicago' in English) is keyed to the class 'WCChicagoStyle'
 *
 * To disallow particular styles, comment them out or remove them from this
 * list. The magic word 'wc_default' is keyed to the default style.
 * @var
 */
$wgWCCitationStyles = array(
	'wc_default' => 'WCChicagoStyle', # default style is defined here
	'wc_Chicago' => 'WCChicagoStyle',
	'wc_Bluebook' => 'WCBluebookStyle',
);

# Location of the CSS style sheet for this extension
$wgWCStyleSheet = $wgScriptPath . '/extensions/WikiCitation/WikiCitation.css';


/**
 * Autoload classes
 */
$mDir = dirname(__FILE__);

# main directory
$wgAutoloadClasses['WikiCitation'] = $mDir . '/WikiCitation.body.php';

# Styles
$wgAutoloadClasses['WCChicagoStyle'] = $mDir . '/styles/WCChicagoStyle.php';
$wgAutoloadClasses['WCBluebookStyle'] = $mDir . '/styles/WCBluebookStyle.php';

# includes
$wgAutoloadClasses['WCArgumentReader'] = $mDir . '/includes/WCArgumentReader.php';
$wgAutoloadClasses['WCArticle'] = $mDir . '/includes/WCArticle.php';
$wgAutoloadClasses['WCBibliography'] = $mDir . '/includes/WCBibliography.php';
$wgAutoloadClasses['WCCitation'] = $mDir . '/includes/WCCitation.php';
  $wgAutoloadClasses['WCCitationPosition'] = $mDir . '/includes/WCCitation.php';
$wgAutoloadClasses['WCEnum'] = $mDir . '/includes/WCEnum.php';
$wgAutoloadClasses['WCException'] = $mDir . '/includes/WCException.php';
$wgAutoloadClasses['WCNote'] = $mDir . '/includes/WCNote.php';
$wgAutoloadClasses['WCReference'] = $mDir . '/includes/WCReference.php';
$wgAutoloadClasses['WCReferenceStore'] = $mDir . '/includes/WCReferenceStore.php';
$wgAutoloadClasses['WCSection'] = $mDir . '/includes/WCSection.php';
$wgAutoloadClasses['WCStyle'] = $mDir . '/includes/WCStyle.php';

# data
$wgAutoloadClasses['WCData'] = $mDir . '/includes/data/WCData.php';
$wgAutoloadClasses['WCDate'] = $mDir . '/includes/data/WCDate.php';
$wgAutoloadClasses['WCLocator'] = $mDir . '/includes/data/WCLocator.php';
$wgAutoloadClasses['WCName'] = $mDir . '/includes/data/WCName.php';
$wgAutoloadClasses['WCNames'] = $mDir . '/includes/data/WCNames.php';
$wgAutoloadClasses['WCTypeData'] = $mDir . '/includes/data/WCTypeData.php';
$wgAutoloadClasses['WCText'] = $mDir . '/includes/data/WCText.php';
$wgAutoloadClasses['WCTitle'] = $mDir . '/includes/data/WCTitle.php';
$wgAutoloadClasses['WCTitleFormat'] = $mDir . '/includes/data/WCTitle.php';

# parameters
$wgAutoloadClasses['WCAttributeEnum'] = $mDir . '/includes/parameters/WCAttributeEnum.php';
$wgAutoloadClasses['WCCitationLengthEnum'] = $mDir . '/includes/parameters/WCCitationLengthEnum.php';
$wgAutoloadClasses['WCCitationTypeEnum'] = $mDir . '/includes/parameters/WCCitationTypeEnum.php';
$wgAutoloadClasses['WCDateTermsEnum'] = $mDir . '/includes/parameters/WCDateTermsEnum.php';
$wgAutoloadClasses['WCNamePartEnum'] = $mDir . '/includes/parameters/WCNamePartEnum.php';
$wgAutoloadClasses['WCNameTypeEnum'] = $mDir . '/includes/parameters/WCNameTypeEnum.php';
$wgAutoloadClasses['WCParameterEnum'] = $mDir . '/includes/parameters/WCParameterEnum.php';
$wgAutoloadClasses['WCPropertyEnum'] = $mDir . '/includes/parameters/WCPropertyEnum.php';
$wgAutoloadClasses['WCScopeEnum'] = $mDir . '/includes/parameters/WCScopeEnum.php';
$wgAutoloadClasses['WCSourceTypeEnum'] = $mDir . '/includes/parameters/WCSourceTypeEnum.php';

# segments
$wgAutoloadClasses['WCAlternativeSegment'] = $mDir . '/includes/segments/WCAlternativeSegment.php';
$wgAutoloadClasses['WCConditionalSegment'] = $mDir . '/includes/segments/WCConditionalSegment.php';
$wgAutoloadClasses['WCDataSegment'] = $mDir . '/includes/segments/WCDataSegment.php';
$wgAutoloadClasses['WCDateSegment'] = $mDir . '/includes/segments/WCDateSegment.php';
$wgAutoloadClasses['WCGroupSegment'] = $mDir . '/includes/segments/WCGroupSegment.php';
$wgAutoloadClasses['WCLabelFormEnum'] = $mDir . '/includes/segments/WCLabelSegment.php';
$wgAutoloadClasses['WCLabelSegment'] = $mDir . '/includes/segments/WCLabelSegment.php';
$wgAutoloadClasses['WCLiteralSegment'] = $mDir . '/includes/segments/WCLiteralSegment.php';
$wgAutoloadClasses['WCLocatorSegment'] = $mDir . '/includes/segments/WCLocatorSegment.php';
$wgAutoloadClasses['WCNamesSegment'] = $mDir . '/includes/segments/WCNamesSegment.php';
$wgAutoloadClasses['WCSegment'] = $mDir . '/includes/segments/WCSegment.php';
$wgAutoloadClasses['WCTextSegment'] = $mDir . '/includes/segments/WCTextSegment.php';
$wgAutoloadClasses['WCTitleSegment'] = $mDir . '/includes/segments/WCTitleSegment.php';
$wgAutoloadClasses['WCWrapperSegment'] = $mDir . '/includes/segments/WCWrapperSegment.php';


/**
 * Localization files
 */
$wgExtensionMessagesFiles['WikiCitation'] = $mDir . '/WikiCitation.i18n.php';
$wgExtensionMessagesFiles['WikiCitationMagic'] = $mDir . '/WikiCitation.i18n.magic.php';


/**
 * Set up parser hooks.
 */
$wgHooks[ 'ParserFirstCallInit' ][] = 'WikiCitation::onParserFirstCallInit';
$wgHooks[ 'ParserClearState' ][] = 'WikiCitation::onParserClearState';
$wgHooks[ 'ParserBeforeTidy' ][] = 'WikiCitation::onParserBeforeTidy';


/**
 * Set up parser test file.
 */
#$wgParserTestFiles[] = $mDir . "/WikiCitationTests.txt";

<?php
# Copyright (C) 2009 Ryan Lane <rlane32+mwext@gmail.com>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
# http://www.gnu.org/copyleft/gpl.html

# Based off of the Gadgets and SmoothGallery extensions

if ( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Add extension information to Special:Version
 */
$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Plotter parser extension',
	'version'        => '0.6d',
	'author'         => 'Ryan Lane',
	'descriptionmsg' => 'plotters-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Plotters',
);

$wgHooks['ParserFirstCallInit'][] = 'efPlottersSetHooks';
$wgHooks['OutputPageParserOutput'][] = 'PlottersParserOutput';
$wgHooks['ArticleSaveComplete'][] = 'wfPlottersArticleSaveComplete';

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['Plotters'] = $dir . 'Plotters.i18n.php';
$wgExtensionMessagesFiles['PlottersAlias'] = $dir . 'Plotters.alias.php';
$wgExtensionMessagesFiles['PlottersMagic'] = $dir . 'Plotters.magic.php';
$wgAutoloadClasses['Plotters'] = $dir . 'PlottersClass.php';
$wgAutoloadClasses['PlottersParser'] = $dir . 'PlottersParser.php';
$wgAutoloadClasses['SpecialPlotters'] = $dir . 'SpecialPlotters.php';
$smwgResultFormats['plot'] = 'SRFPlotters';
$wgAutoloadClasses['SRFPlotters'] = $dir . 'SRF_Plotters.php';
$wgSpecialPages['Plotters'] = 'SpecialPlotters';
$wgSpecialPageGroups['Plotters'] = 'wiki';

// sane defaults. always initialize to avoid register_globals vulnerabilities
$wgPlottersExtensionPath = $wgScriptPath . '/extensions/Plotters';
$wgPlottersJavascriptPath = $wgScriptPath . '/extensions/Plotters';
$wgPlottersRendererFiles = array( "plotkit" => array( "/mochikit/MochiKit.js", "/plotkit/Base.js", "/plotkit/Layout.js",
							"/plotkit/Canvas.js", "/plotkit/SweetCanvas.js" )
				);

function wfPlottersArticleSaveComplete( $article, $wgUser, $text ) {
	// update cache if MediaWiki:Plotters-definition was edited
	$title = $article->mTitle;
	if ( $title->getNamespace() == NS_MEDIAWIKI && $title->getText() == 'Plotters-definition' ) {
		wfLoadPlottersStructured( $text );
	}
	return true;
}

function wfLoadPlotters() {
	static $plotters = null;

	if ( $plotters !== null ) return $plotters;

	$struct = wfLoadPlottersStructured();
	if ( !$struct ) {
		$plotters = $struct;
		return $plotters;
	}

	$plotters = array();
	foreach ( $struct as $section => $entries ) {
		$plotters = array_merge( $plotters, $entries );
	}

	return $plotters;
}

function wfLoadPlottersStructured( $forceNewText = null ) {
	global $wgMemc;

	static $plotters = null;
	if ( $plotters !== null && $forceNewText !== null ) return $plotters;

	$key = wfMemcKey( 'plotters-definition' );

	if ( $forceNewText === null ) {
		// cached?
		$plotters = $wgMemc->get( $key );
		if ( is_array( $plotters ) ) return $plotters;

		$p = wfMsgForContentNoTrans( "plotters-definition" );
		if ( wfEmptyMsg( "plotters-definition", $p ) ) {
			$plotters = false;
			return $plotters;
		}
	} else {
		$p = $forceNewText;
	}

	$p = preg_replace( '/<!--.*-->/s', '', $p );
	$p = preg_split( '/(\r\n|\r|\n)+/', $p );

	$plotters = array();
	$section = '';

	foreach ( $p as $line ) {
		if ( preg_match( '/^==+ *([^*:\s|]+?)\s*==+\s*$/', $line, $m ) ) {
			$section = $m[1];
		}
		elseif ( preg_match( '/^\*+ *([a-zA-Z](?:[-_:.\w\d ]*[a-zA-Z0-9])?)\s*((\|[^|]*)+)\s*$/', $line, $m ) ) {
			// NOTE: the plotter name is used as part of the name of a form field,
			//      and must follow the rules defined in http://www.w3.org/TR/html4/types.html#type-cdata
			//      Also, title-normalization applies.
			$name = str_replace( ' ', '_', $m[1] );

			$code = preg_split( '/\s*\|\s*/', $m[2], - 1, PREG_SPLIT_NO_EMPTY );

			if ( $code ) {
				$plotters[$section][$name] = $code;
			}
		}
	}

	// cache for a while. gets purged automatically when MediaWiki:Plotters-definition is edited
	$wgMemc->set( $key, $plotters, 60 * 60 * 24 );
	$source = $forceNewText !== null ? 'input text' : 'MediaWiki:Plotters-definition';
	wfDebug( __METHOD__ . ": $source parsed, cache entry $key updated\n" );

	return $plotters;
}

function wfApplyPlotterCode( $code, $out, &$done ) {
	global $wgSkin, $wgJsMimeType;

	// FIXME: stuff added via $out->addScript appears below usercss and userjs in the head tag.
	//       but we'd want it to appear above explicit user stuff, so it can be overwritten.
	foreach ( $code as $codePage ) {
		// include only once
		if ( isset( $done[$codePage] ) ) continue;
		$done[$codePage] = true;

		$t = Title::makeTitleSafe( NS_MEDIAWIKI, "Plotters-$codePage" );
		if ( !$t ) continue;

		if ( preg_match( '/\.js/', $codePage ) ) {
			$u = $t->getLocalURL( 'action=raw&ctype=' . $wgJsMimeType );
			$out->addScript( '<script type="' . $wgJsMimeType . '" src="' . htmlspecialchars( $u ) . '"></script>' . "\n" );
		}
		elseif ( preg_match( '/\.css/', $codePage ) ) {
			$u = $t->getLocalURL( 'action=raw&ctype=text/css' );
			$out->addScript( '<style type="text/css">/*<![CDATA[*/ @import "' . $u . '"; /*]]>*/</style>' . "\n" );
		}
	}
}

function efPlottersSetHooks( $parser ) {
	$parser->setHook( 'plot', 'initPlotters' );
	$parser->setFunctionHook( 'plot', 'initPlottersPF' );
	return true;
}

function initPlottersPF( $parser ) {
	$numargs = func_num_args();
	if ( $numargs < 2 ) {
		$input = wfMsg( "plotters-errors" ) . " " . wfMsg( "plotters-missing-arguments" );
		return str_replace( '§', '<', '§pre>§nowiki>' . $input . '§/nowiki>§/pre>' );
	}

	// fetch all user-provided arguments (skipping $parser)
	$input = "";
	$argv = array();
	$arg_list = func_get_args();
	for ( $i = 1; $i < $numargs; $i++ ) {
		$p1 = $arg_list[$i];

		$aParam = explode( '=', $p1, 2 );
		if ( count( $aParam ) < 2 ) {
			continue;
		}
		Plotters::debug( 'plot tag parameter: ', $aParam );
		if ( $aParam[0] == "data" ) {
			$input = $aParam[1];
			continue;
		}
		$sKey = trim( $aParam[0] );
		$sVal = trim( $aParam[1] );

		if ( $sKey != '' ) {
			$argv[$sKey] = $sVal;
		}
	}

	$output = initPlotters( $input, $argv, $parser );
	return array( $output, 'noparse' => true, 'isHTML' => true );
}

function initPlotters( $input, $argv, &$parser ) {
	$pParser = new PlottersParser( $input, $argv );
	$pPlotter = new Plotters( $pParser, $parser );

	$pPlotter->checkForErrors();
	if ( $pPlotter->hasErrors() ) {
		return $pPlotter->getErrors();
	} else {
		return $pPlotter->toHTML();
	}
}

/**
 * Hook callback that injects messages and things into the <head> tag
 * Does nothing if $parserOutput->mPlotterTag is not set
 */
function PlottersParserOutput( $outputPage, $parserOutput )  {
	if ( !empty( $parserOutput->mPlottersTag ) ) {
		// Output required javascript
		$genericname = "generic";
		$plotkitname = "plotkit";
		if ( $parserOutput->mplotter["$genericname"] ) {
			Plotters::setPlottersHeaders( $outputPage, 'generic' );
		} elseif ( $parserOutput->mplotter["$plotkitname"] ) {
			Plotters::setPlottersHeaders( $outputPage, 'plotkit' );
		}

		// Output user defined javascript
		$plotters = wfLoadPlotters();
		if ( !$plotters ) return true;

		$done = array();

		foreach ( $plotters as $pname => $code ) {
			$tname = strtolower( "$pname" );
			if ( $parserOutput->mplotter["$tname"] ) {
				wfApplyPlotterCode( $code, $outputPage, $done );
			}
		}
	}
	return true;
}

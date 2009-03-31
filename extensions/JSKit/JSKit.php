<?php

/**
 * JSKit extension for MediaWiki -- integrates js-kit tools onto a wiki page
 * Documentation is available at http://www.mediawiki.org/wiki/Extension:JSKit
 *
 * Copyright (c) 2008 Ryan Schmidt (Skizzerz)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */
 
if(!defined('MEDIAWIKI')) {
	echo 'Not an entry point';
	die(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'JSKit',
	'description'    => 'Integrates js-kit tools onto a wiki page',
	'descriptionmsg' => 'jskit-desc',
	'version'        => '0.1',
	'author'         => 'Ryan Schmidt',
);

$wgHooks['OutputPageBeforeHTML'][] = 'efJSKit';
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'efJSKitSetup';
} else {
	$wgExtensionFunctions[] = 'efJSKitSetup';
}

$wgExtensionMessagesFiles['JSKit'] = dirname(__FILE__) . '/JSKit.i18n.php';

$wgJSKitTypes = array(
	'navigator' => true, // Enables the js-kit Navigator on pages -- see http://js-kit.com/navigator/ for more information
	'ratings'   => true, // Enables the js-kit Ratings on pages -- see http://js-kit.com/ratings/ for more information
	'polls'     => true, // Enables the js-kit Polls on pages -- see http://js-kit.com/polls/ for more information
	'comments'  => true, // Enables the js-kit Comments on pages -- see http://js-kit.com/comments/ for more information
	'reviews'   => true, // Enables the js-kit Reviews on pages -- see http://js-kit.com/reviews/ for more information
);

$wgJSKitNamespaces = array( NS_MAIN => true ); // Namespaces on which we want to be able to use the js-kit services

$wgJSKitAlways = ''; // Should we always display something at the bottom of the page (in the namespaces above)?

# Sets up the tag functions
function efJSKitSetup() {
	global $wgParser, $wgJSKitTypes;
	if( $wgJSKitTypes['navigator'] ) {
		$wgParser->setHook( 'top', 'efJSKitTop' );
	}
	if( $wgJSKitTypes['ratings'] ) {
		$wgParser->setHook( 'rating', 'efJSKitRating' );
	}
	if( $wgJSKitTypes['polls'] ) {
		$wgParser->setHook( 'poll', 'efJSKitPoll' );
	}
	if( $wgJSKitTypes['comments'] ) {
		$wgParser->setHook( 'comment', 'efJSKitComment' );
	}
	if( $wgJSKitTypes['reviews'] ) {
		$wgParser->setHook( 'review', 'efJSKitReview' );
	}
	wfLoadExtensionMessages( 'JSKit' );
	return true;
}

# Wrapper to get the Navigator service
function efJSKitTop( $input, $args, $parser ) {
	return efJSKitRender( $input, $args, $parser, 'top' );
}

#Wrapper to get the Rating service
function efJSKitRating( $input, $args, $parser ) {
	return efJSKitRender( $input, $args, $parser, 'rating' );
}

# Wrapper to get the Poll service
function efJSKitPoll( $input, $args, $parser ) {
	return efJSKitRender( $input, $args, $parser, 'poll' );
}

# Wrapper to get the Comment service
function efJSKitComment( $input, $args, $parser ) {
	return efJSKitRender( $input, $args, $parser, 'comment' );
}

# Wrapper to get the Review service
function efJSKitReview( $input, $args, $parser ) {
	return efJSKitRender( $input, $args, $parser, 'review' );
}

# Main execution function for the tags
function efJSKitRender( $input, $args, $parser, $type ) {
	$jsclass2 = false;
	switch( $type ) {
		case 'top':
			$jsclass = 'js-kit-top';
			break;
		case 'rating':
			$jsclass = 'js-kit-rating';
			break;
		case 'poll':
			$jsclass = 'js-kit-poll';
			break;
		case 'comment':
			$jsclass = 'js-kit-comments';
			break;
		case 'review':
			$jsclass = 'js-kit-rating';
			$jsclass2 = 'js-kit-comments';
			break;
		default:
			return '';
	}
	$args['class'] = isset( $args['class'] ) ? $args['class'] : false;
	$args['style'] = isset( $args['style'] ) ? $args['style'] : false;
	$args['id'] = isset( $args['id'] ) ? $args['id'] : false;
	$class = $args['class'] ? 'class="' . $jsclass . ' ' . $args['class'] . '"' : 'class="' . $jsclass . '"';
	$style = $args['style'] ? 'style="' . $args['style'] . '"' : '';
	$id = $args['id'] ? 'id="' . $args['id'] . '"' : '';
	$tag = "<div $id $class $style ";
	$parts = explode( "\n", $input );
	foreach( $parts as $part ) {
		$pieces = explode( '=', $part, 2 );
		if( count( $pieces ) != 2 )
			continue;
		$tag .= $pieces[0] . '="'. $pieces[1] . '" ';
	}
	if( $type == 'rating' || $type == 'comment' ) {
		$tag .= 'standalone="yes" '; // if this is a rating/comment, force it standalone so it doesn't try to be a review
	}
	$tag .= '></div>';
	if( $jsclass2 ) {
		// needs 2 tags, like in reviews
		$args['class2'] = isset( $args['class2'] ) ? $args['class2'] : false;
		$args['style2'] = isset( $args['style2'] ) ? $args['style2'] : false;
		$args['id2'] = isset( $args['id2'] ) ? $args['id2'] : false;
		$class2 = $args['class2'] ? 'class="' . $jsclass2 . ' ' . $args['class2'] . '"' : 'class="' . $jsclass2 . '"';
		$style2 = $args['style2'] ? 'style="' . $args['style2'] . '"' : '';
		$id2 = $args['id2'] ? 'id="' . $args['id2'] . '"' : '';
		$tag2 = "<div $id2 $class2 $style2 ";
		// $parts is already defined above
		foreach( $parts as $part ) {
			$pieces = explode( '=', $part, 2 );
			if( count( $pieces ) != 2 )
				continue;
			$tag2 .= $pieces[0] . '="'. $pieces[1] . '" ';
		}
		$tag2 .= '></div>';
		$tag .= $tag2;
	}
	return $tag . '__JSKIT-TYPE-' . $type . '__';
}

# Appends the javascript
function efJSKit(&$out, &$text) {
	global $wgJSKitNamespaces, $wgJSKitAlways, $wgTitle;
	$ns = $wgTitle->getNamespace();
	if( !$wgTitle->getArticleId() ) {
		// special page or wrong namespace, so don't do anything
		return true;
	}
	if( strpos( $text, '__NOJSKIT__' ) !== false ) {
		// "magic word" to disable js-kit on a per-page basis
		$text = str_replace( '__NOJSKIT__', '', $text );
		return true;
	}
	$always = ( strpos( $text, '__JSKIT-DISABLE-ALWAYS__' ) === false );
	$wgJSKitAlways = preg_match( '/^(comment|review|rating)$/', $wgJSKitAlways ) ? $wgJSKitAlways : '';
	if( strpos( $text, '__JSKIT__' ) === false ) {
		if( !array_key_exists($ns, $wgJSKitNamespaces) || !$wgJSKitNamespaces[$ns] ) {
			// not a namespace where JSKit is normally enabled
			return true;
		} elseif( $always ) {
			$text .= efJSKitRender( '', '', false, $wgJSKitAlways );
		}
	} else {
		// "magic word" to enable js-kit on a per-page basis
		$text = str_replace( '__JSKIT__', '', $text );
		if( $always ) {
			$text .= efJSKitRender( '', '', false, $wgJSKitAlways );
		}
	}
	$text = str_replace( '__JSKIT-DISABLE-ALWAYS__', '', $text );
	
	$sb = '<script type="text/javascript" src="http://js-kit.com/';
	$se = '.js"></script>' . "\n";
	if( strpos( $text, '__JSKIT-TYPE-top__' ) !== false ) {
		$text = str_replace( '__JSKIT-TYPE-top__', '', $text );
		$text .= $sb . 'top' . $se;
	}
	if( strpos( $text, '__JSKIT-TYPE-rating__' ) !== false ) {
		$text = str_replace( '__JSKIT-TYPE-rating__', '', $text );
		$text .= $sb . 'ratings' . $se;
	}
	if( strpos( $text, '__JSKIT-TYPE-poll__' ) !== false ) {
		$text = str_replace( '__JSKIT-TYPE-poll__', '', $text );
		$text .= $sb . 'polls' . $se;
	}
	if( strpos( $text, '__JSKIT-TYPE-comment__' ) !== false ) {
		$text = str_replace( '__JSKIT-TYPE-comment__', '', $text );
		$text .= $sb . 'comments' . $se;
	}
	if( strpos( $text, '__JSKIT-TYPE-review__' ) !== false ) {
		$text = str_replace( '__JSKIT-TYPE-review__', '', $text );
		$text .= $sb . 'reviews' . $se;
	}
	return true;
}
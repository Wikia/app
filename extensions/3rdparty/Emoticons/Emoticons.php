<?php
 
# Emoticon MediaWiki Extension
# Created by Alex Wollangk (alex@wollangk.com), and Techjar (tecknojar@gmail.com)

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point.' );
}
 
global $wgHooks;
global $wgExtensionCredits;
 
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Emoticons',
	'status' => 'stable',
	'type' => 'hook',
	'author' => 'Alex Wollangk, Techjar',
	'version' => '1.2.3',
	'update' => '8-13-2009',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Emoticons',
	'description' => 'Enable forum-style emoticon (smiley) replacement within MediaWiki.',
);
 
$wgHooks['ParserAfterStrip'][] = 'fnEmoticons';

// fnStringBetween function
function fnStringBetween( $string, $start, $end ) {
	$string = " ".$string;
	if( strlen( $string ) > strlen( $start ) )
	{
		$ini = strpos( $string, $start );
		if( $ini === false )
		{
			return false;
		}
		else
		{
			$ini = $ini + strlen( $start );   
			$len = strpos( $string, $end, $ini ) - $ini;
			return substr( $string, $ini, $len );
		}
	}
	else
	{
		return false;
	}
}
 
// The callback function for replacing emoticons with image tags
function fnEmoticons( &$parser, &$text, &$strip_state ) {
	global $action; // Access the global "action" variable
	// Only do the replacement if the action is not edit or history
	if(
		$action !== 'edit'
		&& $action !== 'history'
		&& $action !== 'delete'
		&& $action !== 'watch'
		&& strpos( $parser->mTitle->mPrefixedText, 'Special:' ) === false
		&& $parser->mTitle->mNamespace !== 8
	)
	{
		// Get the list of emoticons from the "MediaWiki:Emoticons" article.
		$title = Title::makeTitle( 8, 'Emoticons' );
		$emoticonListArticle = new Article( $title );
		$emoticonListArticle->getContent();
 
		// If the content successfully loaded, do the replacement
		if( $emoticonListArticle->mContentLoaded )
		{
			$emoticonList = explode( "\n", $emoticonListArticle->mContent );
			foreach( $emoticonList as $index => $emoticon )
			{
				$currEmoticon = explode( "//", $emoticon, 2 );
				if( count($currEmoticon) == 2 )
				{
					// start by trimming the search value
					$currEmoticon[ 0 ] = trim( $currEmoticon[ 0 ] );
					// if the string begins with &nbsp;, lop it off
					if( substr( $currEmoticon[ 0 ], 0, 6 ) == '&nbsp;' )
					{
						$currEmoticon[ 0 ] = trim( substr( $currEmoticon[ 0 ], 6 ) );
					}
					// trim the replacement value
					$currEmoticon[ 1 ] = trim( $currEmoticon[ 1 ] );
					// and finally perform the replacement
					$text = str_ireplace( " ".$currEmoticon[ 0 ], $currEmoticon[ 1 ], $text );
					// <nowiki> tag parser
					$a = 0;
					$text2 = array();
					// loop through the <nowiki> tags
					while( ( $nowiki_text = fnStringBetween( $text, "<nowiki>", "</nowiki>" ) ) && $a < 10 )
					{
						// replace the <nowiki> with a 'placeholder' tag
						$text = str_ireplace( "<nowiki>".$nowiki_text."</nowiki>", "[nowiki".$a."]", $text );
						// replace the images with text
						$text2[ $a ] = str_ireplace( $currEmoticon[ 1 ], " ".$currEmoticon[ 0 ], $nowiki_text);
						$a++;
					}
					$a--;
					// now do the <nowiki> replacement, and loop through the $text2 array()
					while( $a > -1 )
					{
						// reinsert the <nowiki> tag
						$text = str_ireplace( "[nowiki".$a."]", "<nowiki>".$text2[ $a ]."</nowiki>", $text );
						$a--;
					}
				}
			}
		}
	}
	// Always a good practice to let the other hooks have their turn ... whenever it make sense.
	return true;
}
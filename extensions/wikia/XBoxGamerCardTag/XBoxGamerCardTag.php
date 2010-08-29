<?php

/**
 * Adds <xboxcard> parser hook rendering as an inline gamercard
 *
 * Usage: <xboxcard>gamertag</xboxcard>
 *
 * @author C. uberfuzzy stafford
 */

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
$wgHooks['ParserFirstCallInit'][] = 'wfXBCardTagSetup';

function wfXBCardTagSetup(&$parser) {
	$parser->setHook( 'xboxcard', 'wfMakeXboxCard' );
	return true;
}

function wfMakeXboxCard( $contents, $attributes, $parser ) {

	$style = array();
	
	if( !empty($attributes['align']) )
	{
		if( $attributes['align'] == 'left' )
		{
			$style['float'] = 'left';
		}
		elseif( $attributes['align'] == 'right' )
		{
			$style['float'] = 'right';
		}
	}
	
		$style_string = '';
	if( !empty($style) )
	{
		foreach($style as $var=>$value)
		{
			$style_string .= "{$var}:{$value};";
		}
		$style_string = " style=\"{$style_string}\"";
	}
	
	
	$out = "<div class=\"xboxcard-container\" {$style_string} >\n";
	
	$xbox_id = $contents;
	if( 0 == preg_match("/^[A-Za-z][A-Za-z0-9 ]*$/", $xbox_id) )
	{
		$out .= "invalid characters in tag";
	}
	else
	{
		$xbox_id_e = urlencode($xbox_id);
		$out .= "<iframe src=\"http://gamercard.xbox.com/{$xbox_id_e}.card\" scrolling=\"no\" frameBorder=\"0\" height=\"140\" width=\"204\">{$xbox_id}</iframe>";
	}
	
	$out .= "</div>\n";

	return $out;
}
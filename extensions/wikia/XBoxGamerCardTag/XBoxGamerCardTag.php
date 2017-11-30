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

/**
 * @param Parser $parser
 * @return bool
 */
function wfXBCardTagSetup( Parser $parser ): bool {
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
		$out .= "invalid characters in gamertag";
	}
	else
	{
		$xbox_id_e = rawurlencode($xbox_id); #we use raw version because microsoft no longer accepts spaces as +, MUST be %20
		$out .= "<iframe src=\"https://gamercard.xbox.com/{$xbox_id_e}.card\" scrolling=\"no\" frameBorder=\"0\" height=\"140\" width=\"204\">{$xbox_id}</iframe>";
	}

	$out .= "</div>\n";

	return $out;
}

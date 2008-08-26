<?php
/*

 Defines a subset of parser functions that operate with strings.

 {{#len:value}}

 Returns the length of the given value.
 See: http://php.net/manual/function.strlen.php


 {{#pos:value|key|offset}}

 Returns the first position of key inside the given value, or an empty string.
 If offset is defined, this method will not search the first offset characters.
 See: http://php.net/manual/function.strpos.php


 {{#rpos:value|key}}

 Returns the last position of key inside the given value, or -1 if the key is
 not found. When using this to search for the last delimiter, add +1 to the
 result to retreive position after the last delimiter. This also works when
 the delimiter is not found, because "-1 + 1" is zero, which is the beginning
 of the given value.
 See: http://php.net/manual/function.strrpos.php


 {{#sub:value|start|length}}

 Returns a substring of the given value with the given starting position and
 length. If length is omitted, this returns the rest of the string.
 See: http://php.net/manual/function.substr.php


 {{#pad:value|length|with|direction}}

 Returns the value padded to the certain length with the given with string.
 If the with string is not given, spaces are used for padding. The direction
 may be specified as: 'left', 'center' or 'right'.
 See: http://php.net/manual/function.str-pad.php


 {{#replace:value|from|to}}

 Returns the given value with all occurences of 'from' replaced with 'to'.
 See: http://php.net/manual/function.str-replace.php


 {{#explode:value|delimiter|position}}

 Splits the given value into pieces by the given delimiter and returns the
 position-th piece. Empty string is returned if there are not enough pieces.
 Note: Pieces are counted from 0.
 See: http://php.net/manual/function.explode.php


 {{#urlencode:value}}

 URL-encodes the given value.
 See: http://php.net/manual/function.urlencode.php


 {{#urldecode:value}}

 URL-decodes the given value.
 See: http://php.net/manual/function.urldecode.php


 Contributors:
   Juraj Simlovic [http://meta.wikimedia.org/wiki/User:jsimlo]
   Algorithm [http://meta.wikimedia.org/wiki/User:Algorithm]

*/

$wgExtensionCredits['parserhook'][] = array(
'name'         => 'StringFunctions',
'version'      => '1.9.3', // Jan 30, 2007.
'description'  => 'Enhances parser with string functions',
'author'       => 'Juraj Simlovic',
'url'          => 'http://www.mediawiki.org/wiki/Extension:StringFunctions',
);

$wgExtensionFunctions[] = 'wfStringFunctions';

$wgHooks['LanguageGetMagic'][] = 'wfStringFunctionsLanguageGetMagic';

function wfStringFunctions ( ) {
    global $wgParser, $wgExtStringFunctions;
    global $wgStringFunctionsLimitSearch, $wgStringFunctionsLimitReplace, $wgStringFunctionsLimitPad;

    $wgExtStringFunctions = new ExtStringFunctions ( );
    if (!isset($wgStringFunctionsLimitSearch)) $wgStringFunctionsLimitSearch =  30;
    if (!isset($wgStringFunctionsLimitReplace)) $wgStringFunctionsLimitReplace =  30;
    if (!isset($wgStringFunctionsLimitPad)) $wgStringFunctionsLimitPad     = 100;

    $wgParser->setFunctionHook ( 'len',       array ( &$wgExtStringFunctions, 'runLen'       ) );

    $wgParser->setFunctionHook ( 'pos',       array ( &$wgExtStringFunctions, 'runPos'       ) );
    $wgParser->setFunctionHook ( 'rpos',      array ( &$wgExtStringFunctions, 'runRPos'      ) );

    $wgParser->setFunctionHook ( 'sub',       array ( &$wgExtStringFunctions, 'runSub'       ) );

    $wgParser->setFunctionHook ( 'pad',       array ( &$wgExtStringFunctions, 'runPad'       ) );

    $wgParser->setFunctionHook ( 'replace',   array ( &$wgExtStringFunctions, 'runReplace'   ) );

    $wgParser->setFunctionHook ( 'explode',   array ( &$wgExtStringFunctions, 'runExplode'   ) );

    $wgParser->setFunctionHook ( 'urlencode', array ( &$wgExtStringFunctions, 'runUrlEncode' ) );
    $wgParser->setFunctionHook ( 'urldecode', array ( &$wgExtStringFunctions, 'runUrlDecode' ) );
}

function wfStringFunctionsLanguageGetMagic( &$magicWords, $langCode = "en" ) {
    switch ( $langCode ) {
        default:
            $magicWords['len']          = array ( 0, 'len' );
            $magicWords['pos']          = array ( 0, 'pos' );
            $magicWords['rpos']         = array ( 0, 'rpos' );
            $magicWords['sub']          = array ( 0, 'sub' );
            $magicWords['pad']          = array ( 0, 'pad' );
            $magicWords['replace']      = array ( 0, 'replace' );
            $magicWords['explode']      = array ( 0, 'explode' );
            $magicWords['urlencode']    = array ( 0, 'urlencode' );
            $magicWords['urldecode']    = array ( 0, 'urldecode' );
    }
    return true;
}

class ExtStringFunctions
{
    /**
     * {{#len:value}}
     */
    function runLen ( &$parser, $inStr = '' )
    {
        return mb_strlen ( $inStr );
    }

    /**
     * {{#pos:value|key|offset}}
     * Note: If the needle is an empty string, single space is used instead.
     * Note: If the needle is not found, empty string is returned.
     * Note: The needle is limited to specific length.
     */
    function runPos ( &$parser, $inStr = '', $inNeedle = '', $inOffset = 0 )
    {
        global $wgStringFunctionsLimitSearch;

        # empty needle
        if ( $inNeedle === '' )
            $inNeedle = ' ';

        # limit needle
        $inNeedle = mb_substr ( $inNeedle, 0, $wgStringFunctionsLimitSearch );

        # strpos
        $ret = mb_strpos ( $inStr, $inNeedle, intval ( $inOffset ) );

        # return empty string upon not found
        return ( $ret !== FALSE ) ? $ret : '';
    }

    /**
     * {{#rpos:value|key}}
     * Note: If the needle is an empty string, single space is used instead.
     * Note: If the needle is not found, -1 is returned.
     * Note: The needle is limited to specific length.
     */
    function runRPos ( &$parser, $inStr = '', $inNeedle = '' )
    {
        global $wgStringFunctionsLimitSearch;

        # empty needle
        if ( $inNeedle == '' )
            $inNeedle = ' ';

        # limit needle
        $inNeedle = mb_substr ( $inNeedle, 0, $wgStringFunctionsLimitSearch );

        # empty haystack
        if ( $inStr == '' )
            return "-1";

        # strrpos
        $ret = mb_strrpos ( $inStr, $inNeedle );

        # return -1 upon not found
        return ( $ret !== FALSE ) ? $ret : "-1";
    }

    /**
     * {{#sub:value|start|length}}
     * Note: If length is zero, the rest of the input is returned.
     */
    function runSub ( &$parser, $inStr = '', $inStart = '', $inLength = 0 )
    {
        # zero length
        if ( ! ( (int) $inLength ) )
            return mb_substr ( $inStr, intval ( $inStart ) );

        # non-zero length
        return mb_substr ( $inStr, intval ( $inStart ) , intval ( $inLength ) );
    }

    /**
     * {{#pad:value|length|with|direction}}
     * Note: Length of the resulting string is limited.
     */
    function runPad ( &$parser, $inStr = '', $inLen = 0, $inWith = '', $inDirection = 'left' )
    {
        global $wgStringFunctionsLimitPad;

        # direction
        switch ( strtolower ( $inDirection ) )
        {
        case 'left':
        default:
          $direction = STR_PAD_LEFT;
          break;
        case 'center':
          $direction = STR_PAD_BOTH;
          break;
        case 'right':
          $direction = STR_PAD_RIGHT;
          break;
        }

        #limit pad length
        if ($wgStringFunctionsLimitPad > 0)
            $inLen = min ( intval ( $inLen ), $wgStringFunctionsLimitPad );

        # padding
        if ( $inWith == '' )
            $inWith = ' ';

        # pad
        return str_pad ( $inStr, intval ( $inLen ), $inWith, $direction );
    }

    /**
     * {{#replace:value|from|to}}
     * Note: If the needle is an empty string, single space is used instead.
     * Note: The needle is limited to specific length.
     * Note: The product is limited to specific length.
     */
    function runReplace ( &$parser, $inStr = '', $inReplaceFrom = '', $inReplaceTo = '' )
    {
        global $wgStringFunctionsLimitSearch, $wgStringFunctionsLimitReplace;

        # empty needle
        if ( $inReplaceFrom == '' )
            $inReplaceFrom = ' ';

        # limit needle (this is being searched for)
        $inReplaceFrom = mb_substr ( $inReplaceFrom, 0, $wgStringFunctionsLimitSearch );

        # limit product (this is being returned)
        $inReplaceTo = mb_substr ( $inReplaceTo, 0, $wgStringFunctionsLimitReplace );

        # replace
        return str_replace ( $inReplaceFrom, $inReplaceTo, $inStr );
    }

    /**
     * {{#explode:value|delimiter|position}}
     * Note: If the divider is an empty string, single space is used instead.
     * Note: The divider is limited to specific length.
     * Note: Empty string is returned, if there is not enough exploded chunks.
     */
    function runExplode ( &$parser, $inStr = '', $inDiv = '', $inPos = 0 )
    {
        global $wgStringFunctionsLimitSearch;

        # empty divider
        if ( $inDiv == '' )
            $inDiv = ' ';

        # limit divider (this is being searched for)
        $inDiv = mb_substr ( $inDiv, 0, $wgStringFunctionsLimitSearch );

        # explode
        $tokens = explode ( $inDiv, $inStr );

        # out of range
        if ( !isset ( $tokens [ intval ( $inPos ) ] ) )
            return "";

        # in range
        return $tokens [ intval ( $inPos ) ];
    }

    /**
     * {{#urlencode:value}}
     */
    function runUrlEncode ( &$parser, $inStr = '' )
    {
        # encode
        return urlencode ( $inStr );
    }

    /**
     * {{#urldecode:value}}
     */
    function runUrlDecode ( &$parser, $inStr = '' )
    {
        # decode
        return urldecode ( $inStr );
    }

}

?>
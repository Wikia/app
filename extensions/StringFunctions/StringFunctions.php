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
 Note: A negative value can be used to count pieces from the end, instead of
 counting from the beginning. The last piece is at position -1.
 See: http://php.net/manual/function.explode.php


 {{#urlencode:value}}

 URL-encodes the given value.
 See: http://php.net/manual/function.urlencode.php


 {{#urldecode:value}}

 URL-decodes the given value.
 See: http://php.net/manual/function.urldecode.php


 Copyright (c) 2008 Ross McClure & Juraj Simlovic
  http://www.mediawiki.org/wiki/User:Algorithm
  http://www.mediawiki.org/wiki/User:jsimlo

 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.

*/

$wgExtensionCredits['parserhook'][] = array(
'name'         => 'StringFunctions',
'version'      => '2.0', // Dec 10, 2007
'description'  => 'Enhances parser with string functions',
'author'       => array('Ross McClure', 'Juraj Simlovic'),
'url'          => 'http://www.mediawiki.org/wiki/Extension:StringFunctions',
);

$wgExtensionFunctions[] = 'wfStringFunctions';

$wgHooks['LanguageGetMagic'][] = 'wfStringFunctionsLanguageGetMagic';

function wfStringFunctions ( ) {
    global $wgParser, $wgExtStringFunctions;
    global $wgStringFunctionsLimitSearch;
    global $wgStringFunctionsLimitReplace;
    global $wgStringFunctionsLimitPad;

    $wgExtStringFunctions = new ExtStringFunctions ( );
    $wgStringFunctionsLimitSearch  =  30;
    $wgStringFunctionsLimitReplace =  30;
    $wgStringFunctionsLimitPad     = 100;

    $wgParser->setFunctionHook('len',      array(&$wgExtStringFunctions,'runLen'      ));
    $wgParser->setFunctionHook('pos',      array(&$wgExtStringFunctions,'runPos'      ));
    $wgParser->setFunctionHook('rpos',     array(&$wgExtStringFunctions,'runRPos'     ));
    $wgParser->setFunctionHook('sub',      array(&$wgExtStringFunctions,'runSub'      ));
    $wgParser->setFunctionHook('pad',      array(&$wgExtStringFunctions,'runPad'      ));
    $wgParser->setFunctionHook('replace',  array(&$wgExtStringFunctions,'runReplace'  ));
    $wgParser->setFunctionHook('explode',  array(&$wgExtStringFunctions,'runExplode'  ));
    $wgParser->setFunctionHook('urlencode',array(&$wgExtStringFunctions,'runUrlEncode'));
    $wgParser->setFunctionHook('urldecode',array(&$wgExtStringFunctions,'runUrlDecode'));
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

class ExtStringFunctions {
    /**
     * Splits the string into its component parts using preg_match_all().
     * $chars is set to the resulting array of multibyte characters.
     * Returns count($chars).
     */
    function mwSplit ( &$parser, $str, &$chars ) {
        # Get marker prefix & suffix
        $prefix = preg_quote( $parser->mUniqPrefix );
        if( isset($parser->mMarkerSuffix) )
            $suffix = preg_quote( $parser->mMarkerSuffix );
        else if ( strcmp( MW_PARSER_VERSION, '1.6.1' ) > 0 )
            $suffix = 'QINU\x07';
        else $suffix = 'QINU';

        # Treat strip markers as single multibyte characters
        $count = preg_match_all('/' . $prefix . '.*?' . $suffix . '|./su', $str, $arr);
        $chars = $arr[0];
        return $count;
    }

    /**
     * {{#len:value}}
     */
    function runLen ( &$parser, $inStr = '' ) {
        return $this->mwSplit ( $parser, $inStr, $chars );
    }

    /**
     * {{#pos:value|key|offset}}
     * Note: If the needle is an empty string, single space is used instead.
     * Note: If the needle is not found, empty string is returned.
     * Note: The needle is limited to specific length.
     */
    function runPos ( &$parser, $inStr = '', $inNeedle = '', $inOffset = 0 ) {
        global $wgStringFunctionsLimitSearch;

        if ( $inNeedle === '' ) {
            # empty needle
            $needle = array(' ');
            $nSize = 1;
        } else {
            # convert needle
            $nSize = $this->mwSplit ( $parser, $inNeedle, $needle );

            if ( $nSize > $wgStringFunctionsLimitSearch ) {
                $nSize = $wgStringFunctionsLimitSearch;
                $needle = array_slice ( $needle, 0, $nSize );
            }
        }

        # convert string
        $size = $this->mwSplit( $parser, $inStr, $chars ) - $nSize;
        $inOffset = max ( intval($inOffset), 0 );

        # find needle
        for ( $i = $inOffset; $i <= $size; $i++ ) {
            if ( $chars[$i] !== $needle[0] ) continue;
            for ( $j = 1; ; $j++ ) {
                if ( $j >= $nSize ) return $i;
                if ( $chars[$i + $j] !== $needle[$j] ) break;
            }
        }

        # return empty string upon not found
        return '';
    }

    /**
     * {{#rpos:value|key}}
     * Note: If the needle is an empty string, single space is used instead.
     * Note: If the needle is not found, -1 is returned.
     * Note: The needle is limited to specific length.
     */
    function runRPos ( &$parser, $inStr = '', $inNeedle = '' ) {
        global $wgStringFunctionsLimitSearch;

        if ( $inNeedle === '' ) {
            # empty needle
            $needle = array(' ');
            $nSize = 1;
        } else {
            # convert needle
            $nSize = $this->mwSplit ( $parser, $inNeedle, $needle );

            if ( $nSize > $wgStringFunctionsLimitSearch ) {
                $nSize = $wgStringFunctionsLimitSearch;
                $needle = array_slice ( $needle, 0, $nSize );
            }
        }

        # convert string
        $size = $this->mwSplit( $parser, $inStr, $chars ) - $nSize;

        # find needle
        for ( $i = $size; $i >= 0; $i-- ) {
            if ( $chars[$i] !== $needle[0] ) continue;
            for ( $j = 1; ; $j++ ) {
                if ( $j >= $nSize ) return $i;
                if ( $chars[$i + $j] !== $needle[$j] ) break;
            }
        }

        # return -1 upon not found
        return "-1";
    }

    /**
     * {{#sub:value|start|length}}
     * Note: If length is zero, the rest of the input is returned.
     */
    function runSub ( &$parser, $inStr = '', $inStart = 0, $inLength = 0 ) {
        # convert string
        $this->mwSplit( $parser, $inStr, $chars );

        # zero length
        if ( intval($inLength) == 0 )
            return join('', array_slice( $chars, intval($inStart) ));

        # non-zero length
        return join('', array_slice( $chars, intval($inStart), intval($inLength) ));
    }

    /**
     * {{#pad:value|length|with|direction}}
     * Note: Length of the resulting string is limited.
     */
    function runPad( &$parser, $inStr = '', $inLen = 0, $inWith = '', $inDirection = '' ) {
        global $wgStringFunctionsLimitPad;

        # direction
        switch ( strtolower ( $inDirection ) ) {
          case 'center':
            $direction = STR_PAD_BOTH;
            break;
          case 'right':
            $direction = STR_PAD_RIGHT;
            break;
          case 'left':
          default:
            $direction = STR_PAD_LEFT;
            break;
        }

        # prevent markers in padding
        $a = explode ( $parser->mUniqPrefix, $inWith, 2 );
        if ( $a[0] === '' )
            $inWith = ' ';
        else $inWith = $a[0];

        # limit pad length
        $inLen = intval ( $inLen );
        if ($wgStringFunctionsLimitPad > 0)
            $inLen = min ( $inLen, $wgStringFunctionsLimitPad );

        # adjust for multibyte strings
        $inLen += strlen( $inStr ) - $this->mwSplit( $parser, $inStr, $a );

        # pad
        return str_pad ( $inStr, $inLen, $inWith, $direction );
    }

    /**
     * {{#replace:value|from|to}}
     * Note: If the needle is an empty string, single space is used instead.
     * Note: The needle is limited to specific length.
     * Note: The product is limited to specific length.
     */
    function runReplace( &$parser, $inStr = '', $inReplaceFrom = '', $inReplaceTo = '' ) {
        global $wgStringFunctionsLimitSearch, $wgStringFunctionsLimitReplace;

        if ( $inReplaceFrom === '' ) {
            # empty needle
            $needle = array(' ');
            $nSize = 1;
        } else {
            # convert needle
            $nSize = $this->mwSplit ( $parser, $inReplaceFrom, $needle );
            if ( $nSize > $wgStringFunctionsLimitSearch ) {
                $nSize = $wgStringFunctionsLimitSearch;
                $needle = array_slice ( $needle, 0, $nSize );
            }
        }

        # convert product
        $pSize = $this->mwSplit ( $parser, $inReplaceTo, $product );
        if ( $pSize > $wgStringFunctionsLimitReplace ) {
            $pSize = $wgStringFunctionsLimitReplace;
            $product = array_slice ( $product, 0, $pSize );
        }

        # remove markers in product
        for( $i = 0; $i < $pSize; $i++ ) {
            if( strlen( $product[$i] ) > 6 ) $product[$i] = ' ';
        }

        # convert string
        $size = $this->mwSplit ( $parser, $inStr, $chars ) - $nSize;

        # replace
        for ( $i = 0; $i <= $size; $i++ ) {
            if ( $chars[$i] !== $needle[0] ) continue;
            for ( $j = 1; ; $j++ ) {
                if ( $j >= $nSize ) {
                    array_splice ( $chars, $i, $j, $product );
                    $size += ( $pSize - $nSize );
                    $i += ( $pSize - 1 );
                    break;
                }
                if ( $chars[$i + $j] !== $needle[$j] ) break;
            }
        }
        return join('', $chars);
    }

    /**
     * {{#explode:value|delimiter|position}}
     * Note: Negative position can be used to specify tokens from the end.
     * Note: If the divider is an empty string, single space is used instead.
     * Note: The divider is limited to specific length.
     * Note: Empty string is returned, if there is not enough exploded chunks.
     */
    function runExplode ( &$parser, $inStr = '', $inDiv = '', $inPos = 0 ) {
        global $wgStringFunctionsLimitSearch;

        if ( $inDiv === '' ) {
            # empty divider
            $div = array(' ');
            $dSize = 1;
        } else {
            # convert divider
            $dSize = $this->mwSplit ( $parser, $inDiv, $div );
            if ( $dSize > $wgStringFunctionsLimitSearch ) {
                $dSize = $wgStringFunctionsLimitSearch;
                $div = array_slice ( $div, 0, $dSize );
            }
        }

        # convert string
        $size = $this->mwSplit ( $parser, $inStr, $chars ) - $dSize;

        # explode
        $inPos = intval ( $inPos );
        $tokens = array();
        $start = 0;
        for ( $i = 0; $i <= $size; $i++ ) {
            if ( $chars[$i] !== $div[0] ) continue;
            for ( $j = 1; ; $j++ ) {
                if ( $j >= $dSize ) {
                    if ( $inPos > 0 ) $inPos--;
                    else {
                        $tokens[] = join('', array_slice($chars, $start, ($i - $start)));
                        if ( $inPos == 0 ) return $tokens[0];
                    }
                    $start = $i + $j;
                    $i = $start - 1;
                    break;
                }
                if ( $chars[$i + $j] !== $div[$j] ) break;
            }
        }
        $tokens[] = join('', array_slice( $chars, $start ));

        # negative $inPos
        if ( $inPos < 0 ) $inPos += count ( $tokens );

        # out of range
        if ( !isset ( $tokens[$inPos] ) ) return "";

        # in range
        return $tokens[$inPos];
    }

    /**
     * {{#urlencode:value}}
     */
    function runUrlEncode ( &$parser, $inStr = '' ) {
        # encode
        return urlencode ( $inStr );
    }

    /**
     * {{#urldecode:value}}
     */
    function runUrlDecode ( &$parser, $inStr = '' ) {
        # decode
        return urldecode ( $inStr );
    }
}
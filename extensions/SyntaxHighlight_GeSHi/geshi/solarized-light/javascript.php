<?php
/*************************************************************************************
 * javascript.php
 * --------------
 * Author: Ben Keen (ben.keen@gmail.com)
 * Copyright: (c) 2004 Ben Keen (ben.keen@gmail.com), Nigel McNie (http://qbnz.com/highlighter)
 * Release Version: 1.0.8.10
 * Date Started: 2004/06/20
 *
 * JavaScript language file for GeSHi.
 *
 * CHANGES
 * -------
 * 2015/02/05
 *  - Changes made by Wikia (lukaszk@wikia-inc.com) to support solarized theme for js/css/lua files
 * 2012/06/27 (1.0.8.11)
 *  -  Reordered Keyword Groups to reflect syntactical meaning of keywords
 * 2008/05/23 (1.0.7.22)
 *  -  Added description of extra language features (SF#1970248)
 * 2004/11/27 (1.0.1)
 *  -  Added support for multiple object splitters
 * 2004/10/27 (1.0.0)
 *  -  First Release
 *
 * TODO (updated 2004/11/27)
 * -------------------------
 *
 *************************************************************************************
 *
 *     This file is part of GeSHi.
 *
 *   GeSHi is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   GeSHi is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with GeSHi; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ************************************************************************************/

$language_data = array (
    'LANG_NAME' => 'Javascript',
    'COMMENT_SINGLE' => array(1 => '//'),
    'COMMENT_MULTI' => array('/*' => '*/'),
    'COMMENT_REGEXP' => array(
        //Regular Expressions
        2 => "/(?<=[\\s^])(s|tr|y)\\/(?!\*)(?!\s)(?:\\\\.|(?!\n)[^\\/\\\\])+(?<!\s)\\/(?!\s)(?:\\\\.|(?!\n)[^\\/\\\\])*(?<!\s)\\/[msixpogcde]*(?=[\\s$\\.\\;])|(?<=[\\s^(=])(m|q[qrwx]?)?\\/(?!\*)(?!\s)(?:\\\\.|(?!\n)[^\\/\\\\])+(?<!\s)\\/[msixpogc]*(?=[\\s$\\.\\,\\;\\)])/iU"
        ),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array("'", '"'),
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => array(
        0 => array(
            //reserved/keywords; also some non-reserved keywords
            'const',
            'function',
            'goto',
            'var'
            ),
		1 => array(
			'if', 'else', 'in','instanceof',
			'return',
			'new',
			'set', 'get', 'delete',
			'finally', 'static',
			'switch', 'case', 'default', 'break',
			'catch', 'try', 'throw', 'typeof',
			'for', 'while', 'do', 'continue',
			'void',
			'$'
		),
        2 => array(
            //reserved/non-keywords; metaconstants
            'false','null','true','undefined','NaN','Infinity'
            ),
        3 => array(
            //magic properties/functions
            '__proto__','__defineGetter__','__defineSetter__','hasOwnProperty','hasProperty'
            ),
        4 => array(
            //type constructors
            'Object', 'Function', 'Date', 'Math', 'String', 'Number', 'Boolean', 'Array',
			'prototype', 'this'
            ),
        5 => array(
            //reserved, but invalid in language
            'abstract','boolean','byte','char','class','debugger','double','enum','export','extends',
            'final','float','implements','import','int','interface','long','native',
            'short','super','synchronized','throws','transient','volatile'
            ),
        ),
    'SYMBOLS' => array(
        '(', ')', '[', ']', '{', '}',
        '+', '-', '*', '/', '%',
        '!', '@', '&', '|', '^',
        '<', '>', '=',
        ',', ';', '?', ':'
        ),
    'CASE_SENSITIVE' => array(
        GESHI_COMMENTS => false,
        1 => true,
        2 => true,
        3 => true,
        4 => true,
        5 => true
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            0 => 'color: #073642; font-weight: bold;',
			1 => 'color: #859900; font-weight: bold;',
            2 => 'color: #b58900; font-weight: bold;',
            3 => 'color: #000066;',
            5 => 'color: #FF0000;'
            ),
        'COMMENTS' => array(
            1 => 'color: #93a1a1; font-style: italic;',
            2 => 'color: #93a1a1; font-style: italic;',
            'MULTI' => 'color: #93a1a1; font-style: italic;'
            ),
        'ESCAPE_CHAR' => array(
            0 => 'color: #000099; font-weight: bold;'
            ),
        'BRACKETS' => array(
            0 => 'color: #009900;'
            ),
        'STRINGS' => array(
            0 => 'color: #2aa198;'
            ),
        'NUMBERS' => array(
            0 => 'color: #d33682;'
            ),
        'METHODS' => array(
            1 => 'color: #268bd2;'
            ),
        'SYMBOLS' => array(
            0 => 'color: #339933;'
            ),
        'REGEXPS' => array(
			0 => 'color: #268bd2;'
            ),
        'SCRIPT' => array(
            0 => '',
            1 => '',
            2 => '',
            3 => ''
            )
        ),
    'URLS' => array(
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => ''
    ),
    'OOLANG' => true,
    'OBJECT_SPLITTERS' => array(
        1 => '.'
        ),
    'REGEXPS' => array(
		array(
			0 => '(function[\|\>]*)(\s)*([$a-zA-Z_][0-9a-zA-Z_$]*)+',
			1 => '\\3',
			2 => '',
			3 => '\\1\\2',
			4 => '',
		)
    ),
    'STRICT_MODE_APPLIES' => GESHI_MAYBE,
    'SCRIPT_DELIMITERS' => array(
        0 => array(
            '<script type="text/javascript">' => '</script>'
            ),
        1 => array(
            '<script language="javascript">' => '</script>'
            )
        ),
    'HIGHLIGHT_STRICT_BLOCK' => array(
        0 => true,
        1 => true
        )
);

?>

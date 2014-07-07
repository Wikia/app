<?php
/*************************************************************************************
 * wikiscripts.php
 * --------------
 * Author: Victor Vasiliev (vasilvv@gmail.com)
 * Copyright: (c) 2011 Victor Vasiliev (vasilvv@gmail.com)
 * Release Version: 1.0
 * Date Started: 2011/08/11
 *
 * WikiScripts language file for GeSHi.
 * 
 *************************************************************************************
 *
 *     This file is part of GeSHi and MediaWiki.
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
    'LANG_NAME' => 'WikiScripts',
    'COMMENT_SINGLE' => array(1 => '//'),
    'COMMENT_MULTI' => array('/*' => '*/'),
    'CASE_KEYWORDS' => GESHI_CAPS_NO_CHANGE,
    'QUOTEMARKS' => array("'", '"'),
    'ESCAPE_CHAR' => '\\',
    'KEYWORDS' => array(
        1 => array(
		'append', 'break', 'catch', 'contains', 'continue', 'delete', 'else', 'false', 'for', 
		'function', 'if', 'in', 'isset', 'null', 'return', 'self', 'then', 'true', 'try', 'yield',
            ),
        ),
    'SYMBOLS' => array(
        '(', ')', '[', ']', '{', '}',
        '+', '-', '*', '/',
        '!', '&', '|', '^',
        '<', '>', '=',
        ',', ';', '?', ':', '::',
        ),
    'CASE_SENSITIVE' => array(
        GESHI_COMMENTS => false,
        1 => true,
        ),
    'STYLES' => array(
        'KEYWORDS' => array(
            1 => 'color: #000066; font-weight: bold;',
            ),
        'COMMENTS' => array(
            1 => 'color: #006600; font-style: italic;',
            2 => 'color: #009966; font-style: italic;',
            'MULTI' => 'color: #006600; font-style: italic;'
            ),
        'ESCAPE_CHAR' => array(
            0 => 'color: #000099; font-weight: bold;'
            ),
        'BRACKETS' => array(
            0 => 'color: #009900;'
            ),
        'STRINGS' => array(
            0 => 'color: #3366CC;'
            ),
        'NUMBERS' => array(
            0 => 'color: #CC0000;'
            ),
        'METHODS' => array(
            1 => 'color: #660066;'
            ),
        'SYMBOLS' => array(
            0 => 'color: #339933;'
            ),
        'REGEXPS' => array(
            ),
        'SCRIPT' => array(
            0 => '',
            )
        ),
    'URLS' => array(
        1 => '',
        ),
    'OOLANG' => false,
    'REGEXPS' => array(
        ),
    'STRICT_MODE_APPLIES' => GESHI_NEVER,
    'SCRIPT_DELIMITERS' => array(),
    'HIGHLIGHT_STRICT_BLOCK' => array(),
);

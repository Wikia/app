<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
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
 * @author Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/*****************************************************************************{/

/**
 * COMMA
 *
 * A comma
 */
define( 'COMMA', "," );

/**
 * NL
 *
 * The UNIX new line
 */
define( 'NL', "\n" );

/**
 * TAB
 *
 * A horizontal tab
 *
 */
define( 'TAB', "\t" );

/**
 * BR
 *
 * The html new line
 */
define( 'BR', '<br />' );

/**
 * PREo
 *
 * The html open pre tag
 */
define( 'PREo', '<pre style="text-align: left;">' );

/**
 * PREc
 *
 * The html close pre tag
 */
define( 'PREc', '</pre>' );

/**
 * HR
 *
 * The html Horizontal Rule
 */
define( 'HR', '<hr />' );

/**
 * _
 *
 * A space
 */
define( '_', ' ' );

/**
 * DS
 *
 * The directory separator.
 */
define( 'DS', DIRECTORY_SEPARATOR );

/**
 * PS
 *
 * Path Separator
 */
define( 'PS', PATH_SEPARATOR );

/**
 * PN
 *
 * Paamayim Nekudotayim
 */
define( 'PN', '::' );

/**
 * DUMP
 *
 * This is used bu Debug:dump() in an eval() call. This causes the variable dump
 * to output line and file information.
 */
define( 'DUMP', 'return	__FILE__ . _ . PN . _ . date(\'r\') . _ . NL;' );


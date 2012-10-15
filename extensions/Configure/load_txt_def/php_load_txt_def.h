/**
 * Copyright (C) 2009 Alexandre Emsenhuber
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

#ifndef PHP_LOAD_TXT_DEF_H
#define PHP_LOAD_TXT_DEF_H

#define PHP_LOAD_TXT_DEF_VERSION "0.3"

extern zend_module_entry load_txt_def_module_entry;

PHP_MINFO_FUNCTION( load_txt_def );
PHP_FUNCTION( load_txt_def );

void ltd_trim( char*, int, char**, int* );
int ltd_in_array( char**, int, char* );
int ltd_skip_subarrays( char*, int, char**, char*, int );
int ltd_process_array( zval*, char*, int, char*, int );
int ltd_process_entry( zval*, char*, int, char*, int );
zval *ltd_transform_to_zval( char*, int );

#endif	/* PHP_LOAD_TXT_DEF_H */

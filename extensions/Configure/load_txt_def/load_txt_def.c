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

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_load_txt_def.h"
#include "main/php_streams.h"

#if HAVE_STRING_H
#include <string.h>
#else
#include <strings.h>
#endif

/* True global resources - no need for thread safety here */
static int le_load_txt_def;

/**
 * {{{ load_txt_def_functions[]
 *
 * Every user visible function must have an entry in load_txt_def_functions[].
 */
zend_function_entry load_txt_def_functions[] = {
	PHP_FE( load_txt_def, NULL )
	{NULL, NULL, NULL}
};
/* }}} */

/**
 * {{{ load_txt_def_module_entry
 */
zend_module_entry load_txt_def_module_entry = {
	STANDARD_MODULE_HEADER,
	"load_txt_def",
	load_txt_def_functions,
	NULL,
	NULL,
	NULL,
	NULL,
	PHP_MINFO( load_txt_def ),
	PHP_LOAD_TXT_DEF_VERSION,
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_LOAD_TXT_DEF
ZEND_GET_MODULE( load_txt_def )
#endif

/**
 * {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION( load_txt_def ) {
	php_info_print_table_start();
	php_info_print_table_row( 2, "load_txt_def support", "enabled" );
	php_info_print_table_row( 2, "load_txt_def version", PHP_LOAD_TXT_DEF_VERSION );
	php_info_print_table_end();
}
/* }}} */


/**
 * {{{ proto array load_txt_def( string filename [, bool use_include_path[, array definitions]] )
 */
PHP_FUNCTION( load_txt_def ) {
	char *filename = NULL, *contents = NULL;
	int  filename_len, contents_len;
	int use_include_path = 0;
	php_stream *def_file;

	char eol_marker = '\n', *head = NULL;

	char **lines = NULL, *line, *new_line, *trim_line, *comment, *pos, *start, *end;
	int  lines_len = 0, line_len, new_line_len, trim_line_len;

	zval *entry = NULL, *values = NULL, **oldvalues = NULL;

	char *delim, *arg, *trim_arg, *end_arg, *keyval;
	int delim_len, arg_len, end_arg_len, keyval_len, is_array;

	zval *definitions = NULL, **def_key, **def_value;
	HashTable *def_key_hash;
	HashPosition def_pointer;
	char **k_array = NULL, **k_allowed = NULL, *k_key = NULL;
	int k_array_len = 0, k_allowed_len = 0, k_key_len = 0;

	int i = 0, retval = SUCCESS;

	if ( zend_parse_parameters( ZEND_NUM_ARGS() TSRMLS_CC, "s|ba", &filename, &filename_len, &use_include_path, &definitions ) == FAILURE ) {
		RETURN_FALSE;
	}

	/* Open the file */
	def_file = php_stream_open_wrapper( filename, "rb", ( use_include_path ? USE_PATH : 0 ) | REPORT_ERRORS, NULL );

	/* If something went wrong */
	if ( !def_file ) {
		RETURN_FALSE;
	}

	/* Time to process the file! */
	array_init( return_value );

	if ( ( contents_len = php_stream_copy_to_mem( def_file, &contents, PHP_STREAM_COPY_ALL, 0 ) ) > 0 ) {
		/* $lines = explode( "\n", $contents ); but in C :) */
		start = contents;
		end = contents + contents_len;

		if ( !( pos = php_stream_locate_eol( def_file, contents, contents_len TSRMLS_CC ) ) ) {
 			pos = end;
		}

		if ( def_file->flags & PHP_STREAM_FLAG_EOL_MAC ) {
			eol_marker = '\r';
		}

		do {
			line_len = (int)( pos - start );
			if ( line_len == 0 ) {
				start = ++pos;
				continue;
			}

			line = estrndup( start, line_len );
			comment = memchr( line, '#', line_len );
			if ( comment != NULL ) {
				new_line_len = (int)( comment - line );
				new_line = estrndup( line, new_line_len );
				efree( line );
			} else {
				new_line_len = line_len;
				new_line = line;
			}

			ltd_trim( new_line, new_line_len, &trim_line, &trim_line_len );

			if ( trim_line_len > 0 ) {
				lines_len++;
				lines = ( char** ) erealloc( lines, sizeof( char* ) * lines_len );
				lines[lines_len-1] = estrndup( trim_line, trim_line_len );
			}

			efree( new_line );
			start = ++pos;
		} while ( ( pos = memchr( pos, eol_marker, ( end - pos ) ) ) );

		/* We generally miss the last line with the above loop */
		if ( ( end - start ) > 0 ) {
			line_len = (int)( end - start );

			line = estrndup( start, line_len );
			comment = memchr( line, '#', line_len );
			if ( comment != NULL ) {
				new_line_len = (int)( comment - line );
				new_line = estrndup( line, new_line_len );
				efree( line );
			} else {
				new_line_len = line_len;
				new_line = line;
			}

			ltd_trim( new_line, new_line_len, &trim_line, &trim_line_len );

			if ( trim_line_len > 0 ) {
				lines_len++;
				lines = ( char** ) erealloc( lines, sizeof( char* ) * lines_len );
				lines[lines_len-1] = estrndup( trim_line, trim_line_len );
			}

			efree( new_line );
		}

		efree( contents );
		php_stream_close( def_file );

		/* parse definitions */
		if ( definitions ) {
			if ( zend_hash_find( Z_ARRVAL_P( definitions ), "array", sizeof( "array" ), (void**)&def_key ) == SUCCESS ) {
				if ( Z_TYPE_PP( def_key ) != IS_ARRAY ) {
					php_error( E_WARNING, "The \"array\" key of the third parameter must be an array!" );
					goto free;
				}
				def_key_hash = Z_ARRVAL_PP( def_key );
				for ( zend_hash_internal_pointer_reset_ex( def_key_hash, &def_pointer );
					zend_hash_get_current_data_ex( def_key_hash, (void**)&def_value, &def_pointer ) == SUCCESS;
					zend_hash_move_forward_ex( def_key_hash, &def_pointer ) ) {

					convert_to_string( *def_value );
					k_array_len++;
					k_array = ( char** ) erealloc( k_array, sizeof( char* ) * k_array_len );
					k_array[k_array_len-1] = Z_STRVAL_PP( def_value );
				}
			}
			if ( zend_hash_find( Z_ARRVAL_P( definitions ), "allowed", sizeof( "allowed" ), (void**)&def_key ) == SUCCESS ) {
				if ( Z_TYPE_PP( def_key ) != IS_ARRAY ) {
					php_error( E_WARNING, "The \"allowed\" key of the third parameter must be an array!" );
					goto free;
				}
				def_key_hash = Z_ARRVAL_PP( def_key );
				for ( zend_hash_internal_pointer_reset_ex( def_key_hash, &def_pointer );
					zend_hash_get_current_data_ex( def_key_hash, (void**)&def_value, &def_pointer ) == SUCCESS;
					zend_hash_move_forward_ex( def_key_hash, &def_pointer ) ) {

					convert_to_string( *def_value );
					k_allowed_len++;
					k_allowed = ( char** ) erealloc( k_allowed, sizeof( char* ) * k_allowed_len );
					k_allowed[k_allowed_len-1] = Z_STRVAL_PP( def_value );
				}
			}
			if ( zend_hash_find( Z_ARRVAL_P( definitions ), "key", sizeof( "key" ), (void**)&def_key ) == SUCCESS ) {
				convert_to_string( *def_key );
				k_key = Z_STRVAL_PP( def_key );
				k_key_len = Z_STRLEN_PP( def_key );
			}
		}

		/* real stuff */
		for ( i = 0; i < lines_len; i++ ) {
			line = lines[i];
			delim = index( line, '=' );

			if ( delim != NULL ) {
				if ( !head ) {
					/* eek, we need an initialized header */
					php_error( E_WARNING, "There must be an header before any data in '%s' on line %i", filename, i + 1 );
					retval = FAILURE;
					break;
				}

				delim_len = (int)( delim - line );
				arg = estrndup( line, delim_len );
				ltd_trim( arg, delim_len, &trim_arg, &arg_len );

				line += delim_len + 1;
				is_array = 0;

				if ( arg_len > 2 ) {
					end_arg = trim_arg + arg_len - 2;
				} else {
					end_arg = "";
				}

				if ( end_arg[0] == '[' && end_arg[1] == ']' ) {
					arg_len -= 2;
					trim_arg[arg_len] = '\0';
					trim_arg[arg_len+1] = '\0';
					is_array = 1;
				}

				/* Check for allowed keys */
				if ( k_allowed_len > 0 ) {
					if ( !ltd_in_array( k_allowed, k_allowed_len, trim_arg ) ) {
						php_error( E_WARNING, "The key '%s' is not in the allowed keys in '%s' on line %i", trim_arg, filename, i + 1 );
						efree( arg );
						if ( entry )
							zval_dtor( entry );
						retval = FAILURE;
						break;
					}
				}

				/* Only check if it's not an array */
				if ( !is_array && k_array_len > 0 ) {
					if ( ltd_in_array( k_array, k_array_len, trim_arg ) )
						is_array = 1;
				}

				if ( is_array ) {
					if ( zend_hash_find( Z_ARRVAL_P( entry ), trim_arg, arg_len + 1, (void**)&oldvalues ) == SUCCESS ) {
						values = *oldvalues;
					} else {
						MAKE_STD_ZVAL( values );
						array_init( values );
					}

					if ( ltd_process_array( values, line, strlen( line ), filename, i + 1 ) == FAILURE ) {
						efree( arg );
						zval_dtor( values );
						retval = FAILURE;
						break;
					}

					if ( !oldvalues )
						add_assoc_zval_ex( entry, trim_arg, arg_len + 1, values );
					values = NULL;
					oldvalues = NULL;
				} else {
					ltd_trim( line, strlen( line ), &keyval, &keyval_len );
					add_assoc_zval_ex( entry, trim_arg, arg_len + 1, ltd_transform_to_zval( keyval, keyval_len ) );
				}
				efree( arg );
			} else {
				/* next item, add the current if we have one and initialse the next one */
				if ( head ) {
					if ( k_key_len > 0 ) {
						add_assoc_string_ex( entry, k_key, k_key_len + 1, head, 1 );
						add_next_index_zval( return_value, entry );
					} else {
						add_assoc_zval( return_value, head, entry );
					}
					entry = NULL;
				}
				MAKE_STD_ZVAL( entry );
				array_init( entry );
				head = line;
			}
		}

free:
		if ( head && retval == SUCCESS ) {
			if ( k_key_len > 0 ) {
				add_assoc_string_ex( entry, k_key, k_key_len + 1, head, 1 );
				add_next_index_zval( return_value, entry );
			} else {
				add_assoc_zval( return_value, head, entry );
			}
		} else if ( entry ) {
			zval_dtor( entry );
		}

		/* free */
		for ( i = 0; i < lines_len; i++ ) {
			efree( lines[i] );
		}
		if ( i > 0 )
			efree( lines );

		if ( k_array_len > 0 )
			efree( k_array );
		if ( k_allowed_len > 0 )
			efree( k_allowed );
		

		if ( retval == FAILURE ) {
			/* Time to free all the memory! */
			zval_dtor( return_value );
			RETURN_FALSE;
		}

	} else {
		php_stream_close( def_file );
	}
}
/* }}} */

	
void ltd_trim( char *istr, int ilen, char **ostr, int *olen ) {
	char *buf, *tmp, *tmp2;
	int len = 0;

	if ( istr ) {
		tmp = istr;
		*olen = ilen;

		for ( buf = tmp; *buf && isspace( *buf ); ++buf );
		len = (int)( buf - tmp );
		if ( len > 0 ) {
			*olen -= len;
			tmp = buf;
		}
		tmp2 = tmp + *olen - 1;
		for ( buf = tmp2; (int)( buf - tmp ) > 0 && isspace( *buf ); --buf );
		len = (int)( tmp2 - buf );
		if ( len > 0 ) {
			*olen -= len;
			tmp[*olen] = '\0';
		}
		*ostr = tmp;
	} else {
		*olen = ilen;
		*ostr = istr;
	}
}

int ltd_in_array( char** array, int array_len, char* string ) {
	int i;

	for ( i = 0; i < array_len; i++ ) {
		if ( strcmp( array[i], string ) == 0 )
			return 1;
	}

	return 0;
}

int ltd_skip_subarrays( char *pos, int len, char **new_pos, char *filename, int line_number ) {
	char *brace_open, *brace_close, *old_brace, *init_pos;
	int brace_count = 0;
	int new_len, brace_type, open_brace_len, close_brace_len;	

	init_pos = pos;
	old_brace = pos;
	new_len = len;

	do {
		brace_type = 0;
		brace_open = memchr( old_brace, '{', new_len );
		brace_close = memchr( old_brace, '}', new_len );

		if ( brace_open == NULL && brace_close == NULL ) {
			break;
		} else if ( brace_open == NULL ) {
			brace_type = -1;
			close_brace_len = (int)( brace_close - old_brace );
		} else if ( brace_close == NULL ) {
			brace_type = 1;
			open_brace_len = (int)( brace_open - old_brace );
		} else {
			close_brace_len = (int)( brace_close - old_brace );
			open_brace_len = (int)( brace_open - old_brace );
			if ( close_brace_len > open_brace_len ) {
				brace_type = 1;
			} else {
				brace_type = -1;
			}
		}

		if ( brace_count <= 0 && brace_type == -1 ) {
			php_error( E_WARNING, "Unbalanced brace count in '%s' on line %i (string was: %s)", filename, line_number, init_pos );
			*new_pos = init_pos;
			return FAILURE;
		}

		brace_count += brace_type;
		if ( brace_type == 1 ) {
			old_brace = ++brace_open;
			new_len -= open_brace_len + 1;
		} else if ( brace_type == -1 ) {
			old_brace = ++brace_close;
			new_len -= close_brace_len + 1;
		} else {
			php_error( E_WARNING, "Internal error: brace_type is invalid (%i), have to be 1 or -1 in '%s' on line %i (string was: %s)", brace_type, filename, line_number, init_pos );
			*new_pos = init_pos;
			return FAILURE;
		}

		if ( brace_count == 0 ) {
			break;
		}
	} while( true );

	if ( brace_count == 0 ) {
		*new_pos = old_brace;
		return SUCCESS;
	} else {
		*new_pos = init_pos;
		return FAILURE;
	}
}

int ltd_process_array( zval *values, char *line, int line_len, char *filename, int line_number ) {
	char *start, *pos, *new_pos, *end;
	char *keyval;
	int keyval_len, retval;

	start = line;
	end = line + line_len;
	pos = start;

	while ( ( pos = memchr( pos, ',', ( end - pos ) ) ) ) {
		if ( !( pos - start ) ) {
			start = ++pos;
			continue;
		}

		keyval_len = (int)( pos - start );
		keyval = estrndup( start, keyval_len );

		if ( memchr( keyval, '{', keyval_len ) != NULL && memchr( keyval, '}', keyval_len ) == NULL ) {
			efree( keyval );
			if ( ltd_skip_subarrays( start, (int)( end - start ), &new_pos, filename, line_number ) == FAILURE )
				return FAILURE;
			pos = new_pos;
			continue;
		}

		retval = ltd_process_entry( values, keyval, keyval_len, filename, line_number );

		efree( keyval );

		if ( retval == FAILURE )
			return FAILURE;

		start = ++pos;
	}

	/* We generally miss the last line with the above loop */
	if ( start != end ) {
		keyval_len = (int)( end - start );
		keyval = estrndup( start, keyval_len );

		retval = ltd_process_entry( values, keyval, keyval_len, filename, line_number ); 

		efree( keyval );
		
		if ( retval == FAILURE )
			return FAILURE;
	}

	return SUCCESS;
}

int ltd_process_entry( zval *values, char *keyval, int keyval_len, char *filename, int line_number ) {
	char *trim_keyval, *key, *trim_key, *val, *trim_val, *col = NULL, *tmp_val;
	int trim_keyval_len, key_len, trim_key_len, val_len, trim_val_len, col_pos;
	char *brace_open, *brace_close, *tmp_brace, *subarray;
	int brace_len, tmp_brace_len, subarray_len;
	int ret_val = SUCCESS;
	zval *subvalues;

	ltd_trim( keyval, keyval_len, &trim_keyval, &trim_keyval_len );

	if ( trim_keyval[0] == '{' ) {
		trim_val = trim_keyval;
		trim_val_len = trim_keyval_len;
	} else {
		col = memchr( trim_keyval, ':', trim_keyval_len );

		if ( col == NULL ) {
			trim_val = trim_keyval;
			trim_val_len = trim_keyval_len;
		} else {
			col_pos = (int)( col - trim_keyval );

			key_len = col_pos;
			key = estrndup( trim_keyval, col_pos );
			ltd_trim( key, key_len, &trim_key, &trim_key_len );

			tmp_val = trim_keyval + col_pos + 1;
			val_len = trim_keyval_len - col_pos - 1;
			val = estrndup( tmp_val, val_len );
			ltd_trim( val, val_len, &trim_val, &trim_val_len );
		}
	}

	brace_open = memchr( trim_val, '{', trim_val_len );

	if ( brace_open != NULL ) {
		brace_open++;
		brace_len = (int)( brace_open - trim_val );

		brace_close = memchr( brace_open, '}', trim_val_len - brace_len );
		if ( brace_close == NULL ) {
			php_error( E_WARNING, "Unbalanced brace count in '%s' on line %i", filename, line_number );
			ret_val = FAILURE;
			goto out;
		}

		tmp_brace_len = (int)( brace_close - brace_open );
		if ( memchr( brace_open, '{', tmp_brace_len ) != NULL ) {
			if ( ltd_skip_subarrays( brace_open, trim_val_len - brace_len, &tmp_brace, filename, line_number ) == FAILURE ) {
				ret_val = FAILURE;
				goto out;
			}
			tmp_brace_len = (int)( tmp_brace - trim_val );
			brace_close = memchr( tmp_brace, '}', trim_val_len - tmp_brace_len );
		}

		subarray_len = (int)( brace_close - brace_open ) - 1;
		subarray = estrndup( brace_open, subarray_len );

		MAKE_STD_ZVAL( subvalues );
		array_init( subvalues );

		if( ltd_process_array( subvalues, subarray, subarray_len, filename, line_number ) == FAILURE ) {
			efree( subarray );
			zval_dtor( subvalues );
			ret_val = FAILURE;
			goto out;
		}

		if ( col == NULL ) {
			add_next_index_zval( values, subvalues );
		} else {
			add_assoc_zval_ex( values, trim_key, trim_key_len + 1, subvalues );
		}
		efree( subarray );
	} else {
		if ( col == NULL ) {
			add_next_index_zval( values, ltd_transform_to_zval( trim_val, trim_val_len ) );
		} else {
			add_assoc_zval_ex( values, trim_key, trim_key_len + 1, ltd_transform_to_zval( trim_val, trim_val_len ) );
		}
	}

out:
	if ( col != NULL ) {
		efree( key );
		efree( val );
	}
	return ret_val;
}

zval *ltd_transform_to_zval( char *val, int val_len ) {
	zval *retval;

	MAKE_STD_ZVAL( retval );

	if ( val_len == 4 && strcmp( val, "true" ) == 0 ) {
		ZVAL_TRUE( retval );
	} else if ( val_len == 4 && strcmp( val, "null" ) == 0 ) {
		ZVAL_NULL( retval );
	} else if ( val_len == 5 && strcmp( val, "false" ) == 0 ) {
		ZVAL_FALSE( retval );
	} else {
		ZVAL_STRINGL( retval, val, val_len, 1 );
	}
	return retval;
}

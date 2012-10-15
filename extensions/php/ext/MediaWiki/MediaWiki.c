/*
  +----------------------------------------------------------------------+
  | PHP Version 4                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2003 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 2.02 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available at through the world-wide-web at                           |
  | http://www.php.net/license/2_02.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+

  $Id: MediaWiki.c 584 2008-07-29 13:59:13Z emil $ 
*/

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_MediaWiki.h"

/* If you declare any globals in php_MediaWiki.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(MediaWiki)
*/

/* True global resources - no need for thread safety here */
static int le_MediaWiki;

/* {{{ MediaWiki_functions[]
 *
 * Every user visible function must have an entry in MediaWiki_functions[].
 */
function_entry MediaWiki_functions[] = {
	PHP_FE(confirm_MediaWiki_compiled,	NULL)		/* For testing, remove later. */
	PHP_FE(mediawiki_ucfirst, NULL)				/* uppercase first character of a string, UTF8 */
	{NULL, NULL, NULL}	/* Must be the last line in MediaWiki_functions[] */
};
/* }}} */

/* {{{ MediaWiki_module_entry
 */
zend_module_entry MediaWiki_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"MediaWiki",
	MediaWiki_functions,
	PHP_MINIT(MediaWiki),
	PHP_MSHUTDOWN(MediaWiki),
	PHP_RINIT(MediaWiki),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(MediaWiki),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(MediaWiki),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1", /* Replace with version number for your extension */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_MEDIAWIKI
ZEND_GET_MODULE(MediaWiki)
#endif

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("MediaWiki.global_value",      "42", PHP_INI_ALL, OnUpdateInt, global_value, zend_MediaWiki_globals, MediaWiki_globals)
    STD_PHP_INI_ENTRY("MediaWiki.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_MediaWiki_globals, MediaWiki_globals)
PHP_INI_END()
*/
/* }}} */

/* {{{ php_MediaWiki_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_MediaWiki_init_globals(zend_MediaWiki_globals *MediaWiki_globals)
{
	MediaWiki_globals->global_value = 0;
	MediaWiki_globals->global_string = NULL;
}
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(MediaWiki)
{
	/* If you have INI entries, uncomment these lines 
	ZEND_INIT_MODULE_GLOBALS(MediaWiki, php_MediaWiki_init_globals, NULL);
	REGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(MediaWiki)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(MediaWiki)
{
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(MediaWiki)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(MediaWiki)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "MediaWiki support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */


/* Remove the following function when you have succesfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_MediaWiki_compiled(string arg)
   Return a string to confirm that the module is compiled in */
PHP_FUNCTION(confirm_MediaWiki_compiled)
{
	char *arg = NULL;
	int arg_len, len;
	char string[256];

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
		return;
	}

	len = sprintf(string, "Congratulations! You have successfully modified ext/%.78s/config.m4. Module %.78s is now compiled into PHP.", "MediaWiki", arg);
	RETURN_STRINGL(string, len, 1);
}
/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/

/* {{{ proto string mediawiki_ucfirst(string arg)
 * Upper case the first character of arg, returning a new string. */
PHP_FUNCTION(mediawiki_ucfirst)
{
	char *arg = NULL;
	int arg_len, len;
	char * string;
	int stringskip=0,argskip=0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
		return;
	}

	string=(char *)malloc(arg_len+3);
	if (string == NULL) {
		return;
	}

	if (arg[0] <= 'z' && arg[0]>='a') {
		string[0]=arg[0]+'A'-'a';
		argskip=stringskip=1;
	} else {
#include "utf8-toupper.c";
	}
	
	memcpy( string+stringskip, arg+argskip, arg_len-argskip);
	string[arg_len-argskip+stringskip]='\0';

	RETVAL_STRING(string, 1);
	free(string);
}
/* }}} */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

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

  $Id: proctitle.c 584 2008-07-29 13:59:13Z emil $ 
*/

#define MAXTITLE 1024

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <syslog.h>


#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_proctitle.h"
#include <dlfcn.h>

/* If you declare any globals in php_proctitle.h uncomment this:
ZEND_DECLARE_MODULE_GLOBALS(proctitle)
*/

/* True global resources - no need for thread safety here */
static int le_proctitle;
static char *proctitle_argv=NULL;
#ifndef HAVE_PROCTITLE
void setproctitle(char *title) {
        if (proctitle_argv)
	    	memcpy(proctitle_argv,title,strlen(title)+1); 

}
#endif

/* {{{ proctitle_functions[]
 *
 * Every user visible function must have an entry in proctitle_functions[].
 */
function_entry proctitle_functions[] = {
	PHP_FE(setproctitle,	NULL)		/* For testing, remove later. */
	{NULL, NULL, NULL}	/* Must be the last line in proctitle_functions[] */
};
/* }}} */

/* {{{ proctitle_module_entry
 */
zend_module_entry proctitle_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"proctitle",
	proctitle_functions,
	PHP_MINIT(proctitle),
	PHP_MSHUTDOWN(proctitle),
	PHP_RINIT(proctitle),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(proctitle),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(proctitle),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1", /* Replace with version number for your extension */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_PROCTITLE
ZEND_GET_MODULE(proctitle)
#endif

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(proctitle)
{
	char **symbol=NULL;
    if(!proctitle_argv) {
    	symbol=dlsym(NULL,"ap_server_argv0");
		if (symbol)
			proctitle_argv=*symbol;
	}
	setproctitle("httpd: php_init");
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(proctitle)
{
	setproctitle("httpd: php_deinit");
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(proctitle)
{
	setproctitle("httpd: requeststart");
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(proctitle)
{
	setproctitle("httpd: requestfinish");
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(proctitle)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "proctitle support", "enabled");
	php_info_print_table_end();
}
/* }}} */


PHP_FUNCTION(setproctitle)
{
	char *arg = NULL;
	int arg_len, len;
	int name_len;
	char *name="httpd: ";

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &arg, &arg_len) == FAILURE) {
		return;
	}
	if (arg_len>MAXTITLE)
		arg_len=MAXTITLE;
#ifndef HAVE_SETPROCTITLE
    name_len=strlen(name);
    if (proctitle_argv) {
        memcpy(proctitle_argv,name,name_len);
		memcpy(proctitle_argv+name_len,arg,arg_len);
		proctitle_argv[arg_len+name_len]='\0';
    }
#else
	setproctitle("%.*s",arg_len,arg);
#endif
}
/* }}} */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4
 * vim<600: noet sw=4 ts=4
 */

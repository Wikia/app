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

  $Id: php_proctitle.h 584 2008-07-29 13:59:13Z emil $ 
*/

#ifndef PHP_PROCTITLE_H
#define PHP_PROCTITLE_H

extern zend_module_entry proctitle_module_entry;
#define phpext_proctitle_ptr &proctitle_module_entry

#ifdef PHP_WIN32
#define PHP_PROCTITLE_API __declspec(dllexport)
#else
#define PHP_PROCTITLE_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_MINIT_FUNCTION(proctitle);
PHP_MSHUTDOWN_FUNCTION(proctitle);
PHP_RINIT_FUNCTION(proctitle);
PHP_RSHUTDOWN_FUNCTION(proctitle);
PHP_MINFO_FUNCTION(proctitle);

PHP_FUNCTION(setproctitle);	/* For testing, remove later. */

/* 
  	Declare any global variables you may need between the BEGIN
	and END macros here:     

ZEND_BEGIN_MODULE_GLOBALS(proctitle)
	long  global_value;
	char *global_string;
ZEND_END_MODULE_GLOBALS(proctitle)
*/

/* In every utility function you add that needs to use variables 
   in php_proctitle_globals, call TSRMLS_FETCH(); after declaring other 
   variables used by that function, or better yet, pass in TSRMLS_CC
   after the last function argument and declare your utility function
   with TSRMLS_DC after the last declared argument.  Always refer to
   the globals in your function as PROCTITLE_G(variable).  You are 
   encouraged to rename these macros something shorter, see
   examples in any other php module directory.
*/

#ifdef ZTS
#define PROCTITLE_G(v) TSRMG(proctitle_globals_id, zend_proctitle_globals *, v)
#else
#define PROCTITLE_G(v) (proctitle_globals.v)
#endif

#endif	/* PHP_PROCTITLE_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: t
 * End:
 */

/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2008 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id: header,v 1.16.2.1.2.1.2.1 2008/02/07 19:39:50 iliaa Exp $ */

#ifndef PHP_WIKIDIFF2_H
#define PHP_WIKIDIFF2_H

extern zend_module_entry wikidiff2_module_entry;
#define phpext_wikidiff2_ptr &wikidiff2_module_entry

#ifdef PHP_WIN32
#	define PHP_WIKIDIFF2_API __declspec(dllexport)
#elif defined(__GNUC__) && __GNUC__ >= 4
#	define PHP_WIKIDIFF2_API __attribute__ ((visibility("default")))
#else
#	define PHP_WIKIDIFF2_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_MINIT_FUNCTION(wikidiff2);
PHP_MSHUTDOWN_FUNCTION(wikidiff2);
PHP_RINIT_FUNCTION(wikidiff2);
PHP_RSHUTDOWN_FUNCTION(wikidiff2);
PHP_MINFO_FUNCTION(wikidiff2);

PHP_FUNCTION(wikidiff2_do_diff);



#ifdef ZTS
#define WIKIDIFF2_G(v) TSRMG(wikidiff2_globals_id, zend_wikidiff2_globals *, v)
#else
#define WIKIDIFF2_G(v) (wikidiff2_globals.v)
#endif

#endif


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

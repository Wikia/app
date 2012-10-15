/*
 * PHP extension for fast string search routines
 * Copyright Tim Starling, 2006
 * License: DWTFYWWI
*/

#ifndef PHP_FSS_H
#define PHP_FSS_H

extern zend_module_entry fss_module_entry;
#define phpext_fss_ptr &fss_module_entry

#ifdef PHP_WIN32
#define PHP_FSS_API __declspec(dllexport)
#else
#define PHP_FSS_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_MINIT_FUNCTION(fss);
PHP_MSHUTDOWN_FUNCTION(fss);
PHP_MINFO_FUNCTION(fss);

PHP_FUNCTION(fss_prep_search);
PHP_FUNCTION(fss_exec_search);
PHP_FUNCTION(fss_prep_replace);
PHP_FUNCTION(fss_exec_replace);
PHP_FUNCTION(fss_free);

#ifdef ZTS
#define FSS_G(v) TSRMG(fss_globals_id, zend_fss_globals *, v)
#else
#define FSS_G(v) (fss_globals.v)
#endif

#endif	/* PHP_FSS_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

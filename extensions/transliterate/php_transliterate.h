#ifndef PHP_TRANSLITERATE_H
#define PHP_TRANSLITERATE_H

extern zend_module_entry transliterate_module_entry;
#define phpext_transliterate_ptr &transliterate_module_entry

#ifdef PHP_WIN32
#define PHP_TRANSLITERATE_API __declspec(dllexport)
#else
#define PHP_TRANSLITERATE_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_MINIT_FUNCTION(transliterate);
PHP_MSHUTDOWN_FUNCTION(transliterate);
PHP_MINFO_FUNCTION(transliterate);
PHP_RSHUTDOWN_FUNCTION(transliterate);

PHP_FUNCTION(transliterate_with_id);

ZEND_BEGIN_MODULE_GLOBALS(transliterate)
	Transliterator * trans;
	char * trans_name;
	int trans_name_length;
ZEND_END_MODULE_GLOBALS(transliterate)
	
#ifdef ZTS
#define TRANS_G(v) TSRMG(transliterate_globals_id, zend_transliterate_globals *, v)
#else
#define TRANS_G(v) (transliterate_globals.v)
#endif

#endif	/* PHP_TRANSLITERATE_H */


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

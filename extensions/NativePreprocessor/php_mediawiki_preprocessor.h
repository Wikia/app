#ifndef PHP_MEDIAWIKI_PREPROCESSOR_H
#define PHP_MEDIAWIKI_PREPROCESSOR_H 1

#ifdef ZTS
#include "TSRM.h"
#endif

ZEND_BEGIN_MODULE_GLOBALS(mediawiki_preprocessor)
    
ZEND_END_MODULE_GLOBALS(mediawiki_preprocessor)

#ifdef ZTS
#define MWPP_G(v) TSRMG(mediawiki_preprocessor_globals_id, zend_notas_globals *, v)
#else
#define MWPP_G(v) (mediawiki_preprocessor_globals.v)
#endif

#define PHP_MEDIAWIKI_PREPROCESSOR_VERSION "0.1"
#define PHP_MEDIAWIKI_PREPROCESSOR_EXTNAME "MediaWiki Preprocessor"

PHP_MINIT_FUNCTION(mediawiki_preprocessor);
PHP_MSHUTDOWN_FUNCTION(mediawiki_preprocessor);
PHP_RINIT_FUNCTION(mediawiki_preprocessor);

extern zend_module_entry mediawiki_preprocessor_module_entry;
#define phpext_mediawiki_preprocessor_ptr &mediawiki_preprocessor_module_entry

#endif

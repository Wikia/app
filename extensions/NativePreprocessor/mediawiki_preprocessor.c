#ifdef HAVE_CONFIG_H
#include "config.h"
#endif


#include "php.h"
#include "php_ini.h"
#include "php_mediawiki_preprocessor.h"


#if ZEND_DEBUG || 1
#define DEBUG(x,...) php_printf("[MWPP] "x"\n", __VA_ARGS__)
#else
#define DEBUG(x,...) 
#endif

typedef struct _mediawiki_preprocessor {
	zend_object   std; /* Inherit from a standard php object */
	
} mwppobj;

ZEND_DECLARE_MODULE_GLOBALS(mediawiki_preprocessor)

zend_module_entry mediawiki_preprocessor_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
    STANDARD_MODULE_HEADER,
#endif
    PHP_MEDIAWIKI_PREPROCESSOR_EXTNAME,
    NULL, /* No procedures */
    PHP_MINIT(mediawiki_preprocessor), /* module_startup_func */
    PHP_MSHUTDOWN(mediawiki_preprocessor), /* module_shutdown_func */
    PHP_RINIT(mediawiki_preprocessor), /* request_startup_func */
    NULL, /* request_shutdown_func */
    NULL, /* info_func */
#if ZEND_MODULE_API_NO >= 20010901
    PHP_MEDIAWIKI_PREPROCESSOR_VERSION,
#endif
    STANDARD_MODULE_PROPERTIES
};

#ifdef COMPILE_DL_MEDIAWIKI_PREPROCESSOR
ZEND_GET_MODULE(mediawiki_preprocessor)
#endif

PHP_RINIT_FUNCTION(mediawiki_preprocessor)
{
    /* Request init */

    return SUCCESS;
}

PHP_MSHUTDOWN_FUNCTION(mediawiki_preprocessor)
{
    /* Module shutdown */

    return SUCCESS;
}

PHP_METHOD(WikiTextPreprocessor,preprocessToObj);
/* {{{ arginfo__construct */
ZEND_BEGIN_ARG_INFO_EX(/*name*/ arginfopreprocessToObj, /*pass_rest_by_reference*/ 0, /*return_reference*/ 0, /*required_num_args*/ 3)
	ZEND_ARG_INFO(/*pass_by_ref*/ 0, /*name*/ "WikiText")
ZEND_END_ARG_INFO()
/* }}} */

static const zend_function_entry mwpp_methods[] = {
	PHP_ME(WikiTextPreprocessor, preprocessToObj, arginfopreprocessToObj, ZEND_ACC_PUBLIC)
	{NULL, NULL, NULL}
};

static void free_mwppobj(void *object TSRMLS_DC);
static zend_object_value create_mwppobj (zend_class_entry *class_type TSRMLS_DC);

static void php_mwpp_init_globals(zend_mediawiki_preprocessor_globals *mwpp_globals)
{
	/* No globals to init */
}

PHP_MINIT_FUNCTION(mediawiki_preprocessor)
{
	/* Module init */
	zend_class_entry ce;
	zend_class_entry* registered_class;

    ZEND_INIT_MODULE_GLOBALS(mediawiki_preprocessor, php_mwpp_init_globals, NULL);

	INIT_CLASS_ENTRY(ce, "MediaWikiPreprocessor", mwpp_methods); /* Define class MediaWikiPreprocessor */
	
	ce.create_object = create_mwppobj;
	registered_class = zend_register_internal_class(&ce TSRMLS_CC); /* Bring it to existence */

    return SUCCESS;
}

static zend_object_value create_mwppobj (zend_class_entry *class_type TSRMLS_DC)
{
    zend_object_value retval;
    mwppobj *intern;	
	zval *tmp;

	intern = emalloc(sizeof(mwppobj));
	
	DEBUG("Creating MediaWikiPreprocessor %p", intern);
	
	zend_object_std_init(&intern->std, class_type TSRMLS_CC);
	zend_hash_copy(intern->std.properties, &class_type->default_properties, (copy_ctor_func_t) zval_add_ref, (void *) &tmp, sizeof(zval *));
	
	retval.handle = zend_objects_store_put(intern, (zend_objects_store_dtor_t)NULL, (zend_objects_free_object_storage_t) free_mwppobj, NULL TSRMLS_CC);
	retval.handlers = zend_get_std_object_handlers(); /* Default handlers */
	
	return retval;
}

static void free_mwppobj(void *object TSRMLS_DC)
{
	mwppobj *intern = (mwppobj *)object;

	zend_object_std_dtor(&intern->std TSRMLS_CC);
	efree(object);
	
	DEBUG("MediaWikiPreprocessor %p destroyed", object);
}

char* preprocessToObj( const char* text, int text_len, int flags, HashTable* parserStripList, int* preprocessed_len );
PHP_METHOD(WikiTextPreprocessor, preprocessToObj)
{
	zend_class_entry *class_entry;
	char *wikitext, *preprocessed;
	int wikitext_len, flags;
	int preprocessed_len;
	zval *array, *result;
	
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sda", &wikitext, &wikitext_len, &flags, &array) == FAILURE) {
        return;
    }
	wikitext_len = strlen(wikitext);
	DEBUG("Constructed with text «%s» of length %d, flags %d", wikitext, wikitext_len, flags );
	preprocessed = preprocessToObj( wikitext, wikitext_len, flags, Z_ARRVAL_P(array), &preprocessed_len );
	
	if ( !preprocessed ) {
		/* Preprocessing failed. The error code is given in preprocessed_len */
		if ( preprocessed_len == 1 ) {
			zend_throw_exception(zend_exception_get_default(), "Non-strings found in the parser strip list", 1 TSRMLS_CC);
		} else {
			zend_throw_exception(zend_exception_get_default(), "Unknown error preprocessing", 1 TSRMLS_CC);
		}
	}

	RETURN_STRINGL( preprocessed, preprocessed_len, 0 );
}

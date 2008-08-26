
#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <unicode/translit.h>

extern "C" {

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_transliterate.h"

/* True global resources - no need for thread safety here */
static int le_transliterate;

ZEND_DECLARE_MODULE_GLOBALS(transliterate)

/* {{{ transliterate_functions[]
 */
zend_function_entry transliterate_functions[] = {
	PHP_FE(transliterate_with_id, NULL)
	/*PHP_FE(transliterate_with_rules, NULL)*/
	{NULL, NULL, NULL}
};
/* }}} */

/* {{{ transliterate_module_entry
 */
zend_module_entry transliterate_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"transliterate",
	transliterate_functions,
	PHP_MINIT(transliterate),
	PHP_MSHUTDOWN(transliterate),
	NULL, /* RINIT */
	PHP_RSHUTDOWN(transliterate),
	PHP_MINFO(transliterate),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1", /* Version */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_TRANSLITERATE
ZEND_GET_MODULE(transliterate)
#endif

/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(transliterate)
{
	TRANS_G(trans) = NULL;
	TRANS_G(trans_name) = NULL;
	TRANS_G(trans_name_length) = 0;
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(transliterate)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_RSHUTDOWN_FUNCTION 
 */
PHP_RSHUTDOWN_FUNCTION(transliterate)
{
	if (TRANS_G(trans)) {
		delete TRANS_G(trans);
		TRANS_G(trans) = NULL;
	}
	if (TRANS_G(trans_name)) {
		efree(TRANS_G(trans_name));
		TRANS_G(trans_name) = NULL;
		TRANS_G(trans_name_length) = 0;
	}
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(transliterate)
{
	php_info_print_table_start();
	php_info_print_table_row(2, "ICU transliteration support", "enabled");
	php_info_print_table_end();
}
/* }}} */

/* {{{ */
static Transliterator * get_transliterator(char *transID, int transIDLength TSRMLS_DC)
{
	if (!TRANS_G(trans) 
			|| transIDLength != TRANS_G(trans_name_length)
			|| memcmp(transID, TRANS_G(trans_name), (size_t)transIDLength) != 0)
	{
		/* The old transliterator can't be reused, delete it */
		if (TRANS_G(trans)) {
			delete TRANS_G(trans);
		}
		if (TRANS_G(trans_name)) {
			efree(TRANS_G(trans_name));
		}
		TRANS_G(trans_name) = estrndup(transID, transIDLength);
		TRANS_G(trans_name_length) = transIDLength;
		
		/* Open the transliterator */
		UErrorCode error = U_ZERO_ERROR;
		UnicodeString uTransID(transID, transIDLength);
		TRANS_G(trans) = Transliterator::createInstance(uTransID, UTRANS_FORWARD, error);

		if (U_FAILURE(error)) {
			if (error == U_INVALID_ID) {
				php_error(E_WARNING, "transliterate_with_id: Invalid transliterator ID");
			} else {
				php_error(E_WARNING, "transliterate_with_id: Transliterator::createInstance returned %s", 
					u_errorName(error));
			}
			delete TRANS_G(trans);
			efree(TRANS_G(trans_name));
			TRANS_G(trans) = NULL;
			TRANS_G(trans_name) = NULL;
		}
	}
	return TRANS_G(trans);
}

/* }}} */

/* {{{ proto string transliterate_with_id(string transID, string source)
   Transliterate with a given ICU transform ID */
PHP_FUNCTION(transliterate_with_id)
{
	char *transID = NULL, *source = NULL, *output;
	int transIDLength, sourceLength, tempLength, outputLength;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss", 
		&transID, &transIDLength, &source, &sourceLength) == FAILURE) 
	{
		RETURN_FALSE;
	}
	
	try {
		Transliterator * trans = get_transliterator(transID, transIDLength TSRMLS_CC);
		if (!trans) {
			/* Error report already done */
			RETURN_FALSE;
		}
		/* Convert the string */
		UnicodeString buffer(source, sourceLength, "UTF-8");
		trans->transliterate(buffer);

		/* Write it out to an emalloc'd buffer */
		tempLength = buffer.length() + 1;
		if (tempLength <= 0) {
			php_error(E_WARNING, "transliterate_with_id: output buffer too large (>2GB)");
			RETURN_FALSE;
		}
		output = (char*)emalloc(tempLength);
		outputLength = buffer.extract(0, buffer.length(), output, tempLength, "UTF-8");
		
		/* If the buffer wasn't big enough, expand it to the correct size and try again */
		if (outputLength > tempLength) {
			output = (char*)erealloc(output, outputLength + 1);
			buffer.extract(0, buffer.length(), output, outputLength + 1, "UTF-8");
		}

		RETURN_STRINGL(output, outputLength, 0);
	} catch (...) {
	}
	php_error(E_WARNING, "transliterate_with_id: unexpected C++ exception");
	RETURN_FALSE;
}
/* }}} */

} // end extern "C"

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_wikidiff2.h"
#include "wikidiff2.h"

static int le_wikidiff2;

zend_function_entry wikidiff2_functions[] = {
	PHP_FE(wikidiff2_do_diff,	NULL)
	{NULL, NULL, NULL}
};


zend_module_entry wikidiff2_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"wikidiff2",
	wikidiff2_functions,
	PHP_MINIT(wikidiff2),
	PHP_MSHUTDOWN(wikidiff2),
	PHP_RINIT(wikidiff2),	
	PHP_RSHUTDOWN(wikidiff2),
	PHP_MINFO(wikidiff2),
#if ZEND_MODULE_API_NO >= 20010901
	"0.1",
#endif
	STANDARD_MODULE_PROPERTIES
};


#ifdef COMPILE_DL_WIKIDIFF2
ZEND_GET_MODULE(wikidiff2)
#endif

PHP_MINIT_FUNCTION(wikidiff2)
{
	return SUCCESS;
}

PHP_MSHUTDOWN_FUNCTION(wikidiff2)
{
	return SUCCESS;
}

PHP_RINIT_FUNCTION(wikidiff2)
{
	return SUCCESS;
}

PHP_RSHUTDOWN_FUNCTION(wikidiff2)
{
	return SUCCESS;
}

PHP_MINFO_FUNCTION(wikidiff2)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "wikidiff2 support", "enabled");
	php_info_print_table_end();

}

/* {{{ proto string wikidiff2_do_diff(string text1, string text2, int numContextLines)
    */
PHP_FUNCTION(wikidiff2_do_diff)
{
	char *text1 = NULL;
	char *text2 = NULL;
	int argc = ZEND_NUM_ARGS();
	int text1_len;
	int text2_len;
	long numContextLines;

	if (zend_parse_parameters(argc TSRMLS_CC, "ssl", &text1, &text1_len, &text2, 
		&text2_len, &numContextLines) == FAILURE)
	{
		return;
	}


	try {
		Wikidiff2 wikidiff2;
		Wikidiff2::String text1String(text1, text1_len);
		Wikidiff2::String text2String(text2, text2_len);
		const Wikidiff2::String & ret = wikidiff2.execute(text1String, text2String, numContextLines);
		RETURN_STRINGL( const_cast<char*>(ret.data()), ret.size(), 1);
	} catch (std::bad_alloc &e) {
		zend_error(E_WARNING, "Out of memory in wikidiff2_do_diff().");
	} catch (...) {
		zend_error(E_WARNING, "Unknown exception in wikidiff2_do_diff().");
	}
}
/* }}} */




#include <stdbool.h>
#include "php.h"
#define const
#include "in_array.h"

/**
 * This defines an interface for internally performing in_array()
 * You will notice that the similarity with php_search_array() is not casual.
 */
bool zval_in_array(const zval* value, const HashTable* array, bool strict) {
	zval **entry;			/* pointer to array entry */
	zval res;				/* comparison result */
	HashPosition pos;		/* hash iterator */
	int (*is_equal_func)(zval *, zval *, zval * TSRMLS_DC);
	
	TSRMLS_FETCH(); /* Useless for simple arrays, since it's only needed when comparing array values */
	
	is_equal_func = strict ? is_identical_function : is_equal_function;
	
	zend_hash_internal_pointer_reset_ex(array, &pos);
	while (zend_hash_get_current_data_ex(array, (void **)&entry, &pos) == SUCCESS) {
		is_equal_func(&res, value, *entry TSRMLS_CC);
		if (Z_LVAL(res)) { /* if ( (long)res ), ie. if ( res == true ) */
			return true;
		}
		zend_hash_move_forward_ex(array, &pos);
	}
	return false;
}

bool str_in_array(const char* string, int string_len, const HashTable* array, bool strict) {
	zval zstring;
	INIT_ZVAL(zstring);
	zstring.type = IS_STRING;
	zstring.value.str.val = string;
	zstring.value.str.len = string_len;
	
	return zval_in_array(&zstring, array, strict);
}


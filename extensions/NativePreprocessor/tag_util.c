#include <ctype.h>
#include <stdbool.h>
#include "php.h"
#define const
#include "tag_util.h"

const zvalue_value internalTagZvalues[] = {
	{ .str = { NULL, 0 } },
	{ .str = { "includeonly", 11 } },
	{ .str = { "onlyinclude", 11 } },
	{ .str = { "noinclude", 9 } }
};

/**
 * This functions is given an array of strings and returns the length of 
 * the longest one. If there are other kind of items, it returns -1
 */
int array_max_strlen( const HashTable* array ) {
	zval **entry;			/* pointer to array entry */
	HashPosition pos;		/* hash iterator */
	int max_length = 0;
	
	zend_hash_internal_pointer_reset_ex(array, &pos);
	while (zend_hash_get_current_data_ex(array, (void **)&entry, &pos) == SUCCESS) {
		if (Z_TYPE_PP(entry) != IS_STRING) {
			return -1;
		}
		if (Z_STRLEN_PP(entry) > max_length) {
			max_length = Z_STRLEN_PP(entry);
		}
		zend_hash_move_forward_ex(array, &pos);
	}
	return max_length;
}

/**
 * Returns if a given character matches a "\s>".
 * Remember that for PERL compatibility, \s doesn't
 * include the Vertical Tab (0x11)
 */
static inline bool isRegexSpaceOrAngle(int character) {
	switch ( character ) {
		case '\t':
		case '\n':
		case '\f':
		case '\r':
		case ' ':
		case '>':
			return true;
	}
	return false;
}

static inline int min( int a, int b ) {
	if ( a < b ) {
		return a;
	}
	return b;
}

/**
 * Returns the length of the first tag case-insensitive present in the 
 * lowercase array or internal, and followed by a space character, '/>' or '>'.
 * The matched tag is stored in lowercase in the lowername parameter, 
 * which is allocated by the caller.
 * It also calculates and returns the internalTag parameter
 */
int identifyTag(const char* __restrict string, int string_len, const HashTable* __restrict array, enum internalTags *__restrict internalTag, char* __restrict lowername) {
	zval **entryp, *entry;
	HashPosition pos;
	*internalTag = None;
	int i = 0;
	
	zend_hash_internal_pointer_reset_ex(array, &pos);
	while ( 1 ) {
		if ( *internalTag == None ) {
			if ( zend_hash_get_current_data_ex(array, (void **)&entryp, &pos) == FAILURE ) {
				(*internalTag)++;
				if ( string[0] == '/' ) {
					string++;
					string_len--;

					if ( i ) {
						memmove( lowername, lowername + 1, i - 1 );
						i--;
					}
				}
				continue;
			}
			assert( Z_TYPE_PP(entryp) == IS_STRING ); /* Already checked in array_max_strlen */
			entry = *entryp;
		} else if ( *internalTag == EndInternalTags ) {
			return -1;
		} else {
			entry = (zval*)&internalTagZvalues[*internalTag];
		}

		if (Z_STRLEN_P(entry) < string_len) {
			if ( isRegexSpaceOrAngle( string[Z_STRLEN_P(entry)] ) 
				|| ( string[Z_STRLEN_P(entry)] == '/' && Z_STRLEN_P(entry) + 2 <= string_len && string[Z_STRLEN_P(entry)+1] == '>') )
			{
				/* Verify the already lowercased name */
				if ( !memcmp( lowername, Z_STRVAL_P(entry), min( i, Z_STRLEN_P(entry) ) ) ) {
					for ( ; ; ) {
						lowername[i] = tolower( string[i] ); /* This is locale dependant, just as strtolower() and the original code */
						if ( lowername[i] != Z_STRVAL_P(entry)[i] ) {
							i++;
							break;
						}
						
						i++;
						
						if ( i == Z_STRLEN_P(entry) ) {
							lowername[i] = '\0';
							return i;
						}
					}
				}
			}
		}
		if ( *internalTag == None ) {
			zend_hash_move_forward_ex(array, &pos);
		} else {
			(*internalTag)++;
		}
	}
	
	return -1;
}

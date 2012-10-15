/**
 * A quickie PHP plug-in to munge UTF-8 strings to Normalization Form C
 * using the IBM ICU library without pulling in a huge bunch of stuff.
 *
 * (c) 2004 Brion Vibber <brion@pobox.com>
 * GPL blah blah
 */

#include "stdlib.h"
#include "unicode/normlzr.h"

#ifdef DEBUG
#include "stdio.h"
#endif

/**
 * Caller must free the returned string...
 */
char *utf8_normalize(const char *utf8_string, int mode) {
	UnicodeString source( utf8_string, "UTF-8" );
	if( source.isBogus() ) {
#ifdef DEBUG
		printf( "utf8_normalize given bogus string.\n" );
#endif
	} else {
		UnicodeString dest;
		UErrorCode status = U_ZERO_ERROR;
		Normalizer::normalize(source, (UNormalizationMode)mode, 0, dest, status);
		if( U_SUCCESS( status ) ) {
			int length = dest.length();
			int utf8_length = dest.extract( 0, length, NULL, "UTF-8" );
			char *utf8_out = (char *)malloc( utf8_length + 1 );
			dest.extract( 0, length, utf8_out, "UTF-8" );
			return utf8_out;
		} else {
#ifdef DEBUG
			printf( "utf8_normalize failed: %s (%d)\n", u_errorName( status ), (int)status );
#endif
		}
	}
	
	return NULL;
}

%module wikidiff

// Need to free the string to prevent memory leak
%typemap(out) char * %{
	if(!$1) {
	  ZVAL_NULL(return_value);
	} else {
	  ZVAL_STRING(return_value,$1, 1);
	  free($1);
	}
%}

%inline {
 	const char *wikidiff_do_diff(const char *text1, const char *text2, int num_lines_context);
}

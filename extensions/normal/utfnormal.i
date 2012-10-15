%module utfnormal

%typemap(out) char * %{
	if(!$1) {
	  ZVAL_NULL(return_value);
	} else {
	  ZVAL_STRING(return_value,$1, 1);
	  free($1);
	}
%}

%inline {
	char *utf8_normalize(const char *utf8_string, int mode);
}

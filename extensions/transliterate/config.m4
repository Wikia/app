dnl $Id$
dnl config.m4 for extension transliterate

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

PHP_ARG_WITH(transliterate, for ICU transliteration support,
[  --with-transliterate             Include ICU transliteration support])

if test "$PHP_TRANSLITERATE" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-transliterate -> check with-path
  SEARCH_PATH="/usr/local /usr"
  SEARCH_FOR="/include/unicode/translit.h" 
  if test -r $PHP_TRANSLITERATE/$SEARCH_FOR; then # path given as parameter
    ICU_DIR=$PHP_TRANSLITERATE
  else # search default path list
    AC_MSG_CHECKING([for ICU files in default path])
    for i in $SEARCH_PATH ; do
      if test -r $i/$SEARCH_FOR; then
        ICU_DIR=$i
        AC_MSG_RESULT(found in $i)
      fi
    done
  fi
  
  if test -z "$ICU_DIR"; then
    AC_MSG_RESULT([not found])
    AC_MSG_ERROR([Please reinstall the ICU header files])
  fi

  dnl # --with-transliterate -> add include path
  PHP_ADD_INCLUDE($ICU_DIR/include)

  dnl # --with-transliterate -> check for lib and symbol presence
  LIBNAME=icuuc
  LIBSYMBOL=_ZN7icu_3_613UnicodeStringC1EPKciS2_

  PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  [
    PHP_ADD_LIBRARY_WITH_PATH(icuuc, $ICU_DIR/lib, TRANSLITERATE_SHARED_LIBADD)
    PHP_ADD_LIBRARY_WITH_PATH(icui18n, $ICU_DIR/lib, TRANSLITERATE_SHARED_LIBADD)
    PHP_ADD_LIBRARY_WITH_PATH(icudata, $ICU_DIR/lib, TRANSLITERATE_SHARED_LIBADD)
    AC_DEFINE(HAVE_TRANSLITERATELIB,1,[ ])
  ],[
    AC_MSG_ERROR([wrong ICU lib version or lib not found])
  ],[
    -L$ICU_DIR/lib -ldl
  ])
  
  PHP_SUBST(TRANSLITERATE_SHARED_LIBADD)

  PHP_NEW_EXTENSION(transliterate, transliterate.cpp, $ext_shared)
fi

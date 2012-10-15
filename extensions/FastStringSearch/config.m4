dnl $Id$
dnl config.m4 for extension fss

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(fss, for fss support,
dnl Make sure that the comment is aligned:
dnl [  --with-fss             Include fss support])

dnl Otherwise use enable:

PHP_ARG_ENABLE(fss, whether to enable fss support,
dnl Make sure that the comment is aligned:
[  --enable-fss           Enable fss support])

if test "$PHP_FSS" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-fss -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/fss.h"  # you most likely want to change this
  dnl if test -r $PHP_FSS/$SEARCH_FOR; then # path given as parameter
  dnl   FSS_DIR=$PHP_FSS
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for fss files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       FSS_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$FSS_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the fss distribution])
  dnl fi

  dnl # --with-fss -> add include path
  dnl PHP_ADD_INCLUDE($FSS_DIR/include)

  dnl # --with-fss -> check for lib and symbol presence
  dnl LIBNAME=fss # you may want to change this
  dnl LIBSYMBOL=fss # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $FSS_DIR/lib, FSS_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_FSSLIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong fss lib version or lib not found])
  dnl ],[
  dnl   -L$FSS_DIR/lib -lm -ldl
  dnl ])
  dnl
  dnl PHP_SUBST(FSS_SHARED_LIBADD)

  PHP_NEW_EXTENSION(fss, fss.c kwset.c obstack.c, $ext_shared)
fi

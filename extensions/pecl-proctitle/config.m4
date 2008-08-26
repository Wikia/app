dnl $Id: config.m4 584 2008-07-29 13:59:13Z emil $
dnl config.m4 for extension proctitle

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(proctitle, for proctitle support,
dnl Make sure that the comment is aligned:
dnl [  --with-proctitle             Include proctitle support])

dnl Otherwise use enable:

PHP_ARG_ENABLE(proctitle, whether to enable proctitle support,
Make sure that the comment is aligned:
[  --enable-proctitle           Enable proctitle support])

if test "$PHP_PROCTITLE" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-proctitle -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/proctitle.h"  # you most likely want to change this
  dnl if test -r $PHP_PROCTITLE/; then # path given as parameter
  dnl   PROCTITLE_DIR=$PHP_PROCTITLE
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for proctitle files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       PROCTITLE_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$PROCTITLE_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the proctitle distribution])
  dnl fi

  dnl # --with-proctitle -> add include path
  dnl PHP_ADD_INCLUDE($PROCTITLE_DIR/include)

  dnl # --with-proctitle -> check for lib and symbol presence
  dnl LIBNAME=proctitle # you may want to change this
  dnl LIBSYMBOL=proctitle # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $PROCTITLE_DIR/lib, PROCTITLE_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_PROCTITLELIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong proctitle lib version or lib not found])
  dnl ],[
  dnl   -L$PROCTITLE_DIR/lib -lm -ldl
  dnl ])
  dnl
  dnl PHP_SUBST(PROCTITLE_SHARED_LIBADD)

  PHP_NEW_EXTENSION(proctitle, proctitle.c, $ext_shared)
fi

dnl $Id: config.m4 584 2008-07-29 13:59:13Z emil $
dnl config.m4 for extension MediaWiki

dnl Comments in this file start with the string 'dnl'.
dnl Remove where necessary. This file will not work
dnl without editing.

dnl If your extension references something external, use with:

dnl PHP_ARG_WITH(MediaWiki, for MediaWiki support,
dnl Make sure that the comment is aligned:
dnl [  --with-MediaWiki             Include MediaWiki support])

dnl Otherwise use enable:

dnl PHP_ARG_ENABLE(MediaWiki, whether to enable MediaWiki support,
dnl Make sure that the comment is aligned:
dnl [  --enable-MediaWiki           Enable MediaWiki support])

if test "$PHP_MEDIAWIKI" != "no"; then
  dnl Write more examples of tests here...

  dnl # --with-MediaWiki -> check with-path
  dnl SEARCH_PATH="/usr/local /usr"     # you might want to change this
  dnl SEARCH_FOR="/include/MediaWiki.h"  # you most likely want to change this
  dnl if test -r $PHP_MEDIAWIKI/; then # path given as parameter
  dnl   MEDIAWIKI_DIR=$PHP_MEDIAWIKI
  dnl else # search default path list
  dnl   AC_MSG_CHECKING([for MediaWiki files in default path])
  dnl   for i in $SEARCH_PATH ; do
  dnl     if test -r $i/$SEARCH_FOR; then
  dnl       MEDIAWIKI_DIR=$i
  dnl       AC_MSG_RESULT(found in $i)
  dnl     fi
  dnl   done
  dnl fi
  dnl
  dnl if test -z "$MEDIAWIKI_DIR"; then
  dnl   AC_MSG_RESULT([not found])
  dnl   AC_MSG_ERROR([Please reinstall the MediaWiki distribution])
  dnl fi

  dnl # --with-MediaWiki -> add include path
  dnl PHP_ADD_INCLUDE($MEDIAWIKI_DIR/include)

  dnl # --with-MediaWiki -> check for lib and symbol presence
  dnl LIBNAME=MediaWiki # you may want to change this
  dnl LIBSYMBOL=MediaWiki # you most likely want to change this 

  dnl PHP_CHECK_LIBRARY($LIBNAME,$LIBSYMBOL,
  dnl [
  dnl   PHP_ADD_LIBRARY_WITH_PATH($LIBNAME, $MEDIAWIKI_DIR/lib, MEDIAWIKI_SHARED_LIBADD)
  dnl   AC_DEFINE(HAVE_MEDIAWIKILIB,1,[ ])
  dnl ],[
  dnl   AC_MSG_ERROR([wrong MediaWiki lib version or lib not found])
  dnl ],[
  dnl   -L$MEDIAWIKI_DIR/lib -lm -ldl
  dnl ])
  dnl
  dnl PHP_SUBST(MEDIAWIKI_SHARED_LIBADD)

  PHP_NEW_EXTENSION(MediaWiki, MediaWiki.c, $ext_shared)
fi

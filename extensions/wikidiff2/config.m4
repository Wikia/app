dnl $Id$

dnl if test -z "$CXX"; then
dnl 	AC_MSG_ERROR([PHP is bugged. Set \$CXX to a C++ compiler.])
dnl fi

PHP_ARG_ENABLE(wikidiff2, whether to enable wikidiff2 support,
[  --enable-wikidiff2           Enable wikidiff2 support])

if test "$PHP_WIKIDIFF2" != "no"; then
  PHP_REQUIRE_CXX
  AC_LANG_CPLUSPLUS
  PHP_ADD_LIBRARY(stdc++,,WIKIDIFF2_SHARED_LIBADD)

  if test -z "$PKG_CONFIG"
  then
	AC_PATH_PROG(PKG_CONFIG, pkg-config, no)
  fi
  if test "$PKG_CONFIG" = "no"
  then
	AC_MSG_ERROR([required utility 'pkg-config' not found])
  fi

  if ! $PKG_CONFIG --exists libthai
  then
	AC_MSG_ERROR(['libthai' not known to pkg-config])
  fi

  PHP_EVAL_INCLINE(`$PKG_CONFIG --cflags-only-I libthai`)
  PHP_EVAL_LIBLINE(`$PKG_CONFIG --libs libthai`, WIKIDIFF2_SHARED_LIBADD)

  export OLD_CPPFLAGS="$CPPFLAGS"
  export CPPFLAGS="$CPPFLAGS $INCLUDES -DHAVE_WIKIDIFF2"
  AC_CHECK_HEADER([thai/thailib.h], [], AC_MSG_ERROR('thai/thailib.h' header not found'))
  export CPPFLAGS="$OLD_CPPFLAGS"

  PHP_SUBST(WIKIDIFF2_SHARED_LIBADD)
  AC_DEFINE(HAVE_WIKIDIFF2, 1, [ ])
  export CXXFLAGS="-Wno-write-strings $CXXFLAGS"
  PHP_NEW_EXTENSION(wikidiff2, php_wikidiff2.cpp wikidiff2.cpp, $ext_shared)
fi

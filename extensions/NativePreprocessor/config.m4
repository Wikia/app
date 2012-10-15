dnl Change that 'yes' to 'no' to not build it by default

PHP_ARG_ENABLE(mediawiki-preprocessor, mediawiki preprocessor support,
[  --enable-mediawiki-preprocessor     Include MediaWiki preprocessor extension], no, yes)

if test "$PHP_MEDIAWIKIPREPROCESSOR" != "no"; then
  dnl Enable the extension
  PHP_NEW_EXTENSION(mediawiki_preprocessor, mediawiki_preprocessor.c tag_util.c preprocesstoobj.c expand.c, $ext_shared)
  PHP_SUBST(MEDIAWIKI_PREPROCESSOR_SHARED_LIBADD)
fi


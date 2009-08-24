
PHP_ARG_ENABLE(load_txt_def, whether to enable load_txt_def support,
	[  --enable-load_txt_def           Enable load_txt_def support])

if test "$PHP_LOAD_TXT_DEF" != "no"; then
  PHP_NEW_EXTENSION(load_txt_def, load_txt_def.c, $ext_shared)
fi

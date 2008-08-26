<?

if ( php_sapi_name() != 'cli' ) {
	echo "This script must be run from the command line\n";
	exit( 1 );
}

if(!extension_loaded('MediaWiki')) {
	dl('MediaWiki.' . PHP_SHLIB_SUFFIX);
}
$module = 'MediaWiki';
$functions = get_extension_funcs($module);
echo "Functions available in the test extension:<br />\n";
foreach($functions as $func) {
    echo $func."<br />\n";
}
echo "<br />\n";
$function = 'confirm_MediaWiki_compiled';
#if (extension_loaded($module)) {
#	$str = $function($module);
#} else {
#	$str = "Module $module is not compiled into PHP";
#}
echo "$str\n";
echo "\n\n".utf8_decode(mediawiki_ucfirst(utf8_encode("überfall")))."\n";
echo        utf8_decode(mediawiki_ucfirst(utf8_encode("anton")))."\n";
echo        utf8_decode(mediawiki_ucfirst(utf8_encode("JeLuF")))."\n";


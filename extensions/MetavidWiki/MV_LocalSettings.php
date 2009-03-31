<?
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );
// include the default settings:
include_once( dirname( __FILE__ )  . '/includes/MV_DefaultSettings.php' );

/*
 * your settings overrides here: 
 * for more info on all overitable settings see base settings in MV_DefaultSettings.php 
 * eventually we should have some documentation somewhere ;) 
 */
$mvExternalImages = true;
$mvExternalImgServerPath = 'http://metavid.org/wiki/index.php';

$mvgJSDebug=true;
// for sunlight network annalysis we include google analytics 
/*$mvExtraHeader = '<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4281471-1");
pageTracker._trackPageview();
</script>';*/
?>
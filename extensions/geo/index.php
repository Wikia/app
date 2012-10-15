<?php
require_once ( "geosettings.php" ) ;

if ( isset ( $wikibasedir ) )
	{
	define( "MEDIAWIKI", true );

	require_once( "{$wikibasedir}/includes/Defines.php" );
	require_once( "{$wikibasedir}/LocalSettings.php" );
	require_once( "{$wikibasedir}/includes/Setup.php" );

	if ( isset ( $gisbasedir ) )
		{
		require_once ( "{$gisbasedir}/maparea.php" ) ;
		}
	}
	
require_once( "geo.php");

$p = new geo_params ;


# Default parameters (for command line testing only)
$params = "
show:andorra
draw:andorra
style:andorra=fill:brown
" ;

/*
$params = "
languages:de,en
show:germany
fit:germany
draw:germany[state],germany[city],germany[isle]
style:germany[state],germany[isle]=fill:#CCCCCC; stroke:black; stroke-width:10
style:germany.hamburg=fill:red
label:germany[city]=font-size:medium;fill-opacity:1.0;clickable:yes
label:germany[state]=font-size:medium;fill-opacity:0.7
" ;
*/

#$params = "" ;
if ( isset ( $_GET['params'] ) )
	{
	$params = urldecode ( $_GET['params'] ) ;
	}

if ( isset ( $articlePrefix ) )
	$p->article_prefix = $articlePrefix ;

$p->settings ( $params ) ;

$svg = $p->getSVG () ;
print $svg ;
exit ( 0 ) ; # just make SVG




$batik_cmd = "java -jar /home/magnus/batik-1.5.1/batik-rasterizer.jar $1 -d $2" ;
$output_filename = "/srv/www/htdocs/test.png" ;

# Storing in temp file
$tmpfname = tempnam ( "" , "TR2" ) . ".svg" ;
$outfname = tempnam ( "" , "TR2" ) . ".png" ;
#$outfname = $output_filename ;
$handle = fopen($tmpfname, "w");
fwrite($handle, $svg);
fclose($handle);

$cmd = str_replace ( "$1" , $tmpfname , $batik_cmd ) ;
$cmd = str_replace ( "$2" , $outfname , $cmd ) ;

$out = system ( $cmd ) ;

unlink($tmpfname);

print "<html><head></head><body>" ;
print $cmd . " : " . $out ;
print "<img src=\"/{$outfname}\"/>" ;
print "</body></html>\n" ;



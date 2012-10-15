<?php

# This file is only needed temporarily and will be deleted
require_once ( "geo_functions.php" ) ;
include_once ( "geosettings.php" ) ;

function read_from_url ( $id )
	{
	global $wikibaseurl;
	global $articlePrefix;
	$filename = $wikibaseurl."?title=".$articlePrefix.$id."&action=raw" ;
	$handle = fopen($filename, "r");
	$contents = '';
	while (!feof($handle))
		$contents .= fread($handle, 8192);
	fclose($handle);
	return $contents ;
	}

function add ( $v , $dv )
	{
	if ( substr ( $v , 0 , 1 ) == "-" ) { $mv = -1 ; $v = substr ( $v , 1 ) ; }
	else $mv = 1 ;
	if ( substr ( $dv , 0 , 1 ) == "-" ) { $mdv = -1 ; $dv = substr ( $dv , 1 ) ; }
	else $mdv = 1 ;

	$av = array ( substr ( $v , 0 , 2 ) , substr ( $v , 2 , 2 ) , substr ( $v , 4 , 2 ) ) ;
	$adv = array ( substr ( $dv , 0 , 2 ) , substr ( $dv , 2 , 2 ) , substr ( $dv , 4 , 2 ) ) ;
	$av[2] += $adv[2] * $mdv ;
	if ( $av[2] >= 60 ) { $av[2] -= 60 ; $av[1]++ ; }
	if ( $av[2] < 0 ) { $av[2] += 60 ; $av[1]-- ; }
	$av[1] += $adv[1] * $mdv ;
	if ( $av[1] >= 60 ) { $av[1] -= 60 ; $av[0]++ ; }
	if ( $av[1] < 0 ) { $av[1] += 60 ; $av[0]-- ; }
	$av[0] += $adv[0] * $mdv ;
	$ret = "" ;
	$ret .= $av[0] < 10 ? "0" . $av[0] : $av[0] ;
	$ret .= $av[1] < 10 ? "0" . $av[1] : $av[1] ;
	$ret .= $av[2] < 10 ? "0" . $av[2] : $av[2] ;
	return $ret ;
	}

function transform ( $a , $tx , $ty )
	{
	$x = trim ( $a[0] ) ;
	$y = trim ( $a[1] ) ;
	$x = add ( $x , $tx ) ;
	$y = add ( $y , $ty ) ;
	return $x . "," . $y ;
	}

function runit ( $title , $tx , $ty )
	{
	$text = explode ( "\n" , read_from_url ( $title ) ) ;
	$ret = array() ;
	foreach ( $text AS $t )
		{
		if ( trim ( strtolower ( substr ( $t , 0 , 6 ) ) ) == ";data:" )
			{
			$r = array () ;
			$t = explode ( ";" , substr ( $t , 6 ) ) ;
			foreach ( $t AS $s )
				{
				$set = array() ;
				$s = explode ( " " , trim ( $s ) ) ;
				foreach ( $s AS $part )
					{
					$part = explode ( "," , $part ) ;
					$set[] = transform ( $part , $tx , $ty ) ;
					}
				$r[] = implode ( " " , $set ) ;
				}
			$ret[] = ";data:" . implode ( ";" , $r ) ;
			}
		else $ret[] = $t ;
		}
	return $ret ;
	}

print "This function is obsolete!" ;
/*
$tx = $ty = "000000" ;
if ( isset ( $_POST['tx'] ) ) $tx = $_POST['tx'] ;
if ( isset ( $_POST['ty'] ) ) $ty = $_POST['ty'] ;
if ( isset ( $_POST['title'] ) ) $title = $_POST['title'] ;
if ( $title != "" )
	{
	$ret = runit ( $title , $tx , $ty ) ;
	#$ret = runit ( $title , "004500" , "-001200" ) ;
	}
else $ret = array () ;
print "<html><head></head><body>" ;
print "<p>This form is to mass-move coordinates. Enter the page title and the coordinate difference.</p>" ;
print "<form method=post>Title : <input type=text name='title' value='{$title}'/><br />" ;
print "X : <input type=text name='tx' value='{$tx}'/><br />";
print "Y : <input type=text name='ty' value='{$ty}'/><br />";
print "<input type=submit name='OK'/>" ;
print "</body></html>" ;

if ( count ( $ret ) > 0 )
	print "<pre>" . implode ( "\n" , $ret ) . "</pre>" ;
*/



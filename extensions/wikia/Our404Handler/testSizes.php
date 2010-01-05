<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * just for comparing php rounding with perl rounding
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

$srcWidth  = 1000;
$srcHeight = 562;
$dstWidth  = 250;
$dstHeight = File::scaleHeight( $srcWidth, $srcHeight, $dstWidth );

Wikia::log( "check", "size", "$srcWidth x $srcHeight => $dstWidth x $dstHeight" );

$srcWidth  = 741;
$srcHeight = 514;
$dstWidth  = 250;
$dstHeight = File::scaleHeight( $srcWidth, $srcHeight, $dstWidth );

Wikia::log( "check", "size", "$srcWidth x $srcHeight => $dstWidth x $dstHeight" );

$srcWidth  = 590.00000;
$srcHeight = 294.00400;
$dstWidth  = 250;
$dstHeight = File::scaleHeight( $srcWidth, $srcHeight, $dstWidth );

Wikia::log( "check", "size", "$srcWidth x $srcHeight => $dstWidth x $dstHeight" );

$srcWidth  = 426.29242;
$srcHeight = 1001.3936;
$dstWidth  = 150;
$dstHeight = File::scaleHeight( $srcWidth, $srcHeight, $dstWidth );

Wikia::log( "check", "size", "$srcWidth x $srcHeight => $dstWidth x $dstHeight" );


$srcWidth  = 799.90000;
$srcHeight = 73.99200;
$dstWidth  = 240;
$dstHeight = File::scaleHeight( $srcWidth, $srcHeight, $dstWidth );

Wikia::log( "check", "size", "$srcWidth x $srcHeight => $dstWidth x $dstHeight" );

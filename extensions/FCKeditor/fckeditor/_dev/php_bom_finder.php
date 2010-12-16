<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2010 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>FCKeditor - PHP BOM Finder</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		body { font-family: arial, verdana, sans-serif }
		p { margin-left: 20px }
	</style>
</head>
<body>
	<h1>
		PHP Files with UTF-8 BOM</h1>
	<p>

<?php

$total = CheckDir( '../' ) ;

echo '<br /> Number of files with UTF-8 BOM: ', $total ;

function CheckDir( $sourceDir )
{
	$counter = 0 ;

	$sourceDir = FixDirSlash( $sourceDir ) ;

	// Copy files and directories.
	$sourceDirHandler = opendir( $sourceDir ) ;

	while ( $file = readdir( $sourceDirHandler ) )
	{
		// Skip ".", ".." and hidden fields (Unix).
		if ( substr( $file, 0, 1 ) == '.' )
			continue ;

		$sourcefilePath = $sourceDir . $file ;

		if ( is_dir( $sourcefilePath ) )
		{
			$counter += CheckDir( $sourcefilePath ) ;
		}

		if ( !is_file( $sourcefilePath ) || @GetFileExtension( $sourcefilePath ) != 'php' || !CheckUtf8Bom( $sourcefilePath ) )
			continue ;

		echo $sourcefilePath, '<br />' ;

		$counter++ ;
	}

	return $counter ;
}

function FixDirSlash( $dirPath )
{
	$dirPath = str_replace( '\\', '/', $dirPath ) ;

	if ( substr( $dirPath, -1, 1 ) != '/' )
		$dirPath .= '/' ;

	return $dirPath ;
}

function GetFileExtension( $filePath )
{
	$info = pathinfo( $filePath ) ;
	return $info['extension'] ;
}

function CheckUtf8Bom( $filePath )
{
	$data = file_get_contents( $filePath ) ;

	return ( substr( $data, 0, 3 ) == "\xEF\xBB\xBF" ) ;
}
?>

</p>
</body>
</html>

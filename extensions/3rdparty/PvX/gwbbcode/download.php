<?php
/***************************************************************************
 *                               download.php
 *                            -------------------
 *   begin                : Tuesday, Nov 7, 2006
 *   copyright            : (C) 2006-2007 Pierre 'pikiou' Scelles
 *   email                : liu.pi.vipi@gmail.com
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   All images, skill names and descriptions are (C) ArenaNet.
 ***************************************************************************/

$content = $_GET['content'];
$content = str_replace('_', '/', $content);
$content = str_replace('+', '+', $content);
if (strlen($content) > 300) {
   die('Hack attempt');
}
$src = isset($_GET['filename']) ? $_GET['filename'] : '';
$dst = "gwshack_$src.txt";

//Begin writing headers
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");

//Use the switch-generated Content-Type
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$dst\"");

//Force the download
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".strlen($content));
echo $content;
?>
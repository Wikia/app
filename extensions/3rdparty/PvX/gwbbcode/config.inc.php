<?php
/***************************************************************************
 *                              config.inc.php
 *                            -------------------
 *   begin                : Tuesday, Apr 21, 2005
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

require_once (GWBBCODE_ROOT.'/constants.inc.php');

//Change "false" to "true" in the following line if you want gwBBCode
//to store/access skills from your SQL database. Then run install.php again.
define('GWBBCODE_SQL', false);
define('GWBBCODE_VERSION', $gwbbcode_version . (GWBBCODE_SQL ? '-sql' : ''));

//Chose between Kurzick and Luxon in order to adapt allegiance skills
define('GWBBCODE_ALLEGIANCE', 'Kurzick');

//use gwBBCode?
define('USE_GWBBCODE', true);

//List templates not to hook gwbbcode into
$not_to_hook = Array();
?>

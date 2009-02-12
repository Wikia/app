<?php
/***************************************************************************
 *                                common.php
 *                            -------------------
 *   begin                : Thursday, 9 Aug, 2005
 *   copyright            : (C) 2007 Pierre 'pikiou' Scelles
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
if (@file_exists(CONFIG_PATH)) {
   require_once (CONFIG_PATH);
}
else {
   require_once (DEFAULT_CONFIG_PATH);
}
?>

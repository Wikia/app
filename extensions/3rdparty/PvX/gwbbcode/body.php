<?php
/***************************************************************************
 *                                 body.php
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

if (!defined('GWBBCODE_ROOT'))
	define('GWBBCODE_ROOT', defined('NUKE_FILE') ? 'modules/Forums/gwbbcode' : './gwbbcode');
require_once(GWBBCODE_ROOT.'/common.inc.php');

return USE_GWBBCODE ? file_get_contents(GWBBCODE_ROOT.'/overall_body.tpl') : '';
?>
<?php
/* Wikiforum.php -- a basic forum extension for Mediawiki
 * Copyright 2004-2005 Guillaume Blanchard <aoineko@free.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Guillaume Blanchard <aoineko@free.fr>
 * @addtogroup Extensions
 */

/**
 * This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
 */
if(defined('MEDIAWIKI')) 
{
	$wf_language = array
	(
		'Thread'          => 'Тема',
		'ThreadTalk'      => 'Тема_беседа',
		'ThreadName'      => 'Наименование',
		'ThreadView'      => 'Преглед',
		'ThreadUser'      => 'Последен потребител',
		'ThreadComment'   => 'Последен коментар',
		'ThreadTime'      => 'Час и дата',
		'ThreadEdit'      => 'Редактиране',
		'ThreadCreate'    => 'Започване на нова нишка',
		'ThreadAll'       => 'Прегледайте всички теми',
		'ThreadLastest'   => 'Последни $1 теми',
		'ThreadIncluded'  => '$1 включени теми',
		'ThreadNew'       => 'Нова тема',
		'ThreadTitle'     => 'Заглавие',
		'ThreadOpen'      => 'Създаване на темата',
		'ThreadExist'     => 'Вече съществува тема с това име, моля изберете друго име!',
		'ThreadInvalid'   => 'Това заглавие е невалидно, моля изберете друго!',
		'ThreadSHAlt'     => 'Показване/Скриване', 
		'ThreadSHTip'     => 'Натиснете тук, за да покажете или скриете съдържанието на нишката', 
	);
} // end if(defined('MEDIAWIKI'))



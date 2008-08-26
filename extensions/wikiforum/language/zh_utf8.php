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
		'Thread'          => 'Thread',
		'ThreadTalk'      => 'Thread_talk',
		'ThreadName'      => '主题',
		'ThreadView'      => '浏览',
		'ThreadUser'      => '最后发表的用户',
		'ThreadComment'   => '最新的评论',
		'ThreadTime'      => '时间',
		'ThreadEdit'      => '编辑',
		'ThreadCreate'    => '创建一个新主题',
		'ThreadAll'       => '浏览全部主题',
		'ThreadLastest'   => '$1个最新的主题',
		'ThreadIncluded'  => '共有$1个主题',
		'ThreadNew'       => '新主题',
		'ThreadTitle'     => '主题标题',
		'ThreadOpen'      => '公开的主题',
		'ThreadExist'     => '这个主题已经存在，请选择一个其它的名称！',
		'ThreadInvalid'   => '这个主题的标题有错误，请选择一个其它的名字！',
		'ThreadSHAlt'     => '显示/隐藏', // thread show/hide bouton 'alt' text
		'ThreadSHTip'     => '点击这里显示或隐藏该主题的内容', // thread show/hide bouton 'title' text (tip)
		);
	} // end if(defined('MEDIAWIKI'))



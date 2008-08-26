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
      'ThreadTalk'      => 'Threadノート',
      'ThreadName'      => 'スレッド',
      'ThreadView'      => '閲覧',
      'ThreadUser'      => ' 最終投稿者',
      'ThreadComment'   => '最新のコメント',
      'ThreadTime'      => '投稿時刻',
      'ThreadEdit'      => '投稿',
      'ThreadCreate'    => '新しいスレッドを作成',
      'ThreadAll'       => 'すべてのスレッド',
      'ThreadLastest'   => 'その他稼動中のスレッド$1',
      'ThreadIncluded'  => '最近投稿が行なわれたスレッド$1',
      'ThreadNew'       => 'New thread',
      'ThreadTitle'     => 'タイトル',
      'ThreadOpen'      => 'スレッドを作成',
      'ThreadExist'     => 'そのスレッド名は既に存在します。別の名前を選んでください。',
      'ThreadInvalid'   => 'スレッド名に誤りがあります。別の名前を選んでください。',
   );
} // end if(defined('MEDIAWIKI'))



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
      'ThreadName'      => 'Name',
      'ThreadView'      => 'View',
      'ThreadUser'      => 'Last user',
      'ThreadComment'   => 'Last comment',
      'ThreadTime'      => 'Time',
      'ThreadEdit'      => 'Edit',
      'ThreadCreate'    => 'Create a new thread',
      'ThreadAll'       => 'View all threads',
      'ThreadLastest'   => '$1 lastest threads',
      'ThreadIncluded'  => '$1 included threads',
      'ThreadNew'       => 'New thread',
      'ThreadTitle'     => 'Thread title',
      'ThreadOpen'      => 'Open thread',
      'ThreadExist'     => 'This thread already exist, please chose an other name!',
      'ThreadInvalid'   => 'This thread title is invalid, please chose an other name!',
      'ThreadSHAlt'     => 'Show/Hide', // thread show/hide bouton 'alt' text
      'ThreadSHTip'     => 'Click here to show or hide this thread content', // thread show/hide bouton 'title' text (tip)
   );
} // end if(defined('MEDIAWIKI'))



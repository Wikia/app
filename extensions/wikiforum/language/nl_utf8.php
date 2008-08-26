<?php
/* Wikiforum.php -- a basic forum extension for Mediawiki
 * Copyright 2004-2005 Guillaume Blanchard <aoineko@free.fr>
 * Copyright 2006-2007 Siebrand Mazeland <s.mazeland@xs4all.nl> Dutch translation
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
 * @author Guillaume Blanchard <aoineko@free.fr> Siebrand Mazeland <s.mazeland@xs4all.nl> Dutch translation
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
      'ThreadTalk'      => 'Overleg Thread',
      'ThreadName'      => 'Naam',
      'ThreadView'      => 'Bekijk',
      'ThreadUser'      => 'Laatste gebruiker',
      'ThreadComment'   => 'Laatste opmerking',
      'ThreadTime'      => 'Tijd',
      'ThreadEdit'      => 'Bewerk',
      'ThreadCreate'    => 'Maak een nieuwe thread',
      'ThreadAll'       => 'Bekijk alle threads',
      'ThreadLastest'   => '$1 nieuwste threads',
      'ThreadIncluded'  => '$1 threads opgenomen',
      'ThreadNew'       => 'Nieuwe thread',
      'ThreadTitle'     => 'Threadnaam',
      'ThreadOpen'      => 'Start thread',
      'ThreadExist'     => 'Deze thread bestaat al, kies alstublieft een andere naam!',
      'ThreadInvalid'   => 'Deze threadnaam is ongeldig, kies alstublieft een andere naam!',
   );
} // end if(defined('MEDIAWIKI'))




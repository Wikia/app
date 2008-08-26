<?php
/* Wikiforum.php -- a basic forum extension for Mediawiki
 * Copyright 2006 helix84 <helix84@centrum.sk>
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
 * @package MediaWiki
 * @subpackage Extensions
 */

/**
 * This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
 */
if(defined('MEDIAWIKI')) 
{
   $wf_language = array
   (
      'Thread'          => 'Vlákno',
      'ThreadTalk'      => 'Diskusia_k:vláknu',
      'ThreadName'      => 'Názov',
      'ThreadView'      => 'Zobraziť',
      'ThreadUser'      => 'Posledný užívateľ',
      'ThreadComment'   => 'Posledný komentár',
      'ThreadTime'      => 'Čas',
      'ThreadEdit'      => 'Úprava',
      'ThreadCreate'    => 'Vytvoriť nové vlákno',
      'ThreadAll'       => 'Zobraziť všetky vlákna',
      'ThreadLastest'   => '$1 posledných vlákien',
      'ThreadIncluded'  => '$1 vložených vlákien',
      'ThreadNew'       => 'Nové vlákno',
      'ThreadTitle'     => 'Názov vlákna',
      'ThreadOpen'      => 'Otvoriť vlákno',
      'ThreadExist'     => 'Toto vlákno už existuje, zvoľte prosím iný názov!',
      'ThreadInvalid'   => 'Toto nie je platný názov pre vlákno, zvoľte prosím iný názov!',
   );
} // end if(defined('MEDIAWIKI'))



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
      'Thread'          => 'Sujet',
      'ThreadTalk'      => 'Discussion_Sujet',
      'ThreadName'      => 'Sujet',
      'ThreadView'      => 'Lu',
      'ThreadUser'      => 'Modifi� par',
      'ThreadComment'   => 'Commentaire',
      'ThreadTime'      => 'Date',
      'ThreadEdit'      => 'Modifier',
      'ThreadCreate'    => 'Cr�er un nouveau sujet',
      'ThreadAll'       => 'Voir tout les sujets',
      'ThreadLastest'   => '$1 derniers sujets',
      'ThreadIncluded'  => '$1 sujets inclus',
      'ThreadNew'       => 'Nouveau sujet',
      'ThreadTitle'     => 'Titre',
      'ThreadOpen'      => 'Cr�er le sujet',
      'ThreadExist'     => 'Ce sujet existe d�j�, veuillez choisir un autre titre !',
      'ThreadInvalid'   => 'Le titre de ce sujet est invalide, veuillez choisir un autre titre !',
      'ThreadSHAlt'     => 'voir', // thread show/hide bouton 'alt' text
      'ThreadSHTip'     => 'Cliquer ici pour montrer ou cacher le contenu de ce sujet', // thread show/hide bouton 'title' text (tip)
   );
} // end if(defined('MEDIAWIKI'))



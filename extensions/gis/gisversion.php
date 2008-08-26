<?php
/** \file
 *
 *  Show version information
 *
 *  \todo Make hook for Special:Version instead
 *
 *  ----------------------------------------------------------------------
 *
 *  Copyright 2005, Egil Kvaleberg <egil@kvaleberg.no>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

include_once ( "gissettings.php" ) ;

/**
 *  Base class
 */
class gis_version {
	function gis_version( ) {
	}

	function show() {
		global $wgOut, $wgUser, $wgContLang;
		global $wgVersion, $wgGisVersion;

		$wgOut->setPagetitle( "Version" );
		$wgOut->addHTML( '
 <p><b><a href="http://www.mediawiki.org/">MediaWiki</a></b> 
 <a href="http://meta.wikimedia.org/wiki/Gis">GIS extension</a>,
 copyright (C) 2005 by Egil Kvaleberg.</p>
 
 <p>The GIS extension is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.</p>
 
 <p>The GIS extension is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.</p>
 
 <p>You should have received <a href="../COPYING">a copy of the GNU General Public License</a>
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 or <a href="http://www.gnu.org/copyleft/gpl.html">read it online</a></p>
');
		$out .= ":GIS extension: $wgGisVersion\n";
		$out .= ":MediaWiki: $wgVersion\n";

		$wgOut->addWikiText( $out );
	}
}



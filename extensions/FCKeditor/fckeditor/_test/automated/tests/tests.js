/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2010 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 */

if ( window == window.top )
	window.location = '../_jsunit/testRunner.html?testpage=' + document.location.pathname ;

if ( typeof FCKScriptLoader != 'undefined' )
	FCKScriptLoader.FCKeditorPath = document.location.pathname.substring(0,document.location.pathname.lastIndexOf('_test')) ;

function GetTestInnerHtml( element )
{
	// IE and others change the innerHTML to an internal format (without
	// quotes, uppercased and linebreaks). Transform it in something usable for
	// the tests assertions.
	return element.innerHTML.replace( /"/g, '' ).toLowerCase().replace( />\s*(\n|\r)+\s*</g, '><' ).replace( /\s*(\n|\r)+\s*/g, ' ' ).replace( /(^\s+)|(\s+$)/g, '' ) ;
}

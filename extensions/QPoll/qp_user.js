/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 * 
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 * 
 * @version 0.6.4
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

(function() {
	function uniqueRadioButtonColumn() {
// uq1c2p2
		var propId, inp;
		var id = new String( this.getAttribute('id') );
// IE split is really buggy, so we have to search for p letter instead, was:
//  var params = id.split('/(uq\d{1,}?c\d{1,}?p)(\d{1,}?)/g');
//  if ( params !== null && params[1] !== null && params[2] != null ) {
//    var currPropId = parseInt( params[2] );
//    var basepart = params[1];
		var p = id.indexOf( 'p' ) + 1;
		var currPropId = parseInt( id.substring( p ) );
		var basepart = id.substring( 0, p );
		if ( p != 0)  {
			for ( propId = 0; ( inp = document.getElementById( basepart + propId ) ) !== null; propId++ ) {
				if ( propId != currPropId) {
					inp.checked = false;
				}
			}
		}
	}

	function clickMixedRow() {
// mx1p2c2
		var catId, inp;
		var id = new String( this.getAttribute('id') );
		var c = id.indexOf( 'c' ) + 1;
		var currCatId = parseInt( id.substring( c ) );
		var basepart = id.substring( 0, c );
		if ( c != 0)  {
			for ( catId = 0; ( inp = document.getElementById( basepart + catId ) ) !== null; catId++ ) {
				if ( catId != currCatId ) {
          if ( this.type == 'radio' ) {
            if (inp.type == 'text' ) {
              inp.value = '';
            } else {
              inp.checked = false;
            }
          } else {
            if (inp.type == 'radio' ) {
              inp.checked = false;
            }
          }
				}
			}
		}
	}
	/**
	 * Prepare the Poll for "javascriptable" browsers
	 */
	function preparePoll() {
		var bodyContentDiv = document.getElementById('bodyContent').getElementsByTagName('div');
		var inputFuncId;
		for(var i=0; i<bodyContentDiv.length; ++i) {
			if(bodyContentDiv[i].className == 'qpoll') {
				var input = bodyContentDiv[i].getElementsByTagName('input');
				for(var j=0; j<input.length; ++j) {
					if ( input[j].id ) {
						inputFuncId = new String( input[j].id ).slice( 0, 2 );
						switch ( inputFuncId ) {
							case "uq":
								if ( input[j].type == "radio" ) {
									// unset the column of radiobuttons in case of unique proposal
									addEvent( input[j], "click", uniqueRadioButtonColumn );
								}
							break;
							case "mx":
								// unset the row of checkboxes in case of "mixed" question type
 								addEvent( input[j], "click", clickMixedRow );
							break;
						}
					} else {
						// Add the possibility of unchecking radio buttons
						addEvent(input[j],"dblclick", function() { this.checked = false; });
					}
				}
			}
		}
	}

	function addEvent( obj, type, fn ) {
		if (obj.addEventListener) {
			obj.addEventListener( type, fn, false );
		}
		else if (obj.attachEvent) {
			obj["e"+type+fn] = fn;
			obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
			obj.attachEvent( "on"+type, obj[type+fn] );
		}
		else {
			obj["on"+type] = obj["e"+type+fn];
		}
	}

	if (document.getElementById && document.createTextNode) {
		addEvent(window,"load",preparePoll);
	}
})();
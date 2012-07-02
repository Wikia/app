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
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

(function() {

	var self = {

		radioIsClicked : false,

		// coordinate of current poll's question input id
		catCoord : {
			'toq' : '', // question prefix which contains "T"ype_of_poll + poll_"O"rder_id + "Q"uestion_id,
			'p' : '-1', // "P"roposal_id,
			'c' : '-1'  // "C"ategory_id
		},

		/**
		 * Parses coordinate of poll's input stored in id and
		 * stores it into self.catCoord;
		 * @param  id  id attribute of input / textarea / select element
		 * @return  true, when value of id has valid coordinate, false otherwise.
		 */
		setCatCoord : function( id ) {
			// IE split is really buggy, so we have to search for p and c letters instead
			var p, c;
			if ( ( p = id.indexOf( 'p' ) + 1 ) == -1 ||
					( c = id.indexOf( 'c' ) + 1 ) == -1 ) {
				return false;
			}
			self.catCoord.toq = id.slice( 0, p - 1 );
			if ( p > c ||
					( p = parseInt( id.substring( p ) ) ) === NaN ||
					( c = parseInt( id.substring( c ) ) ) === NaN ) {
				self.catCoord.toq = '';
				return false;
			}
			self.catCoord.p = p;
			self.catCoord.c = c;
			return true;
		},

		/**
		 * Get input node of current poll's question (stored in self.catCoord.toq) with specific coordinates.
		 * @param  params  object  'prop' (optional) property id; 'cat' (optional) category id.
		 */
		getCatByCoord : function( params ) {
			var p = ( typeof params['prop'] !== 'undefined' ) ? params['prop'] : self.catCoord.p;
			var c = ( typeof params['cat'] !== 'undefined' ) ? params['cat'] : self.catCoord.c;
			return document.getElementById( self.catCoord.toq + 'p' + p + 'c' + c );
		},

		/**
		 * Logic of switching on / off radiobuttons for all inputs in one proposal line.
		 * @param  catElem  DOM node of poll/question/proposal/category; input or select only.
		 */
		applyRadio : function( catElem ) {
			if ( self.radioIsClicked ) {
				// deselect all inputs
				if ( catElem.nodeName != 'INPUT' || catElem.type == 'text' ) {
					// text controls
					catElem.value = '';
					if ( catElem.nodeName == 'TEXTAREA' ) {
						catElem.innerHTML = '';
					}
				} else {
					// switching controls
					catElem.checked = false;
				}
			} else {
				// deselect only radio
				if ( catElem.nodeName == 'INPUT' && catElem.type == 'radio' ) {
					catElem.checked = false;
				}
			}
		},

		/**
		 * Makes this radio button to be unique in their column
		 * (it is already unique in their row)
		 * Used for question type="unique()"
		 */
		uniqueRadioButtonColumn : function() {
			// example of input id: 'uq3q1p4c2'
			// where uq3 is mOrderId of poll on the page
			// q1 first question of that poll
			// p4 proposal index 4 of that question
			// c2 category index 2 of that proposal
			var propId, inp;
			if ( !self.setCatCoord( this.getAttribute( 'id' ) ) ) {
				return;
			}
			for ( propId = 0; ( inp = self.getCatByCoord( { 'prop' : propId } ) ) !== null; propId++ ) {
				if ( propId != self.catCoord.p ) {
					inp.checked = false;
				}
			}
		},

		processMixedRow : function( currElem ) {
			var catId, inp;
			self.radioIsClicked = ( currElem.nodeName == 'INPUT' && currElem.type == 'radio' );
			if ( !self.setCatCoord( currElem.getAttribute( 'id' ) ) ) {
				return false;
			}
			for ( catId = 0; ( inp = self.getCatByCoord( { 'cat' : catId } ) ) !== null; catId++ ) {
				if ( catId != self.catCoord.c ) {
					self.applyRadio( inp );
				}
			}
			return true;
		},

		/**
		 * Makes this input to switch radiobuttons in the same row
		 * Used for question type="mixed"
		 */
		clickMixedRow : function() {
			// example of input id: 'mx1q3p2c4'
			self.processMixedRow( this );
		},

		/**
		 * Used for question type="text"
		 */
		clickTextRow : function() {
			// example of input id: 'tx1q3p2c4'
			if ( !self.processMixedRow( this ) ) {
				return;
			}
			// clear pre_filled text attribute, when available
			if ( hasClass( this, 'cat_prefilled' ) ) {
				this.select();
				removeClass( this, 'cat_prefilled' );
			}
		},

		setTextRowHandler : function( parent, tagName ) {
			var tags = parent.getElementsByTagName( tagName );
			for ( j = 0; j < tags.length; j++ ) {
				if ( tags[j].id && tags[j].id.slice( 0, 2 ) == 'tx' ) {
					addEvent( tags[j], "click", self.clickTextRow );
				}
			}
		},

		/**
		 * Prepare the Poll for "javascriptable" browsers
		 */
		preparePoll : function() {
			var bodyContentDiv = document.getElementById( 'bodyContent' ).getElementsByTagName( 'div' );
			var i, j;
			for ( i=0; i<bodyContentDiv.length; i++ ) {
				if ( !hasClass( bodyContentDiv[i], 'qpoll' ) ) {
					continue;
				}
				var input = bodyContentDiv[i].getElementsByTagName( 'input' );
				for ( j=0; j<input.length; j++ ) {
					if ( input[j].id ) {
						// only unique or mixed questions currently have id
						switch ( input[j].id.slice( 0, 2 ) ) {
						case 'uq' :
							if ( input[j].type == "radio" ) {
								// unset the column of radiobuttons in case of unique proposal
								addEvent( input[j], "click", self.uniqueRadioButtonColumn );
							}
							break;
						case 'mx' :
							// unset the row of checkboxes in case of question type="mixed"
							addEvent( input[j], "click", self.clickMixedRow );
							break;
						case 'tx' :
							// handler for text question proposal rows
							addEvent( input[j], "click", self.clickTextRow );
							break;
						}
					} else {
						// non-unique, non-mixed tabular questions
						if ( input[j].getAttribute( 'type' ) == 'radio' ) {
							// Add the possibility of unchecking radio buttons
							addEvent( input[j], "dblclick", function() { this.checked = false; } );
						}
					}
				}
				self.setTextRowHandler( bodyContentDiv[i], 'select' );
				self.setTextRowHandler( bodyContentDiv[i], 'textarea' );
			}
		}
	};

	/**
	 * The following functions are defined to not to be dependant on jQuery (MW 1.15).
	 * They should not cause any trouble, running in the closure.
	 * Class manipulation is taken from http://www.openjs.com/scripts/dom/class_manipulation.php
	 */
	function hasClass( ele, cls ) {
		return ele.className.match( new RegExp('(\\s|^)'+cls+'(\\s|$)') );
	}

	function addClass( ele, cls ) {
		if ( !this.hasClass(ele,cls)) {
			ele.className += " "+cls;
		}
	}

	function removeClass( ele, cls ) {
		if ( hasClass(ele,cls) ) {
			var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
			ele.className = ele.className.replace(reg,' ').replace(/\s+/g,' ').replace(/^\s|\s$/,'');
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

	if ( document.getElementById && document.createTextNode ) {
		addEvent( window, "load", self.preparePoll );
	}
})();

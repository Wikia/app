/**
 * Code to integrate the sfGrid JavaScript library into Semantic Forms.
 *
 * @author Yaron Koren
 */
/* global sfgGridParams, sfgGridValues */

( function ( $, mw ) {

	$( '.sfJSGrid' ).each( function() {
		var sfgGridParams = mw.config.get( 'sfgGridParams' ),
			sfgGridValues = mw.config.get( 'sfgGridValues' );
		var $gridDiv = $( this );
		var templateName = $gridDiv.attr( 'data-template-name' );
		var gridHeight = $gridDiv.attr( 'height' );
		if ( gridHeight === undefined ) { gridHeight = '400px'; }
		// The slice() is necessary to do a clone, so that
		// sfgGridParams does not get modified.
		var templateParams = sfgGridParams[templateName].slice(0);
		templateParams.push( { type: 'control' } );

		$gridDiv.jsGrid({
			width: "100%",
			height: gridHeight,

			editing: true,
			inserting: true,
			confirmDeleting: false,

			data: sfgGridValues[templateName],
			fields: templateParams,

			onEditRowCreated: function( args ) {
				args.editRow.keypress( function( e ) {
					// Make the "Enter" key approve an update.
					if ( e.which === 13 ) {
						$gridDiv.jsGrid("updateItem");
						e.preventDefault();
					}
				});
				args.editRow.find( 'textarea' ).keypress( function( e ) {
					if ( e.which === 10 ) {
						$(this).addNewlineAtCursor();
					}
				});
			},

			onInsertRowCreated: function( args ) {
				args.insertRow.keypress( function( e ) {
					// Make the "Enter" key approve an insert.
					if ( e.which === 13 ) {
						$gridDiv.jsGrid("insertItem");
						$gridDiv.jsGrid("clearInsert");
						e.preventDefault();
					}
				});
				args.insertRow.find( 'textarea' ).keypress( function( e ) {
					if ( e.which === 10 ) {
						$(this).addNewlineAtCursor();
					}
				});

			}
		});

		var $gridData = $gridDiv.find( ".jsgrid-grid-body tbody" );
 
		// Copied from http://js-grid.com/demos/rows-reordering.html
		$gridData.sortable({
			update: function( e, ui ) {
				// array of indexes
				var clientIndexRegExp = /\s+client-(\d+)\s+/;
				var indexes = $.map( $gridData.sortable( "toArray", { attribute: "class" } ), function(classes) {
					return clientIndexRegExp.exec(classes)[1];
				});
 
				// arrays of items
				var items = $.map( $gridData.find("tr"), function(row) {
					return $(row).data("JSGridItem");
				});
			}
		});

	});

	$( "#sfForm" ).submit(function( event ) {
		// Add a hidden field for each value in the grid.
		$( "div.jsgrid-grid-body" ).each( function() {
			var $grid = $( this );
			var $gridDiv = $grid.parents( '.jsgrid' );
			var templateName = $gridDiv.attr( 'data-template-name' );

			var rowNum = 1;
			$grid.find( "tr" ).each( function() {
				var $row = $( this );
				if ( $row.hasClass( 'jsgrid-edit-row' ) || $row.hasClass( 'jsgrid-nodata-row' ) ) {
					// Continue.
					return;
				}
				var cellNum = 1;
				$row.find( "td" ).each( function() {
					var paramName = sfgGridParams[templateName][cellNum - 1].name;
					var value = $( this ).html();
					// If this isn't a checkbox, the value
					// will be neither true not false - it
					// will be undefined.
					var isChecked = $( this ).find( ':checkbox' ).prop( 'checked' );
					if ( isChecked === true ) {
						value = mw.msg( 'htmlform-yes' );
					} else if ( isChecked === false ) {
						value = mw.msg( 'htmlform-no' );
					}
					var inputName = templateName + '[' + rowNum + '][' + paramName + ']';
					$('<input>').attr( 'type', 'hidden' ).attr( 'name', inputName ).attr( 'value', value ).appendTo( '#sfForm' );
					cellNum++;
					if ( cellNum > sfgGridParams[templateName].length ) {
						// Break.
						return false;
					}
				});
				rowNum++;
			});
		});
	});

	$.fn.addNewlineAtCursor = function() {
		var curPos = $(this).getCursorPosition();
		var curVal = $(this).val();
		$(this).val( curVal.substring( 0, curPos ) + "\n" + curVal.substring( curPos ) );
		$(this).setCursorPosition( curPos + 1 );
	};

	// Copied from http://stackoverflow.com/a/1909997
	$.fn.getCursorPosition = function() {
		var el = $(this).get(0);
		var pos = 0;
		if ( 'selectionStart' in el ) {
			pos = el.selectionStart;
		} else if ( 'selection' in document ) {
			el.focus();
			var Sel = document.selection.createRange();
			var SelLength = document.selection.createRange().text.length;
			Sel.moveStart( 'character', -el.value.length );
			pos = Sel.text.length - SelLength;
		}
		return pos;
	};

	// Copied from http://stackoverflow.com/a/3651232
	$.fn.setCursorPosition = function( pos ) {
		this.each( function( index, elem ) {
			if ( elem.setSelectionRange ) {
				elem.setSelectionRange( pos, pos );
			} else if ( elem.createTextRange ) {
				var range = elem.createTextRange();
				range.collapse( true );
				range.moveEnd( 'character', pos );
				range.moveStart( 'character', pos );
				range.select();
			}
		});
		return this;
	};

}( jQuery, mediaWiki ) );

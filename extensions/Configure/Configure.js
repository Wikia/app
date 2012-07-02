/**
 * Main function
 * create JavaScript buttons to allow to modify the form to have more
 * flexibility
 */

// Tabs and TOC
// ------------

$( '#configure' )
	.addClass( 'jsprefs' )
	.wrap( '<table><tbody><tr><td class="config-col-form"></td></tr></tbody></table>' )
	.parent()
	.before( '<td class="config-col-toc"><ul class="configtoc" id="configtoc"></ul></td>' );

$( '#configure' )
	.children( 'fieldset' )
	.addClass( 'configsection' )
	.hide()
	.children( 'legend' )
	.each( function( i ) {
		$( this ).parent().attr( 'id', 'config-section-' + i );
		if ( i === 0 ) {
			$( this ).parent().show();
		}

		var item = $( '<li></li>' )
			.addClass( i === 0 ? 'selected' : null )
			.append(
				$( '<a></a>' )
					.text( $( this ).text() )
					.attr( 'href', '#config-section-' + i )
					.mousedown( function( e ) {
						$( this ).parent().parent().find( 'li' ).removeClass( 'selected' );
						$( this ).parent().addClass( 'selected' );
						e.preventDefault();
						return false;
					} )
					.click( function( e ) {
						$( '#configure > fieldset' ).hide();
						$( '#config-section-' + i ).show();
						$( '#config-section-' + i + ' h2' ).show();
						$( '#config-section-' + i + ' .configure-table' ).show();
						e.preventDefault();
						return false;
					} )
			);

		$( this ).parent().find( 'table.configure-table' ).each( function( j ) {
			$( this ).attr( 'id', 'config-table-' + i + '-' + j );
		} );

		var heads = $( this ).parent().find( 'h2' )
		if ( heads.length > 1 ) {
			var sub = $( '<ul></ul>' ).hide();

			heads.each( function( j ) {
				$( this ).attr( 'id', 'config-head-' + i + '-' + j );
				sub.append(
					$( '<li></li>' )
						.addClass( i === 0 ? 'selected' : null )
						.append(
							$( '<a></a>' )
								.text( $( this ).text() )
								.attr( 'href', '#config-table-' + i + '-' + j )
								.mousedown( function( e ) {
									$( this ).parent().parent().find( 'li' ).removeClass( 'selected' );
									$( this ).parent().addClass( 'selected' );
									$( this ).parent().parent().parent().parent().find( 'li' ).removeClass( 'selected' );
									$( this ).parent().parent().parent().addClass( 'selected' );
									e.preventDefault();
									return false;
								} )
								.click( function( e ) {
									$( '#configure > fieldset' ).hide();
									$( '#config-section-' + i ).show();
									$( '#config-section-' + i + ' h2' ).hide();
									$( '#config-section-' + i + ' .configure-table' ).hide();
									$( '#config-head-' + i + '-' + j ).show();
									$( '#config-table-' + i + '-' + j ).show();
									e.preventDefault();
									return false;
								} )
						) );
				} );

			item.append( sub );
			item.prepend( $( '<a></a>' )
				.text( '[+]' )
				.attr( 'href', 'javascript:' )
				.mousedown( function( e ) {
					e.preventDefault();
					return false;
				} )
				.click( function( e ) {
					if ( sub.css( 'display' ) == 'none' ) {
						sub.show();
						$(this).text( '[-]' );
					} else {
						sub.hide();
						$(this).text( '[+]' );
					}
				} ) );
		}

		$( '#configtoc' ).append( item );
	} );

$( '.config-col-toc' ).append(
	$( '<a></a>' )
		.css( 'align', 'right' )
		.attr( 'href', 'javascript:;' )
		.append( $( '<img />' )
			.attr( 'src', stylepath + '/common/images/Arr_l.png' )
		)
		.mousedown( function( e ) {
			e.preventDefault();
			return false;
		} )
		.click( function( e ) {
			if ( $( '#configtoc' ).css( 'display' ) == 'none' ) {
				$( '#configtoc' ).show();
				$( this ).children( 'img' ).remove();
				$( this ).append( $( '<img />' )
					.attr( 'src', stylepath + '/common/images/Arr_l.png' )
				);
			} else {
				$( '#configtoc' ).hide();
				$( this ).children( 'img' ).remove();
				$( this ).append( $( '<img />' )
					.attr( 'src', stylepath + '/common/images/Arr_r.png' )
				);
			}
			e.preventDefault();
			return false;
		}
		)
);

// Associative tables
// ------------------

/**
 * Fix an associative table
 */
window.fixAssocTable = function( table ){
	var startName = 'wp' + table.attr( 'id' );
	table.chidren( 'tr' ).each( function( i ) {
		if ( i == 0 ) {
			return;
		}
		var inputs = $( this ).chidren( 'input' );
		inputs[0].attr( 'name', startName + '-key-' + (i - 1) );
		inputs[1].attr( 'name', startName + '-val-' + (i - 1) );
	} );
}

$( '#configure table.assoc' ).each( function() {
	var table = $( this );

	if ( table.hasClass( 'disabled' ) ) {
		return;
	}
	table.children( 'tr' ).each( function( i ) {
		if ( i == 0 ) {
			$( this ).append( $( '<th></th>' ).text( mediaWiki.msg( 'configure-js-remove-row' ) ) );
		} else {
			$( this ).append(
				$( '<td></td>' )
					.addClass( 'button' )
					.append(
						$( '<input></input>' )
							.attr( 'type', 'button' )
							.attr( 'value', mediaWiki.msg( 'configure-js-remove-row' ) )
							.click( function() {
								$( this ).parent().parent().remove();
								fixAssocTable( table );
							} )
					)
			);
		}
	} );
	table.parent().append(
		$( '<input></input>' )
			.attr( 'type', 'button' )
			.attr( 'value', mediaWiki.msg( 'configure-js-add' ) )
			.addClass( 'button' )
			.click( function() {
				table.append(
					$( '<tr></tr>' )
						.append(
							$( '<td></td>' )
								.append(
									$( '<input></input>' )
										.attr( 'type', 'text' )
								)
						)
						.append(
							$( '<td></td>' )
								.append(
									$( '<input></input>' )
										.attr( 'type', 'text' )
								)
						)
						.append(
							$( '<td></td>' )
								.append(
									$( '<input></input>' )
										.attr( 'type', 'button' )
										.attr( 'value', mediaWiki.msg( 'configure-js-remove-row' ) )
										.click( function() {
											$( this ).parent().parent().remove();
											fixAssocTable( table );
										} )
								)
						)
				);
				fixAssocTable( table );
			} )
	);
} );

// Images
// ------

$( '.image-selector' ).blur( function() {
	var data = {
		'action': 'query',
		'titles': $( this ).attr( 'value' ),
		'prop': 'imageinfo',
		'iiprop': 'url',
		'format': 'json'
	};
	var input = $( this );
	$.getJSON(
		mw.config.get( 'wgScriptPath' ) + '/api' + mw.config.get( 'wgScriptExtension' ),
		data,
		function( obj ) {
			var found = false;
			for ( var i in obj.query.pages ) {
				if( obj.query.pages[i].imageinfo && obj.query.pages[i].imageinfo[0].url ) {
					$( '#image-url-preview-' + input.attr( 'id' ).substr( 18 ) ).attr( 'src', obj.query.pages[i].imageinfo[0].url );
					found = true;
				}
			}
			if ( !found ) {
				$( '#image-url-preview-' + input.attr( 'id' ).substr( 18 ) ).attr( 'src', input.attr( 'value' ) );
			}
		}
	);
} );

// $wgGroupPermissions and $wgAutopromote stuff, only if ajax is enabled
// ---------------------------------------------------------------------

$( '.ajax-group' ).each( function() {
	var table = $( this );
	// Button "remove this row"
	table.children( 'tr' ).each( function( i ) {
		if ( i == 0 ) {
			$( this ).append( $( '<th></th>' ).text( mediaWiki.msg( 'configure-js-remove' ) ) );
		} else {
			$( this ).append(
				$( '<td></td>' )
					.addClass( 'button' )
					.append(
						$( '<input></input>' )
							.attr( 'type', 'button' )
							.attr( 'value', mediaWiki.msg( 'configure-js-remove-row' ) )
							.click( function() {
								$( this ).parent().parent().remove();
							} )
					)
			);
		}
	} );
	// Button "add a new row"
	table.parent().append(
		$( '<input></input>' )
			.addClass( 'button-add' )
			.attr( 'type', 'button' )
			.attr( 'value', mediaWiki.msg( 'configure-js-add' ) )
			.click( function() {
				var groupname = prompt( mediaWiki.msg( 'configure-js-prompt-group' ) );
				if( groupname == null )
					return;

				var data = {
					'action': 'configure',
					'prop': 'ajax',
					'format': 'json',
					'ajaxgroup': groupname,
					'ajaxsetting': table.attr( 'id' )
				};

				$.getJSON(
					mw.config.get( 'wgScriptPath' ) + '/api' + mw.config.get( 'wgScriptExtension' ),
					data,
					function( obj ) {
						if ( obj.configure.ajax ) {
							var resp = obj.configure.ajax;
							error = false;
							table.append(
								$( '<tr></tr>' )
									.addClass( 'configure-maintable-row' )
									.attr( 'id', 'wp' + table.attr( 'id' ) + groupname )
									.append( $( '<td></td>' ).text( groupname ) )
									.append( $( '<td></td>' ).html( resp ) )
									.append(
										$( '<td></td>' )
											.append(
												$( '<input></input>' )
													.attr( 'type', 'button' )
													.attr( 'value', mediaWiki.msg( 'configure-js-remove-row' ) )
													.click( function() {
														$( this ).parent().parent().remove();
													} )
											)
									)
							);
						} else {
							alert( mediaWiki.msg( 'configure-js-group-exists' ) );
						}
					}
				);
			} )
	);
} );

$( '#configure-form' ).submit( function(){
	$( '.ajax-group' ).each( function() {
		var table = $( this );
		var cont = '';
		table.children( 'tr.configure-maintable-row' ).each( function() {
			if( cont != '' ) cont += "\n";
			cont += $( this ).attr( 'id' );
		} );
		table.parent().append(
			$( '<input></input>' )
				.attr( 'type', 'hidden' )
				.attr( 'name', 'wp' + table.attr( 'id' ) + '-vals' )
				.attr( 'value', cont )
		);
	} );
} );

// Big lists
// ---------

// Summarise the setting contained in 'div' to the summary field 'summary'.
window.summariseSetting = function( div ) {

	if ( div.hasClass( 'assoc' ) ) {
		// If it's too big to display as an associative array, it's too big to display as a summary.
		return '';
	} else if ( div.hasClass( 'ns-bool' ) || div.hasClass( 'ns-simple' ) || div.hasClass( 'group-bool-element' ) || div.hasClass( 'group-array-element' ) ) {
		var matches = [];
		div.find( 'label' ).each( function() {
			if ( $( '#' + $( this ).attr( 'for' ) ).attr( 'checked' ) ) {
				matches.push( $( this ).text() );
			}
		} );
		return matches.join( ', ' );
	} else if ( div.hasClass( 'ns-array' ) || div.hasClass( 'ns-text' ) || div.hasClass( 'configure-rate-limits-action' ) ) {
		// Basic strategy: find all labels, and list the values of their corresponding inputs, if those inputs have a value

		var body = $( '<tbody></tbody>' )
			.append( $( '<tr></tr>' )
				.append( $( '<th></th>' ).text( div.find( 'th:first' ).text() ) )
				.append( $( '<th></th>' ).text( div.find( 'th:last' ).text() ) )
			);

		var rows = false;

		if ( div.hasClass( 'configure-rate-limits-action' ) ) {
			div.find( 'tr' ).each( function( i ) {
				if ( i == 0 ) {
					return;
				}
				var typeDesc = $( this ).find( 'td:first' ).text();
				var periodField = $( '#' + $( this ).attr( 'id' ) + '-period' );
				var countField = $( '#' + $( this ).attr( 'id' ) + '-count' );

				if ( periodField.attr( 'value' ) > 0 ) {
					rows = true;

					body.append( $( '<tr></tr>' )
						.append( $( '<td></td>' ).text( typeDesc ) )
						.append( $( '<td></td>' ).text( mediaWiki.msg(
							'configure-throttle-summary', countField.attr( 'value' ), periodField.attr( 'value' ) ) ) )
					);
				}
			} );
		} else {
			div.find( 'label' ).each( function( i ) {
				if ( i == 0 ) {
					return;
				}
				var arrayfield = $( '#' + $( this ).attr( 'for' ) );
				if ( arrayfield.attr( 'value' ) > 0 ) {
					rows = true;

					body.append( $( '<tr></tr>' )
						.append( $( '<td></td>' ).text( $( this ).text() ) )
						.append( $( '<td></td>' ).text( arrayfield.attr( 'value' ) ) )
					);
				}
			} );
		}

		if ( !rows ) {
			body.append( $( '<tr></tr>' )
				.append( $( '<th></th>' )
					.attr( 'colspan', 2 )
					.text( mediaWiki.msg( 'configure-js-summary-none' ) )
				)
			);
		}

		return $( '<table></table>' ).addClass( 'assoc' ).append( body ).html();
	} else if ( div.hasClass( 'promotion-conds-element' ) || div.hasClass( 'configure-rate-limits-action' ) ) {
		return '';
	} else {
		return 'Useless type';
	}
}

$( '.configure-biglist' ).each( function( l ) {
	var list = $( this );
	var summary = $( '<div></div>' )
		.addClass( 'configure-biglist-summary' )
		.html( summariseSetting( list ) );
	var header = $( '<span></span>' ).text( mediaWiki.msg( 'configure-js-biglist-hidden' ) );
	var toogle = $( '<a></a>' )
		.addClass( 'configure-biglist-toggle-link' )
		.attr( 'href', 'javascript:' )
		.text( mediaWiki.msg( 'configure-js-biglist-show' ) )
		.click( function() {
			if ( list.css( 'display' ) == 'none' ) {
				toogle.text( mediaWiki.msg( 'configure-js-biglist-hide' ) );
				header.text( mediaWiki.msg( 'configure-js-biglist-shown' ) );
				list.show();
				summary.hide();
			} else {
				toogle.text( mediaWiki.msg( 'configure-js-biglist-show' ) );
				header.text( mediaWiki.msg( 'configure-js-biglist-hidden' ) );
				list.hide();
				summary.html( summariseSetting( list ) ).show();
			}
		} );

	list.hide();
	list.before(
		$( '<div></div>' )
		.addClass( 'configure-biglist-placeholder' )
		.append( toogle )
		.append( header )
	);
	list.before(
		summary
	);
} );

// Search
// ------

window.allSettings = undefined;

( function() {
	allSettings = [];

	// For each section...
	var rootElement = document.getElementById( 'configure' );
	var fieldsets = rootElement.getElementsByTagName( 'fieldset' );
	for( var fid=0; fid<fieldsets.length; ++fid ) {
		// For each subsection...
		var fieldset = fieldsets[fid];
		var subsections = getElementsByClassName( fieldset, 'table', 'configure-table' );
		for( var sid=0; sid<subsections.length; ++sid ) {
			var subsection;
			if (subsections[sid].getElementsByTagName( 'tbody' ).length > 0) {
				subsection = subsections[sid].getElementsByTagName( 'tbody' )[0];
			} else {
				subsection = subsections[sid];
			}
			var heading = document.getElementById( subsection.parentNode.id.replace( 'config-table', 'config-head' ) );

			// For each setting...
			for( var i=0; i<subsection.childNodes.length;++i ) {
				var row = subsection.childNodes[i];
				if( typeof row.ELEMENT_NODE == "undefined" ){
					var wantedType = 1; // ELEMENT_NODE
				} else {
					var wantedType = row.ELEMENT_NODE;
				}
				if ( row.nodeType != wantedType || ( row.tagName != 'tr' && row.tagName != 'TR' ) ) {
					continue;
				}

				var desc_cell = getElementsByClassName( row, 'td', 'configure-left-column' )[0];
				if( typeof desc_cell == "undefined" ){
					continue;
				}

				var description;

				if ( desc_cell.getElementsByTagName( 'p' ).length ) { // Ward off comments like "This setting has been customised"
					description = desc_cell.getElementsByTagName( 'p' )[0].innerText;
				} else {
					description = desc_cell.innerText;
				}

				allSettings.push( { 'description': description.toLowerCase(), 'fid':fid+1, 'sid':sid, 'displayDescription': description } );
			}
		}
	}
} )();

$( '#configure-search-form' ).show();
$( '#configure-search-input' ).keyup( function() {
	var query = $( '#configure-search-input' ).attr( 'value' ).toLowerCase();

	$( '#configure-search-results' ).children( 'li' ).remove();

	if ( query == '' ) {
		return;
	}

	var isMatch = function( element ) { return element.description.indexOf( query ) !== -1; }
	for( var i=0; i<allSettings.length; ++i ) {
		var data = allSettings[i];
		if ( isMatch( data ) ) {
			$( '#configure-search-results' ).append(
				$( '<li></li>' ).append(
					$( '<a></a>' )
						.attr( 'href', '#config-head-'+data.fid+'-'+data.sid )
						.text( data.displayDescription )
						.click( function() {
							$( '#configure > fieldset' ).hide();
							$( '#config-section-' + data.fid ).show();
							$( '#config-section-' + data.fid + ' h2' ).show();
							$( '#config-section-' + data.fid + ' .configure-table' ).show();
						} )
				)
			);
		}
	}
} );

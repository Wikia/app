/* Prototype code to show collapsing left nav options */
/* First draft and will be changing greatly */

$j(document).ready( function() {
	if( !wgVectorEnabledModules.collapsiblenav ) {
		return true;
	}
	$j( '#mw-panel' ).addClass( 'collapsible-nav' );
	// Always show the first portal
	$j( '#mw-panel > div.portal:first' )
		.addClass( 'expanded' )
		.find( 'div.body' )
		.show();
	// Remember which portals to hide and show
	$j( '#mw-panel > div.portal:not(:first)' )
		.each( function() {
			if ( $j.cookie( 'vector-nav-' + $j(this).attr( 'id' ) ) == 'true' ) {
				$j(this)
					.addClass( 'expanded' )
					.find( 'div.body' )
					.show();
			} else {
				$j(this).addClass( 'collapsed' );
			}
		} );
	// Toggle the selected menu's class and expand or collapse the menu
	$j( '#mw-panel > div.portal > h5' ).click( function() {
		$j.cookie( 'vector-nav-' + $j(this).parent().attr( 'id' ), $j(this).parent().is( '.collapsed' ) );
		$j(this)
			.parent()
			.toggleClass( 'expanded' )
			.toggleClass( 'collapsed' )
			.find( 'div.body' )
			.slideToggle( 'fast' );
		return false;
	} );
} );
$j(document).ready( function() {
	// Check if CollapsibleTabs is enabled
	if ( !wgVectorEnabledModules.collapsibletabs ) {
		return true;
	}
	
	var rtl = $j( 'body' ).is( '.rtl' );
	
	// Overloading the moveToCollapsed function to animate the transition 
	$j.collapsibleTabs.moveToCollapsed = function( ele ) {
		var $moving = $j( ele );
		$j( $moving.data( 'collapsibleTabsSettings' ).expandedContainer )
			.data( 'collapsibleTabsSettings' ).shifting = true;
		var data = $moving.data( 'collapsibleTabsSettings' );
		// Remove the element from where it's at and put it in the dropdown menu
		var target = $moving.data( 'collapsibleTabsSettings' ).collapsedContainer;
		$moving.css( "position", "relative" )
			.css( ( rtl ? 'left' : 'right' ), 0 )
			.animate( { width: '1px' }, "normal", function() {
				$j( this ).hide();
				// add the placeholder
				$j( '<span class="placeholder" style="display:none;"></span>' ).insertAfter( this );
				$j( this ).remove().prependTo( target ).data( 'collapsibleTabsSettings', data );
				$j( this ).attr( 'style', 'display:list-item;' );
				$j( $j( ele ).data( 'collapsibleTabsSettings' ).expandedContainer )
					.data( 'collapsibleTabsSettings' ).shifting = false;
				$j.collapsibleTabs.handleResize();
			} );
	};
	
	// Overloading the moveToExpanded function to animate the transition
	$j.collapsibleTabs.moveToExpanded = function( ele ) {
		var $moving = $j( ele );
		$j( $moving.data( 'collapsibleTabsSettings' ).expandedContainer )
			.data( 'collapsibleTabsSettings' ).shifting = true;
		var data = $moving.data( 'collapsibleTabsSettings' );
		// grab the next appearing placeholder so we can use it for replacing
		var $target = $j( $moving.data( 'collapsibleTabsSettings' ).expandedContainer )
			.find( 'span.placeholder:first' );
		var expandedWidth = $moving.data( 'collapsibleTabsSettings' ).expandedWidth;
		$moving.css( "position", "relative" ).css( ( rtl ? 'right' : 'left' ), 0 ).css( 'width', '1px' );
		$target.replaceWith( $moving.remove().css( 'width', '1px' ).data( 'collapsibleTabsSettings', data )
			.animate( { width: expandedWidth+"px" }, "normal", function() {
				$j( this ).attr( 'style', 'display:block;' );
				$j( $moving.data( 'collapsibleTabsSettings' ).expandedContainer )
					.data( 'collapsibleTabsSettings' ).shifting = false;
				$j.collapsibleTabs.handleResize();
			} ) );
	};
	
	// Bind callback functions to animate our drop down menu in and out
	// and then call the collapsibleTabs function on the menu 
	$j( '#p-views ul' ).bind( "beforeTabCollapse", function() {
		if( $j( '#p-cactions' ).css( 'display' ) == 'none' )
		$j( "#p-cactions" ).addClass( "filledPortlet" ).removeClass( "emptyPortlet" )
			.find( 'h5' ).css( 'width','1px' ).animate( { 'width':'26px' }, 390 );
	}).bind( "beforeTabExpand", function() {
		if( $j( '#p-cactions li' ).length == 1 )
		$j( "#p-cactions h5" ).animate( { 'width':'1px' }, 370, function() {
			$j( this ).attr( 'style', '' ).parent().addClass( "emptyPortlet" ).removeClass( "filledPortlet" );
		});
	}).collapsibleTabs( {
		expandCondition: function( eleWidth ) {
			if( rtl ){
				return ( $j( '#right-navigation' ).position().left + $j( '#right-navigation' ).width() + 1 )
					< ( $j( '#left-navigation' ).position().left - eleWidth );
			} else {
				return ( $j( '#left-navigation' ).position().left + $j( '#left-navigation' ).width() + 1 )
					< ( $j( '#right-navigation' ).position().left - eleWidth );
			}
		},
		collapseCondition: function() {
			if( rtl ) {
				return ( $j( '#right-navigation' ).position().left + $j( '#right-navigation' ).width() )
					> $j( '#left-navigation' ).position().left;
			} else {
				return ( $j( '#left-navigation' ).position().left + $j( '#left-navigation' ).width() )
					> $j( '#right-navigation' ).position().left;
			}
		}
	} );
} );
/* JavaScript for EditWarning extension */

$j(document).ready( function() {
	// Check if EditWarning is enabled and if we need it
	if ( !wgVectorEnabledModules.editwarning || $j( '#wpTextbox1' ).size() == 0 ) {
		return true;
	}
	// Get the original values of some form elements
	$j( '#wpTextbox1, #wpSummary' ).each( function() {
		$j(this).data( 'origtext', $j(this).val() );
	});
	// Attach our own handler for onbeforeunload which respects the current one
	fallbackWindowOnBeforeUnload = window.onbeforeunload;
	window.onbeforeunload = function() {
		var fallbackResult = undefined;
		// Check if someone already set on onbeforunload hook
		if ( fallbackWindowOnBeforeUnload ) {
			// Get the result of their onbeforeunload hook
			fallbackResult = fallbackWindowOnBeforeUnload();
		}
		// Check if their onbeforeunload hook returned something
		if ( fallbackResult !== undefined ) {
			// Exit here, returning their message
			return fallbackResult;
		}
		// Check if the current values of some form elements are the same as
		// the original values
		if(
			wgAction == 'submit' ||
			$j( '#wpTextbox1' ).data( 'origtext' ) != $j( '#wpTextbox1' ).val() ||
			$j( '#wpSummary' ).data( 'origtext' ) != $j( '#wpSummary' ).val()
		) {
			// Return our message
			return mw.usability.getMsg( 'vector-editwarning-warning' );
		}
	}
	// Add form submission handler
	$j( 'form' ).submit( function() {
		// Restore whatever previous onbeforeload hook existed
		window.onbeforeunload = fallbackWindowOnBeforeUnload;
	});
});
//Global storage of fallback for onbeforeunload hook
var fallbackWindowOnBeforeUnload = null;
/* Prototype code to demonstrate proposed edit page footer cleanups */
/* First draft and will be changing greatly */

$j(document).ready( function() {
	if( !wgVectorEnabledModules.footercleanup ) {
		return true;
	}
	$j( '#editpage-copywarn' )
		.add( '.editOptions' )
		.wrapAll( '<div id="editpage-bottom"></div>' );
	$j( '#wpSummary' )
		.data( 'hint',
			$j( '#wpSummaryLabel span small' )
				.remove()
				.text()
				// FIXME - Not a long-term solution. This change should be done in the message itself
				.replace( /\)|\(/g, '' )
		)
		.change( function() {
			if ( $j( this ).val().length == 0 ) {
				$j( this )
					.addClass( 'inline-hint' )
					.val( $j( this ).data( 'hint' ) );
			} else {
				$j( this ).removeClass( 'inline-hint' );
			}
		} )
		.focus( function() {
			if ( $j( this ).val() == $j( this ).data( 'hint' ) ) {
				$j( this )
					.removeClass( 'inline-hint' )
					.val( "" );
			}
		})
		.blur( function() { $j( this ).trigger( 'change' ); } )
		.trigger( 'change' );
	$j( '#wpSummary' )
		.add( '.editCheckboxes' )
		.wrapAll( '<div id="editpage-summary-fields"></div>' );
		
	$j( '#editpage-specialchars' ).remove();
	
	// transclusions
	// FIXME - bad CSS styling here with double class selectors. Should address here. 
	var transclusionCount = $j( '.templatesUsed ul li' ).size();
	$j( '.templatesUsed ul' )
		.wrap( '<div id="transclusions-list" class="collapsible-list collapsed"></div>' )
		.parent()
		// FIXME: i18n, remove link from message and let community add link to transclusion page if it exists
		.prepend( '<label>This page contains <a href="http://en.wikipedia.org/wiki/transclusion">transclusions</a> of <strong>'
			+ transclusionCount 
			+ '</strong> other pages.</label>' );
	$j( '.mw-templatesUsedExplanation' ).remove();
	
	$j( '.collapsible-list label' )
		.click( function() {
			$j( this )
				.parent()
				.toggleClass( 'expanded' )
				.toggleClass( 'collapsed' )
				.find( 'ul' )
				.slideToggle( 'fast' );
			return false;
		})
		.trigger( 'click' );
	$j( '#wpPreview, #wpDiff, .editHelp, #editpage-specialchars' )
		.remove();
	$j( '#mw-editform-cancel' )
		.remove()
		.appendTo( '.editButtons' );
} );
/* JavaScript for SimpleSearch extension */

// Disable mwsuggest.js on searchInput 
if ( wgVectorEnabledModules.simplesearch && skin == 'vector' && typeof os_autoload_inputs !== 'undefined' &&
		os_autoload_forms !== 'undefined' ) {
	os_autoload_inputs = [];
	os_autoload_forms = [];
}

$j(document).ready( function() {
	// Only use this function in conjuction with the Vector skin
	if( !wgVectorEnabledModules.simplesearch || skin != 'vector' ) {
		return true;
	}
	// Add form submission handler
	$j( 'div#simpleSearch > input#searchInput' )
		.each( function() {
			$j( '<label />' )
				.text( mw.usability.getMsg( 'vector-simplesearch-search' ) )
				.css({
					'display': 'none',
					'position' : 'absolute',
					'bottom': 0,
					'padding': '0.25em',
					'color': '#999999',
					'cursor': 'text'
				})
				.css( ( $j( 'body' ).is( '.rtl' ) ? 'right' : 'left' ), 0 )
				.click( function() {
					$j(this).parent().find( 'input#searchInput' ).focus();
				})
				.appendTo( $j(this).parent() );
			if ( $j(this).val() == '' ) {
				$j(this).parent().find( 'label' ).show();
			}
		})
		.focus( function() {
			$j(this).parent().find( 'label' ).hide();
		})
		.blur( function() {
			if ( $j(this).val() == '' ) {
				$j(this).parent().find( 'label' ).show();
			}
		});
	$j( '#searchInput, #searchInput2, #powerSearchText, #searchText' ).suggestions( {
		fetch: function( query ) {
			var $this = $j(this);
			var request = $j.ajax( {
				url: wgScriptPath + '/api.php',
				data: {
					'action': 'opensearch',
					'search': query,
					'namespace': 0,
					'suggest': ''
				},
				dataType: 'json',
				success: function( data ) {
					$this.suggestions( 'suggestions', data[1] );
				}
			});
			$j(this).data( 'request', request );
		},
		cancel: function () {
			var request = $j(this).data( 'request' );
			// If the delay setting has caused the fetch to have not even happend yet, the request object will
			// have never been set
			if ( request && typeof request.abort == 'function' ) {
				request.abort();
				$j(this).removeData( 'request' );
			}
		},
		result: {
			select: function( $textbox ) {
				$textbox.closest( 'form' ).submit();
			}
		},
		delay: 120
	} );
	$j( '#searchInput' ).suggestions( {
		result: {
			select: function( $textbox ) {
				$textbox.closest( 'form' ).submit();
			}
		},
		special: {
			render: function( query ) {
				var perfectMatch = false;
				$j(this).closest( '.suggestions' ).find( '.suggestions-results div' ).each( function() {
					if ( $j(this).data( 'text' ) == query ) {
						perfectMatch = true;
					}
				} );
				if ( perfectMatch ) {
					if ( $j(this).children().size() == 0  ) {
						$j(this).show();
						$label = $j( '<div />' )
							.addClass( 'special-label' )
							.text( mw.usability.getMsg( 'vector-simplesearch-containing' ) )
							.appendTo( $j(this) );
						$query = $j( '<div />' )
							.addClass( 'special-query' )
							.text( query )
							.appendTo( $j(this) );
						$query.autoEllipsis();
					} else {
						$j(this).find( '.special-query' )
							.empty()
							.text( query )
							.autoEllipsis();
					}
				} else {
					$j(this).hide();
					$j(this).empty();
				}
			},
			select: function( $textbox ) {
				$textbox.closest( 'form' ).append(
					$j( '<input />' ).attr( { 'type': 'hidden', 'name': 'fulltext', 'value': 1 } )
				);
				$textbox.closest( 'form' ).submit();
			}
		},
		$region: $j( '#simpleSearch' )
	} );
});

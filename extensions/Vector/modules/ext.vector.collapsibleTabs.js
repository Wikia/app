/*
 * Collapsible tabs for Vector
 */
jQuery(function( $ ) {	
	var rtl = $( 'body' ).is( '.rtl' );
	
	// Overloading the moveToCollapsed function to animate the transition 
	$.collapsibleTabs.moveToCollapsed = function( ele ) {
		var $moving = $( ele );
		
		//$.collapsibleTabs.getSettings( $( $.collapsibleTabs.getSettings( $moving ).expandedContainer ) ).shifting = true;
		// Do the above, except with guards for JS errors
		var data = $.collapsibleTabs.getSettings( $moving );
		if ( !data ) {
			return;
		}
		var expContainerSettings = $.collapsibleTabs.getSettings( $( data.expandedContainer ) );
		if ( !expContainerSettings ) {
			return;
		}
		expContainerSettings.shifting = true;

		// Remove the element from where it's at and put it in the dropdown menu
		var target = data.collapsedContainer;
		$moving.css( "position", "relative" )
			.css( ( rtl ? 'left' : 'right' ), 0 )
			.animate( { width: '1px' }, "normal", function() {
				$( this ).hide();
				// add the placeholder
				$( '<span class="placeholder" style="display:none;"></span>' ).insertAfter( this );
				$( this ).detach().prependTo( target ).data( 'collapsibleTabsSettings', data );
				$( this ).attr( 'style', 'display:list-item;' );
				//$.collapsibleTabs.getSettings( $( $.collapsibleTabs.getSettings( $( ele ) ).expandedContainer ) )
				//	.shifting = false;
				// Do the above, except with guards for JS errors
				var data = $.collapsibleTabs.getSettings( $( ele ) );
				if ( !data ) {
					return;
				}
				var expContainerSettings = $.collapsibleTabs.getSettings( $( data.expandedContainer ) );
				if ( !expContainerSettings ) {
					return;
				}
				expContainerSettings.shifting = false;
				$.collapsibleTabs.handleResize();
			} );
	};
	
	// Overloading the moveToExpanded function to animate the transition
	$.collapsibleTabs.moveToExpanded = function( ele ) {
		var $moving = $( ele );
		//$.collapsibleTabs.getSettings( $( $.collapsibleTabs.getSettings( $moving ).expandedContainer ) ).shifting = true;
		// Do the above, except with guards for JS errors
		var data = $.collapsibleTabs.getSettings( $moving );
		if ( !data ) {
			return;
		}
		var expContainerSettings = $.collapsibleTabs.getSettings( $( data.expandedContainer ) );
		if ( !expContainerSettings ) {
			return;
		}
		expContainerSettings.shifting = true;

		// grab the next appearing placeholder so we can use it for replacing
		var $target = $( data.expandedContainer ).find( 'span.placeholder:first' );
		var expandedWidth = data.expandedWidth;
		$moving.css( "position", "relative" ).css( ( rtl ? 'right' : 'left' ), 0 ).css( 'width', '1px' );
		$target.replaceWith( $moving.detach().css( 'width', '1px' ).data( 'collapsibleTabsSettings', data )
			.animate( { width: expandedWidth+"px" }, "normal", function( ) {
				$( this ).attr( 'style', 'display:block;' );
				//$.collapsibleTabs.getSettings( $( $.collapsibleTabs.getSettings( $( ele ) ).expandedContainer ) )
				//	.shifting = false;
				// Do the above, except with guards for JS errors
				var data = $.collapsibleTabs.getSettings( $( this ) );
				if ( !data ) {
					return;
				}
				var expContainerSettings = $.collapsibleTabs.getSettings( $( data.expandedContainer ) );
				if ( !expContainerSettings ) {
					return;
				}
				expContainerSettings.shifting = false;
				$.collapsibleTabs.handleResize();
			} ) );
	};
	
	// Bind callback functions to animate our drop down menu in and out
	// and then call the collapsibleTabs function on the menu 
	$( '#p-views ul' ).bind( 'beforeTabCollapse', function() {
		if ( $( '#p-cactions' ).css( 'display' ) == 'none' ) {
			$( '#p-cactions' )
				.addClass( 'filledPortlet' ).removeClass( 'emptyPortlet' )
				.find( 'h5' )
					.css( 'width','1px' ).animate( { 'width':'26px' }, 390 );
		}
	} ).bind( 'beforeTabExpand', function() {
		if ( $( '#p-cactions li' ).length == 1 ) {
			$( '#p-cactions h5' ).animate( { 'width':'1px' }, 370, function() {
				$( this ).attr( 'style', '' )	
					.parent().addClass( 'emptyPortlet' ).removeClass( 'filledPortlet' );
			});
		}
	} ).collapsibleTabs( {
		expandCondition: function( eleWidth ) {
			if( rtl ){
				return ( $( '#right-navigation' ).position().left + $( '#right-navigation' ).width() + 1 )
					< ( $( '#left-navigation' ).position().left - eleWidth );
			} else {
				return ( $( '#left-navigation' ).position().left + $( '#left-navigation' ).width() + 1 )
					< ( $( '#right-navigation' ).position().left - eleWidth );
			}
		},
		collapseCondition: function() {
			if( rtl ) {
				return ( $( '#right-navigation' ).position().left + $( '#right-navigation' ).width() )
					> $( '#left-navigation' ).position().left;
			} else {
				return ( $( '#left-navigation' ).position().left + $( '#left-navigation' ).width() )
					> $( '#right-navigation' ).position().left;
			}
		}
	} );
} );

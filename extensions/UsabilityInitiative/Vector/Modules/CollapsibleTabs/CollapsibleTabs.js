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

( function( $ ) {

$.fn.collapsibleTabs = function( $$options ) {
	// return if the function is called on an empty jquery object
	if( !this.length ) return this;
	//merge options into the defaults
	var $settings = $.extend( {}, $.collapsibleTabs.defaults, $$options );

	this.each( function() {
		var $this = $( this );
		// add the element to our array of collapsible managers
		$.collapsibleTabs.instances = ( $.collapsibleTabs.instances.length == 0 ?
			$this : $.collapsibleTabs.instances.add( $this ) );
		// attach the settings to the elements
		$this.data( 'collapsibleTabsSettings', $settings );
		// attach data to our collapsible elements
		$this.children( $settings.collapsible ).each( function() {
			var $collapsible = $( this );
			$collapsible.data( 'collapsibleTabsSettings', {
				'expandedContainer': $settings.expandedContainer,
				'collapsedContainer': $settings.collapsedContainer,
				'expandedWidth': $collapsible.width(),
				'prevElement': $collapsible.prev()
			} );
		} );
	} );
	
	// if we haven't already bound our resize hanlder, bind it now
	if( !$.collapsibleTabs.boundEvent ) {
		$( window )
			.delayedBind( '500', 'resize', function( ) { $.collapsibleTabs.handleResize(); } );
	}
	// call our resize handler to setup the page
	$.collapsibleTabs.handleResize();
	return this;
};

$.collapsibleTabs = {
	instances: [],
	boundEvent: null,
	defaults: {
		expandedContainer: '#p-views ul',
		collapsedContainer: '#p-cactions ul',
		collapsible: 'li.collapsible',
		shifting: false,
		expandCondition: function( eleWidth ) {
			return ( $( '#left-navigation' ).position().left + $( '#left-navigation' ).width() )
				< ( $( '#right-navigation' ).position().left - eleWidth );
		},
		collapseCondition: function() {
			return ( $( '#left-navigation' ).position().left + $( '#left-navigation' ).width() )
				> $( '#right-navigation' ).position().left;
		}
	},
	handleResize: function( e ){
		$.collapsibleTabs.instances.each( function() {
			var $this = $( this ), data = $this.data( 'collapsibleTabsSettings' );
			if( data.shifting ) return;

			// if the two navigations are colliding
			if( $this.children( data.collapsible ).length > 0 && data.collapseCondition() ) {
				
				$this.trigger( "beforeTabCollapse" );
				// move the element to the dropdown menu
				$.collapsibleTabs.moveToCollapsed( $this.children( data.collapsible + ':last' ) );
			}

			// if there are still moveable items in the dropdown menu,
			// and there is sufficient space to place them in the tab container
			if( $( data.collapsedContainer + ' ' + data.collapsible ).length > 0
					&& data.expandCondition( $( data.collapsedContainer ).children(
							data.collapsible+":first" ).data( 'collapsibleTabsSettings' ).expandedWidth ) ) {
				//move the element from the dropdown to the tab
				$this.trigger( "beforeTabExpand" );
				$.collapsibleTabs
					.moveToExpanded( data.collapsedContainer + " " + data.collapsible + ':first' );
			}
		});
	},
	moveToCollapsed: function( ele ) {
		var $moving = $( ele );
		var data = $moving.data( 'collapsibleTabsSettings' );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = true;
		$moving
			.remove()
			.prependTo( data.collapsedContainer )
			.data( 'collapsibleTabsSettings', data );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = false;
		$.collapsibleTabs.handleResize();
	},
	moveToExpanded: function( ele ) {
		var $moving = $( ele );
		var data = $moving.data( 'collapsibleTabsSettings' );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = true;
		// remove this element from where it's at and put it in the dropdown menu
		$moving.remove().insertAfter( data.prevElement ).data( 'collapsibleTabsSettings', data );
		$( data.expandedContainer ).data( 'collapsibleTabsSettings' ).shifting = false;
		$.collapsibleTabs.handleResize();
	}
};

} )( jQuery );
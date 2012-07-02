/**
 * Javascript code to be used with input type menuselect.
 *
 * @author Stephan Gambke
 *
 */

/**
 * Initializes a menuselect input
 *
 * @param inputID ( String ) the id of the input to initialize
 */
function SFI_MS_init( inputID, params ) {

	var inputShow = jQuery('#' + inputID + "_show");

	inputShow.one('focus', function(){

		var treeid = "#" + inputID.replace(/input/,"span") + "_tree"
		var tree = jQuery( treeid );
		var treeRoot = tree.children( "ul" );
		var treeAllLists = tree.find( "ul" );

		// wrap content in table to separate content from sub-menus and to
		// support animating the list item width later;
		// ensure list items have constant width,
		// TODO: prevent layout changes when list item width is changed
		// set position static ( was set to fixed to calculate text width )
		treeAllLists
		.each( function() {

			var maxwidth = 0;
			var listitems = jQuery(this).children("li");

			listitems
			.each( function() {

				var item = jQuery( this );
				var contents = item.contents()//.not( "ul" );
					.filter(function() {
					  return ! jQuery( this ).is('ul');
					});
				
				contents
				.wrapAll( '<table><tbody><tr><td class="cont"/>' );

				// insert the arrows indicating submenus
				if ( item.children( "ul" ).length > 0 ) {
					contents.parent()
					.after( '<td class="arrow" ><img src="' + sfigScriptPath + '/images/MenuSelectArrow.gif" /></td>' )
				}

				maxwidth = Math.max( item.outerWidth(false) + 10, maxwidth );

				item.css('position', 'static');

			} )

			if ( jQuery.browser.msie && document.documentMode <= "7" ) {
				maxwidth = 100;
				jQuery( this )
				.width( window.screen.width )
				.height( window.screen.height );
			} else if ( jQuery.browser.webkit || jQuery.browser.safari ) {
				maxwidth = 100;
			};


			listitems
			.width( maxwidth )
			.data( "width", maxwidth );
		})
		.fadeTo( 0, 0 );


		// sanitize links
		tree.find( "a" )
		.each(
			function() {

				var link = jQuery( this );

				// find title of target page
				if ( link.hasClass( 'new' ) ) { // for red links get it from the href

					regexp = /.*title=([^&]*).*/;
					res = regexp.exec( link.attr( 'href' ) );

					title = unescape( res[1] );

					link.data( 'title', title ); // save title in data

				} else { // for normal links title is in the links title attribute
					link.data( 'title', link.attr( 'title' ) ); // save title in data
				}

				link
				.removeAttr( 'title' )  // remove title to prevent tooltips on links
				.bind( "click", function( event ) {
					event.preventDefault();
				} ); // prevent following links

			}
		);

		// attach event handlers

		// mouse entered list item
		tree.find( "li" )
		.mouseenter( function( evt ) {

			var target = jQuery( evt.currentTarget );

			// switch classes to change display style
			target
			.removeClass( "ui-state-default" )
			.addClass( "ui-state-hover" );

			// if list item has sub-items...
			if ( target.children( "ul" ).length > 0 ) {

				// if we reentered (i.e. moved mouse from item to sub-item)
				if ( target.data( "timeout" ) != null) {

					// clear any timeout that may still run on the list item
					// (i.e. do not fade out submenu)
					clearTimeout( target.data( "timeout" ) );
					target.data( "timeout", null );

				} else {

					// set timeout to show sub-items
					target
					.data( "timeout", setTimeout(
						function() {

							var pos = target.position();

							// clear timeout data
							target
							.data( "timeout", null )

							// animate list item width
							.animate( {"width": target.width() + 10}, 100, function(){

							// fade in sub-menu
							// can not use fadeIn, it sets display:block
							target.children( "ul" )
							.css( {
								"display":"inline",
								"z-index":100,
								"top" : pos.top,
								"left" : pos.left + target.width()
							} )
							.fadeTo( 400, 100 );
							} );
						}, 400 )
					);
				}
			}

		} )

		// mouse left list item
		.mouseleave( function( evt ) {

			var target = jQuery( evt.currentTarget );

			// switch classes to change display style
			target
			.removeClass( "ui-state-hover" )
			.addClass( "ui-state-default" )

			// if list item has sub-items...
			if ( target.children( "ul" ).length > 0 ) {

				// if we just moved in and out of the item (without really hovering)
				if ( target.data( "timeout" ) != null ) {

					// clear any timeout that may still run on the list item
					// (i.e. do not fade in submenu)
					clearTimeout( target.data( "timeout" ) );
					target.data( "timeout", null );

				} else {

					// hide sub-items after a short pause
					target.data( "timeout", setTimeout(
						function() {

							// clear timeout data
							target.data( "timeout", null )

							// fade out sub-menu
							// when finished set display:none and put list item back in
							// line ( i.e. animate to original width )
							.children( "ul" )
							.css( "z-index", 1 )
							.fadeTo( 400, 0,
								function() {

									jQuery( this )
									.css( "display", "none" )

									// animate list item width
									.parent()
									.animate( {"width": jQuery( this ).parent().data( "width" )}, 100 );
								}
							);

						}, 400 )
					);
				}
			}

		} )

		// clicked list item
		.mousedown( function() {

			var content = jQuery( this ).children( "table" ).find( ".cont" );

			// set visible value and leave input
			inputShow
			.attr( "value", content.text() )
			.blur();

			// set hidden value that gets sent back to the server
			var link = content.children( "a" );

			// if content is link
			if ( link.length == 1 ) {

				// use title set by MW
				jQuery( "#" + inputID ).attr( "value", link.data( "title" ) );

			} else {

				// just use text of list item
				jQuery( "#" + inputID ).attr( "value", content.text() );

			}
			return false;

		} );

		// show top menu when input gets focus
		inputShow
		.focus( function() {
			treeRoot
			.css( "display", "inline" )
			.fadeTo( 400, 1 );
		} )

		// hide all menus when input loses focus
		.blur( function() {

			treeAllLists
			.fadeTo( 400, 0,
				function() {
					jQuery( this )
					.css( "display", "none" );
				} );
		} );

		tree
		.css("visibility","visible");

		treeRoot
		.css( "display", "inline" )
		.fadeTo( 400, 1 );

	});
}
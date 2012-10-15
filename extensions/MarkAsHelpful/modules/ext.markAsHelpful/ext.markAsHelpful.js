/**
 * Front-end scripting core for the MarkAsHelpful MediaWiki extension
 *
 * @author Rob Moen, 2011
 */

(function( $ ) {

	var mah = mw.mah = {
		loadedItems: [],
		selector: '[class^=markashelpful]',  //class of element(s) to apply MarkAsHelpful to.

		init: function() {
			var	props, thisItem;
			$( mah.selector ).each( function ( i, e ) {
				props = mah.getItemProperties( $(this) );
				thisItem = props.type + props.item; //create an item reference to place in the loaded items array.
	
				//load once per type+id because user can copy / paste element on the talk page and load the same item many times.
				if( $.inArray( thisItem, mah.loadedItems ) === -1 ) {
					mah.loadedItems.push( thisItem );
					mah.loadItem( $( this ) );
				}
			}); 
		},
		/*
		 * Return object of item properties
		 */
		getItemProperties: function( $item ) {
			var		tag = $item.attr( 'class' ),
					//item properties are stored in classname to prevent parser from stripping out non html 5 objects.  
					//(eg data-markashelpful-item)
					properties = {
						'item': tag.split( '-' )[2], // item id
						'type': tag.split( '-' )[1]  // item type (eg, mbresponse)
					};
			return properties;
		},
		/*
		 * Load the current state of the MarkAsHelpful item
		 */
		loadItem: function( $item ) {
			var		props = mah.getItemProperties( $item ),
					request = {
						'action': 'getmarkashelpfulitem',
						'item': props.item,
						'type': props.type,
						'page': mw.config.get( 'wgPageName' ),
						'format': 'json'
					};

			$.ajax({
				type: 'POST',
				url: mw.util.wikiScript('api'),
				cache: false,
				data: request,
				success: function( data ) {

					if ( data.getmarkashelpfulitem &&
						data.getmarkashelpfulitem.result == 'success' &&
						data.getmarkashelpfulitem.formatted
					) {
						var $content = $( data.getmarkashelpfulitem.formatted );
						$item.html( $content );
					} else {
						// Failure, do nothing to the item for now
					}
				},
				error: function ( data ) {
					// Failure, do nothing to the item for now
				},
				dataType: 'json'
			});
			
		},
		/*
		 * API call to mark or unmark an item as helpful.
		 */
		markItem: function( $clicked, action ) {
			var		$item = $clicked.parent().parent(),
					props = mah.getItemProperties( $item ),
					clientData = $.client.profile(),
					request;
			props.mahaction = action;
			request = $.extend( {
				'action': 'markashelpful',
				'page': mw.config.get( 'wgPageName' ),
				'useragent': clientData.name + '/' + clientData.versionNumber,
				'system': clientData.platform,
				'token': mw.user.tokens.get( 'editToken' ),
				'format': 'json'
			}, props );

			$.ajax( {
				type: 'post',
				url: mw.util.wikiScript( 'api' ),
				data: request,
				success: function () {
					mah.loadItem( $item );	
				},
				dataType: 'json'
			} );
		}
	};

	// Some live events for the different modes

	/*
	 * Click Event for marking an item as helpful.
	 */
	$( '.markashelpful-mark' ).live( 'click', function() {
		mah.markItem( $(this), 'mark' );
	} );

	/*
	 * Click Event for removing helpful status from an item.
	 */
	$( '.markashelpful-undo' ).live( 'click', function() {
		mah.markItem( $(this), 'unmark' );
	} );

	// Initialize MarkAsHelpful
	$( mah.init );
} ) ( jQuery );
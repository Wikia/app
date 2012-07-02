/**
 * JavaScript for <storyboard> tags.
 * 
 * @author Jeroen De Dauw
 * @ingroup Storyboard
 */

(function($) {
	$( document ).ready( function() {
		$( '.storyboard' ).ajaxScroll( {
			updateBatch: updateStoryboard,
			batchSize: 4,
			batchClass: "batch",
			boxClass: "storyboard-box",
			emptyBatchClass: "storyboard-empty",
			scrollPaneClass: "scrollpane"
		} );
	} );
	
	function updateStoryboard( ajaxscrollObj, $storyboard ) {
		requestArgs = {
			'action': 'query',
			'list': 'stories',
			'format': 'json',
			'stlimit': 4,
			'stlanguage': window.storyboardLanguage
		};

		if ( ajaxscrollObj.continueParam ) {
			requestArgs.stcontinue = ajaxscrollObj.continueParam;
		}

		$.getJSON( wgScriptPath + '/api.php',
			requestArgs,
			function( data ) {
				if ( data.query ) {
					addStories( ajaxscrollObj, $storyboard, data );
				} else {
					alert( stbMsgExt( 'storyboard-anerroroccured', [data.error.info] ) );
				}		
			}
		);
	}
	
	function addStories( ajaxscrollObj, $storyboard, data ) {
		// Remove the empty boxes.
		$storyboard.html( '' );
		
		for ( var i in data.query.stories ) {
			var story = data.query.stories[i];
			var $storyBody = $( "<div />" ).addClass( "storyboard-box" );
			
			var $header = $( "<div />" ).addClass( "story-header" ).appendTo( $storyBody );
			$( "<div />" ).addClass( "story-title" ).text( story.title ).appendTo( $header );
			
			var deliciousUrl = "http://delicious.com/save?jump=yes&amp;url=" + encodeURIComponent( story.permalink ) + "&amp;title=" + encodeURIComponent( story.title );
			var facebookUrl = "http://www.facebook.com/sharer.php?u=" + encodeURIComponent( story.permalink ) + '&amp;t=' + encodeURIComponent( story.title );
			
			$( "<div />" )
				.addClass( "story-sharing" )
				.append(
					$( "<div />" ).addClass( "story-sharing-item" ).append(
						$( "<a />" ).attr( {
							"target": "_blank",
							"rel": "nofollow",
							"href": deliciousUrl
						} )
						.click( function() { 
							window.open( jQuery( this ).attr( 'href' ), 'delicious-sharer', 'toolbar=0, status=0, width=850, height=650' );
							return false;
						} )						
						.append( $( "<img />" ).attr( "src",
							wgScriptPath + "/extensions/Storyboard/images/storyboard-delicious.png"
						) )
					)
				)
				.append(
					$( "<div />" ).addClass( "story-sharing-item" ).append(
						$( "<a />" ).attr( {
							"target": "_blank",
							"rel": "nofollow",
							"href": facebookUrl
						} )
						.click( function() { 
							window.open( jQuery( this ).attr( 'href' ), 'facebook-sharer', 'toolbar=0, status=0, width=626, height=436' );
							return false;
						} )
						.append( $( "<img />" ).attr( "src",
							wgScriptPath + "/extensions/Storyboard/images/storyboard-facebook.png"
						) )
					)
				)
				.append(
					$( "<div />" ).addClass( "story-sharing-item" ).append(
						$( "<a />" ).attr( {
							"target": "_blank",
							"rel": "nofollow",
							"href": "http://twitter.com/home?status=" + encodeURIComponent( story.permalink )
						 } )
						.append( $( "<img />" ).attr( "src",
							wgScriptPath + "/extensions/Storyboard/images/storyboard-twitter.png"
						) )
					)
				)
				.appendTo( $header );
			
			var textAndImg = $( "<div />" ).addClass( "story-text" ).text( story["*"] );
			
			if ( story.imageurl && story.imagehidden == "0" ) {
				textAndImg.prepend(
					$( "<img />" ).attr( {"src": story.imageurl, "title": story.title, "alt": story.title } ).addClass( "story-image" )
				);
			}
			
			$storyBody.append( textAndImg );
			
			var metaDataText; 
			if ( story.location != '' ) {
				metaDataText = stbMsgExt( 'storyboard-storymetadatafrom', [story.author, story.location, story.creationtime, story.creationdate] );
			}
			else {
				metaDataText = stbMsgExt( 'storyboard-storymetadata', [story.author, story.creationtime, story.creationdate] );
			}
			
			$storyBody.append(
				$( "<div />" ).addClass( "story-metadata" ).append(
					$("<span />").addClass( "story-metadata" ).text( metaDataText )
				)
			);
			
			// TODO: add hide and delete buttons
			
			$storyboard.append( $storyBody );	
		}
		
		ajaxscrollObj.continueParam = data["query-continue"] ? data["query-continue"].stories.stcontinue : false; 
		ajaxscrollObj.loaded = true;
	}
		
})(jQuery);
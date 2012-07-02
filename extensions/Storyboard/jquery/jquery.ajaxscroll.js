/**
 * AjaxScroll (jQuery Plugin)
 * http://project.yctin.com/ajaxscroll
 * Modified for MediaWiki Storyboard extension.
 * 
 * @license GPL
 * @version 0.2
 * 
 * @author Timmy Tin
 * @author Jeroen De Dauw
 */
(function($) {
	$.fn.ajaxScroll = function( opt ) {
		opt = jQuery.extend(
			{
				batchSize: 30,
				batchTemplate: null,
				boxTemplate: null,
				batchClass: "storyboard-batch",
				boxClass: "storyboard-box",
				emptyBatchClass: "storyboard-empty",
				scrollPaneClass: "scrollpane",
				lBound: "auto",
				uBound: "auto",
				eBound: "auto",
				scrollDelay: 600, // The interval for checking if the user scrolled, in ms.
				endDelay: 100,
				updateBatch: null,
				updateEnd: null,
				loaded: true,
				continueParam: ''
			},
			opt
		);
		
		return this.each( function() {
			var ele = this;
			var $me = jQuery( this );
			var $sp;
			var previousScrollPos = -1;
			
			$me.css( {
				"overflow-x": "hidden",
				"overflow-y": "auto"
			} );
			
			opt.boxTemplate = ( opt.boxTemplate || "<span class='" + opt.boxClass + "'>&nbsp</span>" );
			opt.batchTemplate = ( opt.batchTemplate || "<span></span>" );
			
			$sp = jQuery( "<div></div>" ).addClass( opt.scrollPaneClass );
			$me.append( $sp );
			batch( $sp, opt );
			batch( $sp, opt );
			$me.scrollTop(0).scrollLeft(0);
			
			var topOffset = $me.find( '.batch:first' ).next().offset().top;
			var b = ( $me.height() / topOffset + 1 ) * topOffset;
			
			if ( opt.uBound == "auto" ) {
				opt.uBound = b;
			}
			
			if ( opt.lBound == "auto" ) {
				opt.lBound = -b;
			}
			
			if ( opt.eBound == "auto" ) {
				opt.eBound = b * 2;
			}

			setTimeout( monEnd, opt.endDelay );
			
			// Initiate the scroll handling.
			if( typeof opt.updateBatch == 'function' ){
				setTimeout( handleScrolling, opt.scrollDelay );
			}
			
			function batch( $s, opt ) {
				var $b;
				var i;
				
				$b = jQuery( opt.batchTemplate )
					.attr({
						len: opt.batchSize
					})
					.addClass( opt.batchClass + " " + opt.emptyBatchClass );
				
				i = opt.batchSize;
				
				while( i-- ){
					$b.append( opt.boxTemplate );
				}
				
				$s.append( $b );
			};
			
			/**
			 * This function emulates a scroll event handler by firing itself every so many ms.
			 * It checks if the user has scrolled down far enough, and calls the update batch
			 * function if this is the case.
			 */
			function handleScrolling() {
				if ( !opt.loaded ) return;
				
				var scrollPos = $me.scrollTop();
				
				// TODO: add check to make sure the board is not currently busy
				if ( previousScrollPos != scrollPos ) {
					previousScrollPos = scrollPos;
					var co = $me.offset().top;
					
					$sp.find( '> .' + opt.emptyBatchClass ).each( function( i, obj ) {
						// Only do one batch. This is needed to retain empty space at load, while not loading 2 identical batches.
						if ( i > 0 ) return;
						
						var $batchDiv = jQuery( obj );
						var p = $batchDiv.position().top - co;
						
						if ( opt.lBound > p || p > opt.uBound ) { 
							return;
						}
						
						opt.loaded = false;
						opt.updateBatch( opt, $batchDiv.removeClass( opt.emptyBatchClass ) );
					});
				}
				
				setTimeout( handleScrolling, opt.scrollDelay );
			};

			function monEnd() {
				setTimeout( monEnd, vEnd() );
			}
			
			function vEnd() {
				if ( ele.scrollTop > 0 && ele.scrollHeight - ele.scrollTop < opt.eBound && opt.loaded ) {
					batch( $sp, opt );
					return 1;
				}
				
				return opt.endDelay;
			};
			
		});
	}; 
})(jQuery);

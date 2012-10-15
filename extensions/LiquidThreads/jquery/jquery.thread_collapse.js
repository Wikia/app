( function( $ ) {
	
	$.fn.thread_collapse = function( $$options ) {
		// return if the function is called on an empty jquery object
		if( !this.length ) return this;
		//merge options into the defaults
		var $settings = $.extend( {}, $.thread_collapse.defaults, $$options );
		// run the initialization on each jquery object
		this.each( function() {
			$thread = $( this );
			// add collapse controls to this thread
			$.thread_collapse.fn.init( $thread );
			// add collapse controls recursivly to the child threads
			$thread.find( '.lqt_thread' ).each( function() {
				$.thread_collapse.fn.init( this );
			} );
		} );
		return this;
	};
	
	$.thread_collapse = {
		'fn' : {
			'init': function( thread ) {
				return $( thread )
					.bind( 'collapse.thread_collapse', $.thread_collapse.fn.toggleCollapse )
					.children( '.lqt-post-wrapper' )
					.prepend( $( $.thread_collapse.templates.collapseControl )
						.find( 'a' )
						.bind( 'click.thread_collapse', $.thread_collapse.fn.toggleCollapse )
						.end() );
			},
			// FIXME - appends parent nodes twice...bad logic here
			'getPreview': function( thread, depth ) {
				var $out = $( '<ul />' )
					.addClass( 'thread-collapse-preview' )
					.addClass( 'thread-collapse-preview-depth-' + depth )
					.append( $( '<li />' )
						.append( thread.find( '.lqt-post-wrapper:first .lqt-thread-signature' ).clone() )
					);
				thread.find( '.lqt-thread-replies' ).children( '.lqt_thread' ).each( function() {
					$out.append( $.thread_collapse.fn.getPreview( $( this ), depth + 1 ) );
				} );
				return $out;
			},
			'toggleCollapse': function() {
				var $thread = $( this ).closest( '.lqt_thread' );
				if( $thread.is( '.collapsed_thread' ) ) {
					// expand!
					$thread
						.removeClass( 'collapsed_thread' )
						.children()
						.show()
						.parent()
						.children( '.thread-collapsed-preview' )
						.hide();
				} else { 
					// collapse! 
					// if the thread preview already exists, don't bother recreating it
					if( $thread.children( '.thread-collapsed-preview' ).size() > 0 ) {
						$thread
							.addClass( 'collapsed_thread' )
							.children()
							.hide()
							.end()
							.children( '.thread-collapsed-preview' )
							.show();
					} else {
						// counter for the number of replies
						var numReplies =  $thread.find( '.lqt_thread' ).size() + 1;
						// create the thread preview we'll use in the collapsed state
						var $preview = $( '<div class="thread-collapsed-preview"></div>' )
							.addClass( 'lqt-post-wrapper' )
							.append( $( $.thread_collapse.templates.collapseControl )
								.find( 'a' )
								.text( 'Expand' )
								.addClass( 'thread-control-collapsed' )
								.bind( 'click.thread_collapse', $.thread_collapse.fn.toggleCollapse )
								.end() )
							.append( $( '<span />' )
								.addClass( 'thread-collapsed-num-replies' )
								.text( 'Show ' + numReplies + ' more replies' ) )
							.append( $.thread_collapse.fn.getPreview( $thread, 0 ) );
						// hide the other elements of the thread, and append the collapsed preview
						$thread
							.children()
							.hide()
							.end()
							.addClass( 'collapsed_thread' )
							.append( $preview );
					}
				}
				return false;
			}
		},
		templates: {
			'collapseControl': '<span class="thread-collapse-control"> \
				<a href="#">Collapse</a> \
			</span>'
		},
		defaults: {
			
		}
	};
	// FIXME - this should be moved out of here
	$( document ).ready( function () {
		$( '.lqt-thread-topmost' ).thread_collapse();
	} ); //document ready
} )( jQuery );
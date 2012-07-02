/* JavaScript for the Article Creation Extension */

(function( $, mw, undefined ) {
	
	var ac = mw.articleCreation;

	$.extend(ac, {
		init: function() {
			//store a reference to the panel
			ac.panel = $('#article-creation-panel');

			ac.setupTooltips();

			//setup button hover states
			ac.panel
				.find( '.ac-article-button' )
					.each( function (i, e) {
						var		button = $(this).data('ac-button'),
								$tooltip;

						$(this)
							//attach other events here, just making first tooltip for now
							//testing hover effects
							.hover (function (){
								if ( $(this).hasClass('ac-button-selected') )
									return;
									
								$( this ).parent()
								.find('.mw-ac-tooltip')
								.show();
							}, function(){
								if ( $(this).hasClass('ac-button-selected') )
									return;
								$( this ).parent()
								.find('.mw-ac-tooltip')
								.hide();
							});

						//set the pointy position
						var $button = $(this);
						
						$button.parent().find('.mw-ac-tip').each(
							function() {
								ac.setupTipHeights( $(this), $button );
							} );
					});

			// setup button click states
			ac.panel
				.find('.ac-article-button')
				.click (function (e) {
					e.preventDefault();

					$('.ac-article-button')
						//remove green states and hide their tooltips
						.removeClass('ac-button-green')
						.removeClass('ac-button-selected')
						.each ( function (i, e) {
							$(this) .parent()
								.find('.mw-ac-tooltip')
								.hide();
						});
						
					ac.panel
						.find('.mw-ac-interstitial')
						.hide();

					if ( ! $(this).parent().find('.mw-ac-interstitial').length ||
						ac.isInterstitialDisabled($(this).data('ac-button'))
					) {
						ac.executeAction( $(this).data('ac-button' ) );
						return;
					}

					if ( ac.config['tracking-turned-on'] ) {
						jQuery.trackAction( ac.config['tracking-code-prefix'] + $(this).data('ac-button' ) + '-tooltip' );
					}

					$( this )
						//make it green
						.addClass('ac-button-green')
						.addClass('ac-button-selected')
						.parent()
						.find('.mw-ac-tooltip' )
							.hide()
							.end()
						.find('.mw-ac-interstitial')
							.show();
					
				});

			//setup hover / fade effects
			ac.panel
				.find('.ac-article-button')
				.hover (function (){
					$( '.ac-article-button' )
						.not( this )
						.addClass( 'ac-faded' );
				}, function(){
					$( '.ac-article-button' )
						.removeClass( 'ac-faded' );
				});

		},
		
		setupTooltips: function ( ) {

			ac.panel.find('.mw-ac-tip').localize();
			
			ac.panel.find('.mw-ac-interstitial')
				.find('.ac-action-button')
				.click( function(e) {
					e.preventDefault();
					ac.executeAction($(this).data('ac-action'));
				} );
		},
		
		setupTipHeights : function( $tooltip, $button ) {
			$tooltip
				.find( '.mw-ac-tooltip-pointy' )
				.css('top', (( $tooltip.height() / 2) -10) + 'px' )
				.end();
			//set the tooltip position
			var newPosition = ($button.height() / 2) -
					($tooltip.height() / 2 ) + 10;
			$tooltip.css('top',  newPosition+'px');
		},
		
		executeAction : function( action ) {
			if ( $('.ac-dismiss-interstitial').is(':checked') ) {
				ac.disableInterstitial( action );
			}

			var article = wgPageName.substr( wgPageName.indexOf('/') + 1 );
			var urlTemplate = ac.config['action-url'][action];

			urlTemplate = urlTemplate.replace( '{{PAGE}}', encodeURIComponent( article ) );
			urlTemplate = urlTemplate.replace( '{{USER}}', encodeURIComponent( wgUserName ) );
			urlTemplate = urlTemplate.replace( '{{SCRIPT}}', wgScript );
			
			if ( ac.config['tracking-turned-on'] ) {
				jQuery.trackAction( ac.config['tracking-code-prefix'] + action );
			}
			
			window.location.href = urlTemplate;
		},

		disableInterstitial : function(button) {
			$.cookie( 'mw:ac:disabled-interstitial:'+button, 1,
				{ expires : 365, path : '/' } );
		},

		isInterstitialDisabled : function(button) {
			if ( $.cookie('mw:ac:disabled-interstitial:'+button) ) {
				return true;
			}

			return false;
		}

	});

	ac.init();

})( jQuery, window.mw );

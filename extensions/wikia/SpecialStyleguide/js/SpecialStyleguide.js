require(['jquery'], function($) {
	$(function() {

		var $toc = $('#styleguideTOC');

		if ($toc.length) {
			require(['wikia.window', 'wikia.ui.toc'], function(w, TOC) {

				var tocOffsetTop = $toc.offset().top,
					TOC_TOP_MARGIN = 10, // const for top margin of fixed TOC set in CSS
					tocInstance = new TOC($toc);

				tocInstance.init();

				/**
				 * Fix / unfix TOC position
				 */
				function setTOCPosition() {
					var scrollTop = $('body').scrollTop();

					// in Chrome $('body').scrollTop() does change when you scroll whereas $('html').scrollTop() doesn't
					// in Firefox/IE $('html').scrollTop() does change when you scroll whereas $('body').scrollTop() doesn't
					scrollTop = ( scrollTop === 0 ) ? $('html').scrollTop() : scrollTop;

					if( scrollTop >= tocOffsetTop - TOC_TOP_MARGIN ) {
						$toc.addClass('toc-fixed');
					} else {
						$toc.removeClass('toc-fixed');
					}
				}

				var throttled = $.throttle( 50, setTOCPosition);
				$(w).on('scroll', throttled);
			});
		}

		/**
		 * Show hide Style guide section
		 *
		 * @param {Object} $target - jQuery selector (show/hide link) that gives context to which element should be show / hide
		 */
		function showHideSections($target) {
			var	$section = $target.parent().next(),
				linkLabel;

			$section.toggleClass('shown');

			linkLabel = ($section.hasClass('shown') ? $.msg( 'styleguide-hide-parameters' ) : $.msg( 'styleguide-show-parameters' ));
			$target.text(linkLabel);
		}

		function showDrawerExamples() {
			var $drawerSection = $( '#drawer' ),
				leftDrawerMsg = $.msg( 'styleguide-example-left' ),
				rightDrawerMsg = $.msg( 'styleguide-example-right' );

			require( [ 'wikia.ui.factory' ], function( uiFactory ) {
				uiFactory.init( "button" ).then( function( buttonInstance ) {
					var $drawerExamples = $drawerSection.find( '.example' );
					var drawerSampleButtons = buttonInstance.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "primary", "normal", "sampleDrawerLeft" ],
						"value": leftDrawerMsg
					} } );
					drawerSampleButtons += buttonInstance.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "primary", "normal", "sampleDrawerRight" ],
						"value": rightDrawerMsg
					} } );
					$drawerExamples.append( drawerSampleButtons );
				} );

				uiFactory.init( "drawer" ).then( function( drawerInstance ) {
					var drawerSamples = drawerInstance.render( {
						type: "default",
						vars: {
							side: 'left',
							content: '<h1>' + leftDrawerMsg + '</h1>',
							"class": "styleguide-example-left"
						}
					} );
					drawerSamples += drawerInstance.render( {
						type: "default",
						vars: {
							side: 'right',
							content: '<h1>' + rightDrawerMsg + '</h1>',
							"class": "styleguide-example-right"
						}
					} );
					$('body').append( drawerSamples );

					require( [ 'wikia.ui.drawer' ], function( drawer ) {
						var leftDrawer = drawer.init( 'left' );
						var rightDrawer = drawer.init( 'right' );

						$( ".sampleDrawerLeft" ).click(function() {
							if( leftDrawer.isOpen() ) {
								leftDrawer.close();
							} else {
								leftDrawer.open();
							}
						} );

						$( ".sampleDrawerRight" ).click(function() {
							if( rightDrawer.isOpen() ) {
								rightDrawer.close();
							} else {
								rightDrawer.open();
							}
						} );
					} );
				} );
			} );
		}

		function showSmallModalExample() {
			var $modalSection = $( '#modal' ),
				smallModalExampleMsg = $.msg( 'styleguide-example-modal-small-modal' );

			require( [ 'wikia.ui.factory' ], function( uiFactory ) {
				uiFactory.init( "button" ).then( function( button ) {
					var $modalExamples = $modalSection.find( '.example' );
					var modalSampleButtons = button.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "primary", "normal", "small-modal-example-button" ],
						"value": smallModalExampleMsg
					} } );
					$modalExamples.append( modalSampleButtons );
					var smallModal2ndBtn = button.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "secondary", "normal", "close" ],
						"value": $.msg( 'styleguide-example-modal-secondary-button' )
					} } );
					var smallModal1stBtn = button.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "primary", "normal", "close" ],
						"value": $.msg( 'styleguide-example-modal-primary-button' )
					} } );

					uiFactory.init( "modal" ).then( function( modal ) {
						var smallModal = modal.render( {
							type: "default",
							vars: {
								"id": 'smallModalExample',
								"size": 'small',
								"content": smallModalExampleMsg,
								"class": "styleguide-example-small",
								"title": smallModalExampleMsg,
								"closeButton": true,
								"altLink": {
									"id": "smallModalAltLink",
									"href": "#",
									"text": $.msg( 'styleguide-example-modal-alt-link' )
								},
								"secondBtn": smallModal2ndBtn,
								"primaryBtn": smallModal1stBtn
							}
						} );
						$('body').append( smallModal );

						require( [ 'wikia.ui.modal' ], function( modal ) {
							var smallModal = modal.init( 'smallModalExample' );

							$( ".small-modal-example-button" ).click(function() {
								if( smallModal.isShown() ) {
									smallModal.hide();
								} else {
									smallModal.show();
								}
							} );

							$( ".modal" ).on( "click", "#smallModalAltLink", function( event ) {
								event.preventDefault();
								smallModal.hide();
							} );
						} );
					} );

				} );
			} );
		}

		function showMediumModalExample() {
			var $modalSection = $( '#modal' ),
				mediumModalExampleMsg = $.msg( 'styleguide-example-modal-medium-modal' );

			require( [ 'wikia.ui.factory' ], function( uiFactory ) {
				uiFactory.init( "button" ).then( function( button ) {
					var $modalExamples = $modalSection.find( '.example' );
					var modalSampleButtons = button.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "primary", "normal", "medium-modal-example-button" ],
						"value": mediumModalExampleMsg
					} } );
					$modalExamples.append( modalSampleButtons );
					var mediumModal2ndBtn = button.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "secondary", "normal", "close" ],
						"value": $.msg( 'styleguide-example-modal-secondary-button' )
					} } );
					var mediumModal1stBtn = button.render( { type: "button", vars: {
						"type": "button",
						"classes": [ "primary", "normal", "close" ],
						"value": $.msg( 'styleguide-example-modal-primary-button' )
					} } );

					uiFactory.init( "modal" ).then( function( modal ) {
						var mediumModal = modal.render( {
							type: "default",
							vars: {
								"id": 'mediumModalExample',
								"size": 'medium',
								"content": mediumModalExampleMsg,
								"class": "styleguide-example-medium",
								"title": mediumModalExampleMsg,
								"closeButton": true,
								"altLink": {
									"id": "mediumModalAltLink",
									"href": "#",
									"text": $.msg( 'styleguide-example-modal-alt-link' )
								},
								"secondBtn": mediumModal2ndBtn,
								"primaryBtn": mediumModal1stBtn
							}
						} );
						$('body').append( mediumModal );

						require( [ 'wikia.ui.modal' ], function( modal ) {
							var mediumModal = modal.init( 'mediumModalExample' );

							$( ".medium-modal-example-button" ).click(function() {
								if( mediumModal.isShown() ) {
									mediumModal.hide();
								} else {
									mediumModal.show();
								}
							} );

							$( ".modal" ).on( "click", "#smallModalAltLink", function( event ) {
								event.preventDefault();
								mediumModal.hide();
							} );
						} );
					} );

				} );
			} );
		}

		/** Attach events */
		$('body').on('click', '#mw-content-text section .toggleParameters', function(event) {
			event.preventDefault();
			showHideSections($(event.target));
		});

		/** Let's skip default browser action for example links/buttons (DAR-2172) */
		$('.example').on( 'click', 'a', function(event) {
			event.preventDefault();
		});

		/** Examples **/
		showDrawerExamples();
		showSmallModalExample();
		showMediumModalExample();
	});
});

/* global $ */
var CreatePage = {
	pageLayout: null,
	options: {},
	loading: false,
	context: null,
	wgArticlePath: mw.config.get( 'wgArticlePath' ),
	canUseVisualEditor: ( mw.libs && mw.libs.ve ? mw.libs.ve.canCreatePageUsingVE() : false ),
	redlinkParam: '',

	checkTitle: function( title ) {
		'use strict';
		$.getJSON( CreatePage.context.wgScript, {
			action: 'ajax',
			rs: 'wfCreatePageAjaxCheckTitle',
			title: title
		},
		function( response ) {
			var articlePath;
			if ( response.result === 'ok' ) {
				if ( CreatePage.canUseVisualEditor && mw.libs.ve.isInValidNamespace( title ) ) {
					articlePath = CreatePage.wgArticlePath.replace( '$1', encodeURIComponent( title ) );
					location.href = articlePath + '?veaction=edit' + CreatePage.redlinkParam;
				} else {
					location.href = CreatePage.options[ CreatePage.canUseVisualEditor ? 'blank' :
						CreatePage.pageLayout ].submitUrl.replace( '$1', encodeURIComponent( title ) ) +
						CreatePage.redlinkParam;
				}
			}
			else {
				CreatePage.displayError( response.msg );
			}
		});
	},

	requestDialog: function( e, titleText ) {
		'use strict';

		var rs, dialogCallback;

		// BugId:4941
		if ( Boolean( window.WikiaEnableNewCreatepage ) === false ) {
			// create page popouts are disabled - follow the link
			return;
		}

		// Ignore middle-click. BugId:12544
		if ( e && e.which === 2 ) {
			return;
		}

		// don't follow the link
		if ( e && e.preventDefault ) {
			e.preventDefault();
		}

		// VE and <createbox>
		if ( CreatePage.canUseVisualEditor && $( e.target ).hasClass( 'createboxButton' ) ) {
			CreatePage.checkTitle( titleText );
			return;
		}

		if ( false === CreatePage.loading ) {
			CreatePage.loading = true;

			if ( CreatePage.canUseVisualEditor && titleText ) {
				rs = 'wfCreatePageAjaxGetVEDialog';
				dialogCallback = CreatePage.openVEDialog;
			} else {
				rs = 'wfCreatePageAjaxGetDialog';
				dialogCallback = CreatePage.openDialog;
			}

			$.getJSON(
				CreatePage.context.wgScript,
				{
					action: 'ajax',
					rs: rs,
					article: titleText
				},
				dialogCallback
			);
		}
	},

	openVEDialog: function( data ) {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				var createPageModalConfig = {
					vars: {
						id: 'CreatePageModalDialog',
						size: 'small',
						title: data.title,
						content: data.html,
						classes: [ 'modalContent' ],
						buttons: [
							{
								vars: {
									value: data.addPageLabel,
									classes: [ 'normal', 'primary' ],
									imageClass: 'new',
									data: [
										{
											key: 'event',
											value: 'create'
										}
									]
								}
							},
							{
								vars: {
									value: data.cancelLabel,
									classes: [ 'normal', 'secondary' ],
									data: [
										{
											key: 'event',
											value: 'cancel'
										}
									]
								}
							}
						]
					}
				};
				uiModal.createComponent( createPageModalConfig, function( createPageModal ) {
					CreatePage.track( { action: 'impression', label: 've-redlink-modal' } );

					createPageModal.bind( 'create', function( event ) {
						CreatePage.track( { action: 'click', label: 've-redlink-create' } );
						CreatePage.submitDialog( false );
					});
					createPageModal.bind( 'cancel', function( event ) {
						event.stopPropagation();
						CreatePage.track( { action: 'click', label: 've-redlink-cancel' } );
						createPageModal.trigger( 'close' );
					});

					createPageModal.$blackout.add( createPageModal.$close )
						.on(
							'click',
							function( event ) {
								if ( event.target === event.delegateTarget ) {
									CreatePage.track( { action: 'click', label: 've-redlink-close' } );
								}
							}
						);

					CreatePage.loading = false;
					createPageModal.show();
				});
			});
		});
	},

	openDialog: function( data ) {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				var createPageModalConfig = {
					vars: {
						id: 'CreatePageModalDialog',
						size: 'medium',
						title: data.title,
						content: data.html,
						classes: [ 'modalContent' ],
						buttons: [
							{
								vars: {
									value: data.addPageLabel,
									classes: [ 'normal', 'primary' ],
									imageClass: 'new',
									data: [
										{
											key: 'event',
											value: 'create'
										}
									]
								}
							}
						]
					}
				};
				uiModal.createComponent( createPageModalConfig, function( createPageModal ) {
					var idToken,
						elm,
						onElementClick,
						name,
						titleText;

					createPageModal.bind( 'create', function( event ) {
						event.preventDefault();
						CreatePage.submitDialog( false );
					});

					onElementClick = function() {
						CreatePage.setPageLayout( $( this ).data( 'optionName' ) );
					};

					for ( name in CreatePage.options ){
						idToken = name.charAt( 0 ).toUpperCase() + name.substring( 1 );
						elm = $( '#CreatePageDialog' + idToken + 'Container' );

						elm.data( 'optionName', name );
						elm.click( onElementClick );
					}

					titleText = data.article;

					// Titles can be numbers, let's just make them strings for simplicity
					if ( typeof titleText === 'number' ) {
						titleText = titleText.toString();
					}

					if ( titleText ) {
						$( '#wpCreatePageDialogTitle' ).val( decodeURIComponent( titleText ) );
					}

					CreatePage.setPageLayout( data.defaultOption );

					$( '#wpCreatePageDialogTitle' ).focus();

					// Hide formats if ve is available
					if ( CreatePage.canUseVisualEditor ) {
						$( '#CreatePageDialogChoose, #CreatePageDialogChoices' ).hide();
					}
					CreatePage.loading = false;
					createPageModal.show();
				});
			});
		});
	},

	submitDialog: function( enterWasHit ) {
		'use strict';
		CreatePage.checkTitle( $( '#wpCreatePageDialogTitle' ).val(), enterWasHit );
	},

	displayError: function( errorMsg ) {
		'use strict';
		var box = $( '#CreatePageDialogTitleErrorMsg' );
		box.html( '<span id="createPageErrorMsg">' + errorMsg + '</span>' );
		box.removeClass( 'hiddenStructure' );
	},

	setPageLayout: function( layout ) {
		'use strict';
		CreatePage.pageLayout = layout;
		var idToken = layout.charAt( 0 ).toUpperCase() + layout.substring( 1 );

		$( '#CreatePageDialog' + idToken ).attr( 'checked', 'checked' );
		$( '#CreatePageDialogChoices' ).children( 'li' ).removeClass( 'accent' );
		$( '#CreatePageDialog' + idToken + 'Container' ).addClass( 'accent' );
	},

	getTitleFromUrl: function( url ) {
		'use strict';
		var uri = new mw.Uri( url );

		return uri.path.replace( CreatePage.wgArticlePath.replace( '$1', '' ), '' ).replace( /_/g, ' ' );
	},

	redLinkClick: function( e, titleText ) {
		'use strict';
		CreatePage.redlinkParam = '&redlink=1';

		if ( CreatePage.canUseVisualEditor ) {
			CreatePage.track( { action: 'click', label: 've-redlink-click' } );
		}

		var title = titleText.split( ':' ),
			isContentNamespace = false,
			i;

		if ( window.ContentNamespacesText && ( title.length > 1 ) ) {
			for ( i in window.ContentNamespacesText ) {
				if ( title[ 0 ] === window.ContentNamespacesText[ i ] ) {
					isContentNamespace = true;
				}
			}
		}
		else {
			isContentNamespace = true;
		}

		if ( isContentNamespace ) {
			CreatePage.requestDialog( e, titleText );
		}
		else {
			return false;
		}
	},

	init: function( context ) {
		'use strict';
		CreatePage.context = context;
		if ( window.WikiaEnableNewCreatepage ) {
			$().log( 'init', 'CreatePage' );

			if ( !window.WikiaDisableDynamicLinkCreatePagePopup ) {
				$( '#dynamic-links-write-article-link, #dynamic-links-write-article-icon' ).click(function( e ) {
					CreatePage.requestDialog( e, null );
				});
				$( '.noarticletext a[href*="redlink=1"]' ).click(function( e ) {
					CreatePage.requestDialog( e, CreatePage.context.wgPageName ); return false;
				});
			}

			// CreatePage chicklet ( Oasis )
			$( '.createpage' ).click( CreatePage.requestDialog );

			// macbre: RT #38478
			var addRecipeTab = $( '#add_recipe_tab' ),
				addRecipeLink;
			if ( addRecipeTab.exists() ) {
				addRecipeLink = addRecipeTab.find( 'a' );

				// only show popup if this tab really points to CreatePage
				if ( addRecipeLink.attr( 'href' ).match( /CreatePage$/ ) ) {
					addRecipeLink.click( CreatePage.requestDialog );
				}
			}

			$( 'a.new' ).bind( 'click', function( e ) {
				CreatePage.redLinkClick( e, CreatePage.getTitleFromUrl( this.href ) );
			});

			$( '.createboxButton' ).bind( 'click', function( e ) {
				var form = $( e.target ).parent(),
					prefix,
					field,
					preloadField;

				// make sure we're inside createbox and not inputbox ( RT #40959 )
				if ( form.attr( 'class' ) === 'createboxForm' ) {
					prefix = form.children( 'input[name=\'prefix\']' ).val() || '';
					field = form.children( '.createboxInput' );
					preloadField = form.children( 'input[name=\'preload\']' );

					if ( ( typeof preloadField.val() === undefined ) || ( preloadField.val() === '' ) ) {
						CreatePage.requestDialog( e, prefix + field.val() );
					}
					else {
						return true;
					}
				}
			});
		}
	},

	// Tracking for VE dialog only
	track: function( data ) {
		var defaultData;

		if ( Wikia.Tracker ) {
			defaultData = {
				category: 'article',
				trackingMethod: 'internal'
			}

			$.extend( defaultData, data );

			Wikia.Tracker.track( defaultData );
		}
	}
};

jQuery(function() {
	'use strict';
	CreatePage.init( window );
});

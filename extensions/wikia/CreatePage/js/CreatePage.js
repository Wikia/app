/* global $ */
var CreatePage = {
	pageLayout: null,
	options: {},
	loading: false,
	context: null,
	wgArticlePath: mw.config.get( 'wgArticlePath' ),
	redlinkParam: '',
	flowName: '',

	canUseVisualEditor: function() {
		return mw.libs && mw.libs.ve ? mw.libs.ve.canCreatePageUsingVE() : false;
	},

	checkTitle: function( title, trackingCategory ) {
		'use strict';
		$.getJSON( CreatePage.context.wgScript, {
			action: 'ajax',
			rs: 'wfCreatePageAjaxCheckTitle',
			title: title
		},
		function( response ) {
			var articlePath;
			var flowParam = ( CreatePage.flowName === '' ) ? '' : '&flow=' + CreatePage.flowName;

			if ( response.result === 'ok' ) {
				CreatePage.track( {
					category: trackingCategory,
					action: Wikia.Tracker.ACTIONS.SUCCESS,
					label: 'open-editor'
				} );

				if ( CreatePage.canUseVisualEditor() && mw.libs.ve.isInValidNamespace( title ) ) {
					articlePath = CreatePage.wgArticlePath.replace( '$1', encodeURIComponent( title ) );
					location.href = articlePath + '?veaction=edit' + CreatePage.redlinkParam + flowParam;
				} else {
					location.href = CreatePage.options[ CreatePage.canUseVisualEditor() ? 'blank' :
						CreatePage.pageLayout ].submitUrl.replace( '$1', encodeURIComponent( title ) ) +
						CreatePage.redlinkParam + flowParam;
				}
				CreatePage.flowName = '';
			}
			else {
				CreatePage.track( {
					category: trackingCategory,
					action: Wikia.Tracker.ACTIONS.ERROR,
					label: response.error
				} );
				CreatePage.displayError( response.msg, trackingCategory );
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
		if ( CreatePage.canUseVisualEditor() && $( e.target ).hasClass( 'createboxButton' ) ) {
			CreatePage.checkTitle( titleText );
			return;
		}

		if ( false === CreatePage.loading ) {
			CreatePage.loading = true;

			if ( CreatePage.canUseVisualEditor() && titleText ) {
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
		var trackingCategory = 'redlink-page-create-title-modal';
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
					CreatePage.track( {
						category: trackingCategory,
						action: Wikia.Tracker.ACTIONS.IMPRESSION,
						label: 'modal'
					} );

					createPageModal.bind( 'create', function() {
						CreatePage.submitDialog( trackingCategory );
					});
					createPageModal.bind( 'cancel', function( event ) {
						event.stopPropagation();
						CreatePage.track( {
							category: trackingCategory,
							action:  Wikia.Tracker.ACTIONS.CLICK,
							label: 'cancel'
						} );
						createPageModal.trigger( 'close' );
					});

					createPageModal.$blackout.add( createPageModal.$close )
						.on(
							'click',
							function( event ) {
								if ( event.target === event.delegateTarget ) {
									CreatePage.track( {
										category: trackingCategory,
										action: Wikia.Tracker.ACTIONS.CLOSE,
										label: 'close'
									} );
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
		var trackingCategory = 'page-create-title-modal';
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
						titleText,
						inputChangeTracked = false,
						redLinks;

					CreatePage.track( {
						category: trackingCategory,
						action: Wikia.Tracker.ACTIONS.IMPRESSION,
						label: 'modal'
					} );

					redLinks = createPageModal.$element.find( '.create-page-dialog__proposals .new' );

					if ( redLinks.length ) {
						CreatePage.track( {
							category: 'page-create-title-modal',
							action: Wikia.Tracker.ACTIONS.IMPRESSION,
							label: 'redlinks'
						} );

						redLinks.on( 'click', function () {
							CreatePage.track( {
								category: 'page-create-title-modal',
								action: Wikia.Tracker.ACTIONS.CLICK,
								label: 'redlink'
							} );
						} );
					}

					createPageModal.bind( 'create', function( event ) {
						event.preventDefault();
						inputChangeTracked = false;
						CreatePage.submitDialog( trackingCategory );
					});

					createPageModal.bind( 'cancel', function( event ) {
						event.stopPropagation();
						CreatePage.track( {
							category: trackingCategory,
							action:  Wikia.Tracker.ACTIONS.CLICK,
							label: 'cancel'
						} );
						createPageModal.trigger( 'close' );
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

					$( '#wpCreatePageDialogTitle' )
						.focus()
						.on( 'change type keypress', function() {
							if ( !inputChangeTracked ) {
								inputChangeTracked = true;

								CreatePage.track( {
									category: trackingCategory,
									action: Wikia.Tracker.ACTIONS.KEYPRESS,
									label: 'title'
								} );
							}
						} );

					// Hide formats if ve is available
					if ( CreatePage.canUseVisualEditor() ) {
						$( '#CreatePageDialogChoose, #CreatePageDialogChoices' ).hide();
					}
					CreatePage.loading = false;
					createPageModal.show();
				});
			});
		});
	},

	submitDialog: function(trackingCategory) {
		'use strict';
		CreatePage.track( { category: trackingCategory, action: Wikia.Tracker.ACTIONS.SUBMIT, label: 'submit' } );
		CreatePage.checkTitle( $( '#wpCreatePageDialogTitle' ).val(), trackingCategory );
	},

	displayError: function( errorMsg, trackingCategory ) {
		'use strict';
		var box = $( '#CreatePageDialogTitleErrorMsg' );
		box.html( '<span id="createPageErrorMsg">' + errorMsg + '</span>' );
		box.find( 'a' ).click( function() {
			CreatePage.track( { category: trackingCategory, action: Wikia.Tracker.ACTIONS.CLICK, label: 'conflict-link' } );
		} );
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
		var title = new mw.Title.newFromText( decodeURIComponent( titleText ) ),
			namespace = title.getNamespacePrefix().replace( ':', '' ),
			visualEditorActive = $( 'html' ).hasClass( 've-activated'),
			redLinkFlowName = CreatePage.getRedLinkFlowName();

		CreatePage.redlinkParam = '&redlink=1';
		CreatePage.flowName = redLinkFlowName;

		if ( CreatePage.canUseVisualEditor() ) {
			CreatePage.track( { category: 'article', action: Wikia.Tracker.ACTIONS.CLICK, label: 've-redlink-click' } );
		}

		if (
			visualEditorActive ||
			mw.config.get( 'wgNamespaceIds' )[ namespace.toLowerCase() ] &&
			window.ContentNamespacesText &&
			window.ContentNamespacesText.indexOf( title[0] ) === -1
		) {
			return false;
		} else {
			CreatePage.requestDialog( e, titleText );
		}
	},

	init: function( context ) {
		'use strict';
		CreatePage.context = context;

		$( '.createpage' ).click(function() {
			CreatePage.trackCreatePageStart(window.wgFlowTrackingFlows.CREATE_PAGE_CONTRIBUTE_BUTTON);
			CreatePage.flowName = window.wgFlowTrackingFlows.CREATE_PAGE_CONTRIBUTE_BUTTON;
		});

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

			$( '#WikiaArticle' ).on( 'click', 'a.new', function( e ) {
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

					if ( ( typeof preloadField.val() === 'undefined' ) || ( preloadField.val() === '' ) ) {
						CreatePage.flowName = window.wgFlowTrackingFlows.CREATE_PAGE_CREATE_BOX;
						CreatePage.requestDialog( e, prefix + field.val() );
					}
					else {
						return true;
					}
				}
			});
		}
	},

	getRedLinkFlowName: function () {
		return mw.config.get('wgNamespaceNumber') === -1
			? window.wgFlowTrackingFlows.CREATE_PAGE_SPECIAL_REDLINK
			: window.wgFlowTrackingFlows.CREATE_PAGE_ARTICLE_REDLINK;
	},

	// create page flow tracking
	trackCreatePageStart: function (flowName) {
		require(['wikia.flowTracking'], function (flowTrack) {
			flowTrack.beginFlow(flowName, {});
		});
	},

	// Tracking for VE dialog only
	track: function( data ) {
		var defaultData;

		// Don't track if category isn't provided. It's a flow that we didn't identify and can affect our numbers
		if ( Wikia.Tracker && data.category ) {
			defaultData = {
				trackingMethod: 'analytics'
			};

			$.extend( defaultData, data );

			Wikia.Tracker.track( defaultData );
		}
	}
};

jQuery(function() {
	'use strict';
	CreatePage.init( window );
});

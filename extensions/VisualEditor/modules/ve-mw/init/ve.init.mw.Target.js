/*!
 * VisualEditor MediaWiki Initialization Target class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global EasyDeflate */

/**
 * Initialization MediaWiki target.
 *
 * @class
 * @extends ve.init.Target
 *
 * @constructor
 * @param {string} pageName Name of target page
 * @param {number} [revisionId] If the editor should load a revision of the page, pass the
 *  revision id here. Defaults to loading the latest version (see #load).
 */
ve.init.mw.Target = function VeInitMwTarget( pageName, revisionId ) {
	// Parent constructor
	ve.init.Target.call( this, { shadow: true, actions: true, floatable: true } );

	var conf = mw.config.get( 'wgVisualEditorConfig' );

	// Properties
	this.pageName = pageName;
	this.pageExists = mw.config.get( 'wgArticleId', 0 ) !== 0;

	// Sometimes we actually don't want to send a useful oldid
	// if we do, PostEdit will give us a 'page restored' message
	this.requestedRevId = revisionId;
	this.revid = revisionId || mw.config.get( 'wgCurRevisionId' );
	this.wikitext = null;

	this.restoring = !!revisionId;
	this.editToken = mw.user.tokens.get( 'editToken' );
	this.submitUrl = ( new mw.Uri( mw.util.getUrl( this.pageName ) ) )
		.extend( { action: 'submit' } );
	this.events = new ve.init.wikia.TargetEvents( this );

	/**
	 * @property {jQuery.Promise|null}
	 */
	this.sanityCheckPromise = null;

	this.modules = [
		'ext.visualEditor.mwcore',
		'ext.visualEditor.mwlink',
		'ext.visualEditor.data',
		'ext.visualEditor.mwreference.core',
		'ext.visualEditor.mwtransclusion.core',
		'ext.visualEditor.mwreference',
		'ext.visualEditor.mwtransclusion'
	]
		//.concat( this.constructor.static.iconModuleStyles )
		.concat( conf.pluginModules || [] );

	this.pluginCallbacks = [];
	this.modulesReady = $.Deferred();
	this.preparedCacheKeyPromise = null;
	this.clearState();
};

/* Inheritance */

OO.inheritClass( ve.init.mw.Target, ve.init.Target );

/* Events */

/**
 * @event editConflict
 */

/**
 * @event save
 * @param {string} html Rendered page HTML from server
 * @param {string} categoriesHtml Rendered categories HTML from server
 * @param {number} [newid] New revision id, undefined if unchanged
 * @param {boolean} isRedirect Whether this page is now a redirect or not.
 */

/**
 * @event showChanges
 * @param {string} diff
 */

/**
 * @event noChanges
 */

/**
 * @event saveAsyncBegin
 * Fired when we're waiting for network
 */

/**
 * @event saveAsyncComplete
 * Fired when we're no longer waiting for network
 */

/**
 * @event saveErrorEmpty
 * Fired when save API returns no data object
 */

/**
 * @event saveErrorSpamBlacklist
 * Fired when save is considered spam or blacklisted
 * @param {Object} editApi
 */

/**
 * @event saveErrorAbuseFilter
 * Fired when AbuseFilter throws warnings
 * @param {Object} editApi
 */

/**
 * @event saveErrorBadToken
 * Fired on save if we have to fetch a new edit token
 *  this is mainly for analytical purposes.
 */

/**
 * @event saveErrorNewUser
 * Fired when user is logged in as a new user
 * @param {string|null} username Name of newly logged-in user, or null if anonymous
 */

/**
 * @event saveErrorCaptcha
 * Fired when saveError indicates captcha field is required
 * @param {Object} editApi
 */

/**
 * @event saveErrorUnknown
 * Fired for any other type of save error
 * @param {Object} editApi
 * @param {Object|null} data API response data
 */

/**
 * @event saveErrorPageDeleted
 * Fired when user tries to save page that was deleted after opening VE
 */

/**
 * @event loadError
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 * @param {Mixed|null} error HTTP status text
 */

/**
 * @event saveError
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 * @param {Object|null} data API response data
 */

/**
 * @event showChangesError
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 * @param {Mixed|null} error HTTP status text
 */

/**
 * @event serializeError
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 * @param {Mixed|null} error HTTP status text
 */

/**
 * @event serializeComplete
 * Fired when serialization is complete
 */

/**
 * @event sanityCheckComplete
 */

/* Static Properties */

ve.init.mw.Target.static.citationToolsLimit = 5;

ve.init.mw.Target.static.toolbarGroups = [
	// History
	{ include: [ 'undo', 'redo' ] },
	// Format
	{
		type: 'menu',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		include: [ { group: 'format' } ],
		promote: [ 'paragraph' ],
		demote: [ 'preformatted', 'blockquote', 'heading1' ]
	},
	// Style
	{
		type: 'list',
		icon: 'text-style',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		include: [ { group: 'textStyle' }, 'language', 'clear' ],
		forceExpand: [ 'bold', 'italic', 'clear' ],
		promote: [ 'bold', 'italic' ],
		demote: [ 'strikethrough', 'code', 'underline', 'language', 'clear' ]
	},
	// Link
	{ include: [ 'link' ] },
	// Cite
	{
		type: 'list',
		label: OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		indicator: 'down',
		include: [ { group: 'cite' }, 'reference', 'reference/existing' ],
		demote: [ 'reference', 'reference/existing' ]
	},
	// Structure
	{
		type: 'list',
		icon: 'bullet-list',
		indicator: 'down',
		include: [ { group: 'structure' } ],
		demote: [ 'outdent', 'indent' ]
	},
	// Insert
	{
		label: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		indicator: 'down',
		include: '*',
		forceExpand: [ 'media', 'transclusion', 'insertTable' ],
		promote: [ 'media', 'transclusion' ],
		demote: [ 'specialcharacter' ]
	},
	// Table
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-table' ),
		type: 'list',
		icon: 'table-insert',
		indicator: 'down',
		include: [ { group: 'table' } ],
		demote: [ 'deleteTable' ]
	}
];

ve.init.mw.Target.static.importRules = {
	external: {
		blacklist: [
			// Annotations
			'link', 'textStyle/span', 'textStyle/underline',
			// Nodes
			'inlineImage', 'blockImage', 'div', 'alienInline', 'alienBlock', 'comment'
		],
		removeHtmlAttributes: true
	},
	all: null
};

/**
 * Defines modules needed to style icons.
 *
 * @static
 * @inheritable
 * @property {string[]} iconModuleStyles Modules that should be loaded to provide the icons
 */
ve.init.mw.Target.static.iconModuleStyles = [
	'ext.visualEditor.icons'
];

/**
 * Name of target class. Used by TargetEvents to identify which target we are tracking.
 *
 * @static
 * @property {string}
 * @inheritable
 */
ve.init.mw.Target.static.name = 'mwTarget';

/**
 * Type of integration. Used by ve.init.mw.trackSubscriber.js for event tracking.
 * @static
 * @property {string}
 * @inheritable
 */
ve.init.mw.Target.static.integrationType = 'page';

/* Static Methods */

/**
 * Send an AJAX request to the MediaWiki API.
 *
 * This method has special behavior for certain options. If the request type is POST, then
 * contentType will default to multipart/form-data. If the content type is multipart/form-data,
 * then the necessary emulation will be performed to make this content type actually work.
 *
 * @param {Object} data Query string parameters (for GET requests) or POST data (for POST requests)
 * @param {Object} [settings] Additional AJAX settings, or overrides of default settings
 * @returns {jqXHR} Return value of $.ajax()
 */
ve.init.mw.Target.static.apiRequest = function ( data, settings ) {
	var key, formData;
	data = ve.extendObject( {
		format: 'json',
		uselang: mw.config.get( 'wgUserLanguage' )
	}, data );
	settings = ve.extendObject( {
		url: mw.util.wikiScript( 'api' ),
		dataType: 'json',
		type: 'GET',
		// Wait up to 100 seconds
		timeout: 100000
	}, settings );

	// If multipart/form-data has been requested and emulation is possible, emulate it
	if (
		settings.type === 'POST' && window.FormData && (
			settings.contentType === undefined ||
			settings.contentType === 'multipart/form-data'
		)
	) {
		formData = new FormData();
		for ( key in data ) {
			formData.append( key, data[key] );
		}
		settings.data = formData;
		// Prevent jQuery from mangling our FormData object
		settings.processData = false;
		// Prevent jQuery from overriding the Content-Type header
		settings.contentType = false;
	} else {
		settings.data = data;
		if ( settings.contentType === 'multipart/form-data' ) {
			// We were asked to emulate but can't, so drop the Content-Type header, otherwise
			// it'll be wrong and the server will fail to decode the POST body
			delete settings.contentType;
		}
	}

	return $.ajax( settings );
};

/**
 * Take a target document with a possibly relative base URL, and modify it to be absolute.
 * The base URL of the target document is resolved using the base URL of the source document.
 * @param {HTMLDocument} targetDoc Document whose base URL should be resolved
 * @param {HTMLDocument} sourceDoc Document whose base URL should be used for resolution
 */
ve.init.mw.Target.static.fixBase = function ( targetDoc, sourceDoc ) {
	var $base;
	if ( !targetDoc.baseURI ) {
		$base = $( 'base', targetDoc );
		if ( $base.length ) {
			// Modify the existing <base> tag
			$base.attr( 'href', ve.resolveUrl( $base.attr( 'href' ), sourceDoc ) );
		} else {
			// No <base> tag, add one
			$base = $( '<base>', targetDoc ).attr( 'href', sourceDoc.baseURI );
			$( 'head', sourceDoc ).append( $base );
		}
	}
};

/**
 * Handle the RL modules for VE and registered plugin modules being loaded.
 *
 * This method is called within the context of a target instance. It executes all registered
 * plugin callbacks, gathers any promises returned and resolves this.modulesReady when all of
 * the gathered promises are resolved.
 */
ve.init.mw.Target.onModulesReady = function () {
	var i, len, callbackResult, promises = [];
	for ( i = 0, len = this.pluginCallbacks.length; i < len; i++ ) {
		callbackResult = this.pluginCallbacks[i]( this );
		if ( callbackResult && callbackResult.then ) { // duck-type jQuery.Promise using .then
			promises.push( callbackResult );
		}
	}
	this.generateCitationFeatures();
	// Dereference the callbacks
	this.pluginCallbacks = [];
	// Add the platform promise to the list
	promises.push( ve.init.platform.getInitializedPromise() );
	// Create a master promise tracking all the promises we got, and wait for it
	// to be resolved
	$.when.apply( $, promises ).done( this.modulesReady.resolve ).fail( this.modulesReady.reject );
};

/**
 * Handle response to a successful load request.
 *
 * This method is called within the context of a target instance. If successful the DOM from the
 * server will be parsed, stored in {this.doc} and then {this.onReady} will be called once modules
 * are ready.
 *
 * @static
 * @method
 * @param {Object} response XHR Response object
 * @param {string} status Text status message
 * @fires loadError
 */
ve.init.mw.Target.onLoad = function ( response ) {
	var data = response ? response.visualeditor : null;

	if ( !data && !response.error ) {
		ve.init.mw.Target.onLoadError.call(
			this, null, 'Invalid response in response from server', null
		);
	} else if ( response.error || data.result === 'error' ) {
		ve.init.mw.Target.onLoadError.call( this, null,
			response.error.code + ': ' + response.error.info,
			null
		);
	} else if ( typeof data.content !== 'string' ) {
		ve.init.mw.Target.onLoadError.call(
			this, null, 'No HTML content in response from server', null
		);
	} else {
		this.originalHtml = data.content;
		this.doc = ve.parseXhtml( this.originalHtml );

		// Parsoid outputs a protocol-relative <base> tag, so absolutize it
		this.constructor.static.fixBase( this.doc, document );

		this.remoteNotices = ve.getObjectValues( data.notices );
		this.protectedClasses = data.protectedClasses;
		this.$checkboxes = $( ve.getObjectValues( data.checkboxes ).join( '' ) );
		// Populate checkboxes with default values for minor and watch
		this.$checkboxes
			.filter( '#wpMinoredit' )
				.prop( 'checked', mw.user.options.get( 'minordefault' ) )
			.end()
			.filter( '#wpWatchthis' )
				.prop( 'checked',
					mw.user.options.get( 'watchdefault' ) ||
					( mw.user.options.get( 'watchcreations' ) && !this.pageExists ) ||
					mw.config.get( 'wgVisualEditor' ).isPageWatched
				);

		this.baseTimeStamp = data.basetimestamp;
		this.startTimeStamp = data.starttimestamp;
		this.revid = data.oldid;

		// Populate link cache
		if ( data.links ) {
			ve.init.platform.linkCache.set( data.links );
		}

		// Everything worked, the page was loaded, continue as soon as the modules are loaded
		this.modulesReady.done( this.onReady.bind( this ) );
	}
};

/**
 * Handle the edit notices being ready for rendering.
 *
 * @method
 */
ve.init.mw.Target.prototype.onNoticesReady = function () {
	var i, len, noticeHtmls, tmp, el;

	// Since we're going to parse them, we might as well save these nodes
	// so we don't have to parse them again later.
	this.editNotices = {};

	/* Don't show notices without visible html (bug 43013). */

	// This is a temporary container for parsed notices in the <body>.
	// We need the elements to be in the DOM in order for stylesheets to apply
	// and jquery.visibleText to determine whether a node is visible.
	tmp = document.createElement( 'div' );

	// The following is essentially display none, but we can't use that
	// since then all descendants will be considered invisible too.
	tmp.style.cssText = 'position: static; top: 0; width: 0; height: 0; border: 0; visibility: hidden;';
	document.body.appendChild( tmp );

	// Merge locally and remotely generated notices
	noticeHtmls = this.remoteNotices.slice();
	for ( i = 0, len = this.localNoticeMessages.length; i < len; i++ ) {
		noticeHtmls.push(
			'<p>' + ve.init.platform.getParsedMessage( this.localNoticeMessages[i] ) + '</p>'
		);
	}

	for ( i = 0, len = noticeHtmls.length; i < len; i++ ) {
		el = $( '<div>' )
			// Public class for usage by third parties to change styling of
			// edit notices within VisualEditor (bug 43013).
			.addClass( 'mw-ve-editNotice' )
			.html( noticeHtmls[i] )
			.get( 0 );

		tmp.appendChild( el );
		if ( $.getVisibleText( el ).trim() !== '' ) {
			this.editNotices[i] = el;
		}
		tmp.removeChild( el );
	}
	document.body.removeChild( tmp );
};

/**
 * Handle both DOM and modules being loaded and ready.
 *
 * @method
 * @fires surfaceReady
 */
ve.init.mw.Target.prototype.onReady = function () {
	// We need to wait until onReady as local notices may require special messages
	this.onNoticesReady();
	this.loading = false;
	this.edited = false;
	this.setupSurface( this.doc, function () {
		this.startSanityCheck();
		this.emit( 'surfaceReady' );
	}.bind( this ) );
};

/**
 * Handle an unsuccessful load request.
 *
 * This method is called within the context of a target instance.
 *
 * @static
 * @method
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Mixed} error HTTP status text
 * @fires loadError
 */
ve.init.mw.Target.onLoadError = function ( jqXHR, status, error ) {
	this.loading = false;
	this.emit( 'loadError', jqXHR, status, error );
};

/**
 * Handle a successful save request.
 *
 * This method is called within the context of a target instance.
 *
 * @static
 * @method
 * @param {HTMLDocument} doc HTML document we tried to save
 * @param {Object} saveData Options that were used
 * @param {Object} response Response data
 * @param {string} status Text status message
 * @fires editConflict
 * @fires save
 */
ve.init.mw.Target.onSave = function ( doc, saveData, response ) {
	this.saving = false;
	var data = response.visualeditoredit;
	if ( !data && !response.error ) {
		this.onSaveError( doc, saveData, null, 'Invalid response from server', response );
	} else if ( response.error ) {
		if ( response.error.code === 'editconflict' ) {
			this.emit( 'editConflict' );
		} else {
			this.onSaveError( doc, saveData, null, 'Save failure', response );
		}
	} else if ( data.result !== 'success' ) {
		// Note, this could be any of db failure, hookabort, badtoken or even a captcha
		this.onSaveError( doc, saveData, null, 'Save failure', response );
	} else if ( typeof data.content !== 'string' ) {
		this.onSaveError( doc, saveData, null, 'Invalid HTML content in response from server', response );
	} else {
		this.emit(
			'save',
			data.content,
			data.categorieshtml,
			data.newrevid,
			data.isRedirect,
			data.displayTitleHtml,
			data.lastModified,
			data.contentSub
		);
	}
};

/**
 * Handle an unsuccessful save request.
 *
 * @method
 * @param {HTMLDocument} doc HTML document we tried to save
 * @param {Object} saveData Options that were used
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Object|null} data API response data
 * @fires saveErrorEmpty
 * @fires saveErrorSpamBlacklist
 * @fires saveErrorAbuseFilter
 * @fires saveErrorBadToken
 * @fires saveErrorNewUser
 * @fires saveErrorCaptcha
 * @fires saveErrorUnknown
 */
ve.init.mw.Target.prototype.onSaveError = function ( doc, saveData, jqXHR, status, data ) {
	var api, editApi,
		target = this;
	this.saving = false;

	// Handle empty response
	if ( !data ) {
		this.emit( 'saveErrorEmpty' );
		return;
	}
	editApi = data && data.visualeditoredit && data.visualeditoredit.edit;

	// Handle spam blacklist error (either from core or from Extension:SpamBlacklist)
	if ( editApi && editApi.spamblacklist ) {
		this.emit( 'saveErrorSpamBlacklist', editApi );
		return;
	}

	// Handle warnings/errors from Extension:AbuseFilter
	// TODO: Move this to a plugin
	if ( editApi && editApi.info && editApi.info.indexOf( 'Hit AbuseFilter:' ) === 0 && editApi.warning ) {
		this.emit( 'saveErrorAbuseFilter', editApi );
		return;
	}

	// Handle token errors
	if ( data.error && data.error.code === 'badtoken' ) {
		api = new mw.Api();
		api.get( {
			// action=query&meta=userinfo and action=tokens&type=edit can't be combined
			// but action=query&meta=userinfo and action=query&prop=info can, however
			// that means we have to give it titles and deal with page ids.
			action: 'query',
			meta: 'userinfo',
			prop: 'info',
			// Try to send the normalised form so that it is less likely we get extra data like
			// data.normalised back that we don't need.
			titles: new mw.Title( target.pageName ).toText(),
			indexpageids: '',
			intoken: 'edit'
		} )
			.always( function () {
				target.emit( 'saveErrorBadToken' );
			} )
			.done( function ( data ) {
				var userMsg,
					userInfo = data.query && data.query.userinfo,
					pageInfo = data.query && data.query.pages && data.query.pageids &&
						data.query.pageids[0] && data.query.pages[ data.query.pageids[0] ],
					editToken = pageInfo && pageInfo.edittoken,
					isAnon = mw.user.anonymous();

				if ( userInfo && editToken ) {
					target.editToken = editToken;

					if (
						( isAnon && userInfo.anon !== undefined ) ||
							// Comparing id instead of name to pretect against possible
							// normalisation and against case where the user got renamed.
							mw.config.get( 'wgUserId' ) === userInfo.id
					) {
						// New session is the same user still
						target.save( doc, saveData );
					} else {
						// The now current session is a different user
						if ( userInfo.anon !== undefined ) {
							// New session is an anonymous user
							mw.config.set( {
								// wgUserId is unset for anonymous users, not set to null
								wgUserId: undefined,
								// wgUserName is explicitly set to null for anonymous users,
								// functions like mw.user.isAnon rely on this.
								wgUserName: null
							} );
							target.emit( 'saveErrorNewUser', null );
						} else {
							// New session is a different user
							mw.config.set( { wgUserId: userInfo.id, wgUserName: userInfo.name } );
							userMsg = 'visualeditor-savedialog-identify-user---' + userInfo.name;
							mw.messages.set(
								userMsg,
								mw.messages.get( 'visualeditor-savedialog-identify-user' )
									.replace( /\$1/g, userInfo.name )
							);
							target.emit( 'saveErrorNewUser', userInfo.name );
						}
					}
				}
			} );
		return;
	} else if ( data.error && data.error.code === 'pagedeleted' ) {
		this.emit( 'saveErrorPageDeleted' );
	}

	// Handle captcha
	// Captcha "errors" usually aren't errors. We simply don't know about them ahead of time,
	// so we save once, then (if required) we get an error with a captcha back and try again after
	// the user solved the captcha.
	// TODO: ConfirmEdit API is horrible, there is no reliable way to know whether it is a "math",
	// "question" or "fancy" type of captcha. They all expose differently named properties in the
	// API for different things in the UI. At this point we only support the SimpleCaptcha and FancyCaptcha
	// which we very intuitively detect by the presence of a "url" property.
	if ( editApi && editApi.captcha && (
		editApi.captcha.type === 'recaptcha' ||
		editApi.captcha.type === 'fancyCaptcha'
	) ) {
		this.emit( 'saveErrorCaptcha', editApi );
		return;
	}

	// Handle (other) unknown and/or unrecoverable errors
	this.emit( 'saveErrorUnknown', editApi, data );
};

/**
 * Handle a successful show changes request.
 *
 * @static
 * @method
 * @param {Object} response API response data
 * @param {string} status Text status message
 * @fires showChanges
 * @fires noChanges
 */
ve.init.mw.Target.onShowChanges = function ( response ) {
	var data = response.visualeditor;
	this.diffing = false;
	if ( !data && !response.error ) {
		ve.init.mw.Target.onShowChangesError.call( this, null, 'Invalid response from server', null );
	} else if ( response.error ) {
		ve.init.mw.Target.onShowChangesError.call(
			this, null, 'Unsuccessful request: ' + response.error.info, null
		);
	} else if ( data.result === 'nochanges' ) {
		this.emit( 'noChanges' );
	} else if ( data.result !== 'success' ) {
		ve.init.mw.Target.onShowChangesError.call( this, null, 'Failed request: ' + data.result, null );
	} else if ( typeof data.diff !== 'string' ) {
		ve.init.mw.Target.onShowChangesError.call(
			this, null, 'Invalid HTML content in response from server', null
		);
	} else {
		this.emit( 'showChanges', data.diff );
	}
};

/**
 * Handle errors during showChanges action.
 *
 * @static
 * @method
 * @this ve.init.mw.Target
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Mixed} error HTTP status text
 * @fires showChangesError
 */
ve.init.mw.Target.onShowChangesError = function ( jqXHR, status, error ) {
	this.diffing = false;
	this.emit( 'showChangesError', jqXHR, status, error );
};

/**
 * Handle a successful serialize request.
 *
 * This method is called within the context of a target instance.
 *
 * @static
 * @method
 * @param {Object} data API response data
 * @param {string} status Text status message
 * @fires serializeComplete
 */
ve.init.mw.Target.onSerialize = function ( response ) {
	this.serializing = false;
	var data = response.visualeditor;
	if ( !data && !response.error ) {
		ve.init.mw.Target.onSerializeError.call( this, null, 'Invalid response from server', null );
	} else if ( response.error ) {
		ve.init.mw.Target.onSerializeError.call(
			this, null, 'Unsuccessful request: ' + response.error.info, null
		);
	} else if ( data.result === 'error' ) {
		ve.init.mw.Target.onSerializeError.call( this, null, 'Server error', null );
	} else if ( typeof data.content !== 'string' ) {
		ve.init.mw.Target.onSerializeError.call(
			this, null, 'No Wikitext content in response from server', null
		);
	} else {
		if ( typeof this.serializeCallback === 'function' ) {
			this.serializeCallback( data.content );
			this.emit( 'serializeComplete' );
			delete this.serializeCallback;
		}
	}
};

/**
 * Handle an unsuccessful serialize request.
 *
 * This method is called within the context of a target instance.
 *
 * @static
 * @method
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 * @param {Mixed|null} error HTTP status text
 * @fires serializeError
 */
ve.init.mw.Target.onSerializeError = function ( jqXHR, status, error ) {
	this.serializing = false;
	this.emit( 'serializeError', jqXHR, status, error );
};

/* Methods */

/**
 * Add reference insertion tools from on-wiki data.
 *
 * By adding a definition in JSON to MediaWiki:Visualeditor-cite-tool-definition, the cite menu can
 * be populated with tools that create refrences containing a specific templates. The content of the
 * definition should be an array containing a series of objects, one for each tool. Each object must
 * contain a `name`, `icon` and `template` property. An optional `title` property can also be used
 * to define the tool title in plain text. The `name` property is a unique identifier for the tool,
 * and also provides a fallback title for the tool by being transformed into a message key. The name
 * is prefixed with `visualeditor-cite-tool-name-`, and messages can be defined on Wiki. Some common
 * messages are pre-defined for tool names such as `web`, `book`, `news` and `journal`.
 *
 * Example:
 * [ { "name": "web", "icon": "cite-web", "template": "Cite web" }, ... ]
 *
 */
ve.init.mw.Target.prototype.generateCitationFeatures = function () {
	var i, len, item, name, data, tool, tools, dialog,
		limit = this.constructor.static.citationToolsLimit;

	if ( !ve.ui.MWCitationDialog ) {
		// Citation module isn't loaded, so skip this
		return;
	}

	/*jshint loopfunc:true */

	try {
		// Must use mw.message to avoid JSON being parsed as Wikitext
		tools = JSON.parse( mw.message( 'visualeditor-cite-tool-definition.json' ).plain() );
	} catch ( e ) { }

	if ( Array.isArray( tools ) ) {
		for ( i = 0, len = Math.min( limit, tools.length ); i < len; i++ ) {
			item = tools[i];
			data = { template: item.template };
			// Generate transclusion tool
			name = 'cite-transclusion-' + item.name;
			tool = function GeneratedMWTransclusionDialogTool( toolbar, config ) {
				ve.ui.MWTransclusionDialogTool.call( this, toolbar, config );
			};
			OO.inheritClass( tool, ve.ui.MWTransclusionDialogTool );
			tool.static.group = 'cite-transclusion';
			tool.static.name = name;
			tool.static.icon = item.icon;
			tool.static.title = item.title;
			tool.static.commandName = name;
			tool.static.template = item.template;
			tool.static.autoAddToCatchall = false;
			tool.static.autoAddToGroup = true;
			ve.ui.toolFactory.register( tool );
			ve.ui.commandRegistry.register(
				new ve.ui.Command(
					name, 'window', 'open',
					{ args: ['transclusion', data], supportedSelections: ['linear'] }
				)
			);
			// Generate citation tool
			name = 'cite-' + item.name;
			tool = function GeneratedMWCitationDialogTool( toolbar, config ) {
				ve.ui.MWCitationDialogTool.call( this, toolbar, config );
			};
			OO.inheritClass( tool, ve.ui.MWCitationDialogTool );
			tool.static.group = 'cite';
			tool.static.name = name;
			tool.static.icon = item.icon;
			tool.static.title = item.title;
			tool.static.commandName = name;
			tool.static.template = item.template;
			tool.static.autoAddToCatchall = false;
			tool.static.autoAddToGroup = true;
			ve.ui.toolFactory.register( tool );
			ve.ui.commandRegistry.register(
				new ve.ui.Command(
					name, 'window', 'open',
					{ args: [name, data], supportedSelections: ['linear'] }
				)
			);
			// Generate dialog
			dialog = function GeneratedMWCitationDialog( config ) {
				ve.ui.MWCitationDialog.call( this, config );
			};
			OO.inheritClass( dialog, ve.ui.MWCitationDialog );
			dialog.static.name = name;
			dialog.static.icon = item.icon;
			dialog.static.title = item.title;
			ve.ui.windowFactory.register( dialog );
		}
	}
};

/**
 * Add a plugin module or callback.
 *
 * @param {string|Function} plugin Plugin module or callback
 */
ve.init.mw.Target.prototype.addPlugin = function ( plugin ) {
	if ( typeof plugin === 'string' ) {
		this.modules.push( plugin );
	} else if ( $.isFunction( plugin ) ) {
		this.pluginCallbacks.push( plugin );
	}
};

/**
 * Add an array of plugins.
 *
 * @see #addPlugin
 * @param {Array} plugins
 */
ve.init.mw.Target.prototype.addPlugins = function ( plugins ) {
	var i, len;
	for ( i = 0, len = plugins.length; i < len; i++ ) {
		this.addPlugin( plugins[i] );
	}
};

/**
 * Get HTML to send to Parsoid. This takes a document generated by the converter and
 * transplants the head tag from the old document into it, as well as the attributes on the
 * html and body tags.
 *
 * @param {HTMLDocument} newDoc Document generated by ve.dm.Converter. Will be modified.
 * @returns {string} Full HTML document
 */
ve.init.mw.Target.prototype.getHtml = function ( newDoc ) {
	var i, len, oldDoc = this.doc;

	function copyAttributes( from, to ) {
		var i, len;
		for ( i = 0, len = from.attributes.length; i < len; i++ ) {
			to.setAttribute( from.attributes[i].name, from.attributes[i].value );
		}
	}

	// Copy the head from the old document
	for ( i = 0, len = oldDoc.head.childNodes.length; i < len; i++ ) {
		newDoc.head.appendChild( oldDoc.head.childNodes[i].cloneNode( true ) );
	}
	// Copy attributes from the old document for the html, head and body
	copyAttributes( oldDoc.documentElement, newDoc.documentElement );
	copyAttributes( oldDoc.head, newDoc.head );
	copyAttributes( oldDoc.body, newDoc.body );
	$( newDoc )
		.remove( 'div[id = myEventWatcherDiv]' ) // Bug 51423
		.remove( 'embed[type = "application/iodbc"]' ) // Bug 51521
		.remove( 'embed[type = "application/x-datavault"]' ) // Bug 52791
		.remove( 'script[id = FoxLingoJs]' ) // Bug 52884
		.remove( 'style[id = _clearly_component__css]' ) // Bug 53252
		.remove( 'div[id = sendToInstapaperResults]' ) // Bug 61776
		.remove( 'embed[id ^= xunlei_com_thunder_helper_plugin]' ) // Bug 63121
		.remove( 'object[type = cosymantecnisbfw], script[id=NortonInternetSecurityBF]' ) // Bug 63229
		.remove( 'div[id = kloutify]' ) // Bug 67006
		.remove( 'div[id ^= mittoHidden]' ); // Bug 68900#c1
	// Add doctype manually
	return '<!doctype html>' + ve.serializeXhtml( newDoc );
};

/**
 * Get DOM data from the Parsoid API.
 *
 * This method performs an asynchronous action and uses a callback function to handle the result.
 *
 * A side-effect of calling this method is that it requests {this.modules} be loaded.
 *
 * @method
 * @param {string[]} [additionalModules=[]] Resource loader modules
 * @returns {boolean} Loading has been started
*/
ve.init.mw.Target.prototype.load = function ( additionalModules ) {
	var data, start, xhr, target = this, uri = new mw.Uri();

	// Prevent duplicate requests
	if ( this.loading ) {
		return false;
	}
	this.events.timings.activationStart = ve.now();
	// Start loading the module immediately
	mw.loader.using(
		// Wait for site and user JS before running plugins
		this.modules.concat( additionalModules || [] ),
		ve.init.mw.Target.onModulesReady.bind( this )
	);

	data = {
		action: 'visualeditor',
		paction: 'parse',
		page: this.pageName
	};

	// Only request the API to explicitly load the currently visible revision if we're restoring
	// from oldid. Otherwise we should load the latest version. This prevents us from editing an
	// old version if an edit was made while the user was viewing the page and/or the user is
	// seeing (slightly) stale cache.
	if ( this.restoring ) {
		data.oldid = this.revid;
	}

	if ( uri.query.preload && mw.config.get( 'wgArticleId' ) === 0 ) {
		data.page = uri.query.preload;
	}

	// Load DOM
	start = ve.now();

	xhr = this.constructor.static.apiRequest( data );
	this.loading = xhr.then(
		function ( data, status, jqxhr ) {
			target.events.track( 'performance.system.domLoad', {
				bytes: $.byteLength( jqxhr.responseText ),
				duration: ve.now() - start,
				cacheHit: /hit/i.test( jqxhr.getResponseHeader( 'X-Cache' ) ),
				parsoid: jqxhr.getResponseHeader( 'X-Parsoid-Performance' )
			} );
			return jqxhr;
		}
	)
		.done( ve.init.mw.Target.onLoad.bind( this ) )
		.fail( ve.init.mw.Target.onLoadError.bind( this ) )
		.promise( { abort: xhr.abort } );

	return true;
};

/**
 * Clear the state of this target, preparing it to be reactivated later.
 */
ve.init.mw.Target.prototype.clearState = function () {
	this.clearPreparedCacheKey();
	this.loading = false;
	this.saving = false;
	this.diffing = false;
	this.serializing = false;
	this.submitting = false;
	this.baseTimeStamp = null;
	this.startTimeStamp = null;
	this.doc = null;
	this.originalHtml = null;
	this.editNotices = null;
	this.$checkboxes = null;
	this.remoteNotices = [];
	this.localNoticeMessages = [];
	this.sanityCheckFinished = false;
	this.sanityCheckVerified = false;
};

/**
 * Serialize the current document and store the result in the serialization cache on the server.
 *
 * This function returns a promise that is resolved once serialization is complete, with the
 * cache key passed as the first parameter.
 *
 * If there's already a request pending for the same (reference-identical) HTMLDocument, this
 * function will not initiate a new request but will return the promise for the pending request.
 * If a request for the same document has already been completed, this function will keep returning
 * the same promise (which will already have been resolved) until clearPreparedCacheKey() is called.
 *
 * @param {HTMLDocument} doc Document to serialize
 * @returns {jQuery.Promise} Abortable promise, resolved with the cache key.
 */
ve.init.mw.Target.prototype.prepareCacheKey = function ( doc ) {
	var xhr, html, start = ve.now(), deferred = $.Deferred(), target = this;

	if ( this.preparedCacheKeyPromise && this.preparedCacheKeyPromise.doc === doc ) {
		return this.preparedCacheKeyPromise;
	}
	this.clearPreparedCacheKey();

	html = EasyDeflate.deflate( this.getHtml( doc ) );

	xhr = this.constructor.static.apiRequest( {
		action: 'visualeditor',
		paction: 'serializeforcache',
		html: html,
		page: this.pageName,
		oldid: this.revid
	}, { type: 'POST' } )
		.done( function ( response ) {
			var trackData = { duration: ve.now() - start };
			if ( response.visualeditor && typeof response.visualeditor.cachekey === 'string' ) {
				target.events.track( 'performance.system.serializeforcache', trackData );
				deferred.resolve( response.visualeditor.cachekey );
			} else {
				target.events.track( 'performance.system.serializeforcache.nocachekey', trackData );
				deferred.reject();
			}
		} )
		.fail( function () {
			target.events.track( 'performance.system.serializeforcache.fail', { duration: ve.now() - start } );
			deferred.reject();
		} );

	this.preparedCacheKeyPromise = deferred.promise( {
		abort: xhr.abort,
		html: html,
		doc: doc
	} );
	return this.preparedCacheKeyPromise;
};

/**
 * Get the prepared wikitext, if any. Same as prepareWikitext() but does not initiate a request
 * if one isn't already pending or finished. Instead, it returns a rejected promise in that case.
 *
 * @param {HTMLDocument} doc Document to serialize
 * @returns {jQuery.Promise} Abortable promise, resolved with the cache key.
 */
ve.init.mw.Target.prototype.getPreparedCacheKey = function ( doc ) {
	var deferred;
	if ( this.preparedCacheKeyPromise && this.preparedCacheKeyPromise.doc === doc ) {
		return this.preparedCacheKeyPromise;
	}
	deferred = $.Deferred();
	deferred.reject();
	return deferred.promise();
};

/**
 * Clear the promise for the prepared wikitext cache key, and abort it if it's still in progress.
 */
ve.init.mw.Target.prototype.clearPreparedCacheKey = function () {
	if ( this.preparedCacheKeyPromise ) {
		this.preparedCacheKeyPromise.abort();
		this.preparedCacheKeyPromise = null;
	}
};

/**
 * Try submitting an API request with a cache key for prepared wikitext, falling back to submitting
 * HTML directly if there is no cache key present or pending, or if the request for the cache key
 * fails, or if using the cache key fails with a badcachekey error.
 *
 * @param {HTMLDocument} doc Document to submit
 * @param {Object} options POST parameters to send. Do not include 'html', 'cachekey' or 'format'.
 * @param {string} [eventName] If set, log an event when the request completes successfully. The
 *  full event name used will be 'performance.system.{eventName}.withCacheKey' or .withoutCacheKey
 *  depending on whether or not a cache key was used.
 * @returns {jQuery.Promise}
 */
ve.init.mw.Target.prototype.tryWithPreparedCacheKey = function ( doc, options, eventName ) {
	var data, preparedCacheKey = this.getPreparedCacheKey( doc ), target = this;
	data = ve.extendObject( {}, options, { format: 'json' } );

	function ajaxRequest( cachekey ) {
		var start = ve.now();
		if ( typeof cachekey === 'string' ) {
			data.cachekey = cachekey;
		} else {
			// Getting a cache key failed, fall back to sending the HTML
			data.html = preparedCacheKey && preparedCacheKey.html || EasyDeflate.deflate( target.getHtml( doc ) );
			// If using the cache key fails, we'll come back here with cachekey still set
			delete data.cachekey;
		}
		return target.constructor.static.apiRequest( data, { type: 'POST' } )
			.then( function ( response, status, jqxhr ) {
				var fullEventName, eventData = {
					bytes: $.byteLength( jqxhr.responseText ),
					duration: ve.now() - start,
					parsoid: jqxhr.getResponseHeader( 'X-Parsoid-Performance' )
				};
				if ( response.error && response.error.code === 'badcachekey' ) {
					// Log the failure if eventName was set
					if ( eventName ) {
						fullEventName = 'performance.system.' + eventName + '.badCacheKey';
						target.events.track( fullEventName, eventData );
					}
					// This cache key is evidently bad, clear it
					target.clearPreparedCacheKey();
					// Try again without a cache key
					return ajaxRequest( null );
				}

				// Log data about the request if eventName was set
				if ( eventName ) {
					fullEventName = 'performance.system.' + eventName +
						( typeof cachekey === 'string' ? '.withCacheKey' : '.withoutCacheKey' );
					target.events.track( fullEventName, eventData );
				}
				return jqxhr;
			} );
	}

	// If we successfully get prepared wikitext, then invoke ajaxRequest() with the cache key,
	// otherwise invoke it without.
	return preparedCacheKey.then( ajaxRequest, ajaxRequest );
};

/**
 * Post DOM data to the Parsoid API.
 *
 * This method performs an asynchronous action and uses a callback function to handle the result.
 *
 *     target.save( dom, { summary: 'test', minor: true, watch: false } );
 *
 * @method
 * @param {HTMLDocument} doc Document to save
 * @param {Object} options Saving options. All keys are passed through, including unrecognized ones.
 *  - {string} summary Edit summary
 *  - {boolean} minor Edit is a minor edit
 *  - {boolean} watch Watch the page
 * @returns {boolean} Saving has been started
*/
ve.init.mw.Target.prototype.save = function ( doc, options ) {
	var data;
	// Prevent duplicate requests
	if ( this.saving ) {
		return false;
	}

	data = ve.extendObject( {}, options, {
		action: 'visualeditoredit',
		page: this.pageName,
		oldid: this.revid,
		basetimestamp: this.baseTimeStamp,
		starttimestamp: this.startTimeStamp,
		token: this.editToken
	} );

	this.saving = this.tryWithPreparedCacheKey( doc, data, 'save' )
		.done( ve.init.mw.Target.onSave.bind( this, doc, data ) )
		.fail( this.onSaveError.bind( this, doc, data ) );

	return true;
};

/**
 * Post DOM data to the Parsoid API to retrieve wikitext diff.
 *
 * @method
 * @param {HTMLDocument} doc Document to compare against (via wikitext)
 * @returns {boolean} Diffing has been started
*/
ve.init.mw.Target.prototype.showChanges = function ( doc ) {
	if ( this.diffing ) {
		return false;
	}
	this.diffing = this.tryWithPreparedCacheKey( doc, {
		action: 'visualeditor',
		paction: 'diff',
		page: this.pageName,
		oldid: this.revid
	}, 'diff' )
		.done( ve.init.mw.Target.onShowChanges.bind( this ) )
		.fail( ve.init.mw.Target.onShowChangesError.bind( this ) );

	return true;
};

/**
 * Post wikitext to MediaWiki.
 *
 * This method performs a synchronous action and will take the user to a new page when complete.
 *
 *     target.submit( wikitext, { wpSummary: 'test', wpMinorEdit: 1, wpSave: 1 } );
 *
 * @method
 * @param {string} wikitext Wikitext to submit
 * @param {Object} fields Other form fields to add (e.g. wpSummary, wpWatchthis, etc.). To actually
 *  save the wikitext, add { wpSave: 1 }. To go to the diff view, add { wpDiff: 1 }.
 * @returns {boolean} Submitting has been started
*/
ve.init.mw.Target.prototype.submit = function ( wikitext, fields ) {
	// Prevent duplicate requests
	if ( this.submitting ) {
		return false;
	}
	// Save DOM
	this.submitting = true;
	var key,
		$form = $( '<form method="post" enctype="multipart/form-data" style="display: none;"></form>' ),
		params = ve.extendObject( {
			format: 'text/x-wiki',
			model: 'wikitext',
			oldid: this.requestedRevId,
			wpStarttime: this.startTimeStamp,
			wpEdittime: this.baseTimeStamp,
			wpTextbox1: wikitext,
			wpEditToken: this.editToken
		}, fields );
	// Add params as hidden fields
	for ( key in params ) {
		$form.append( $( '<input>' ).attr( { type: 'hidden', name: key, value: params[key] } ) );
	}
	// Submit the form, mimicking a traditional edit
	// Firefox requires the form to be attached
	$form.attr( 'action', this.submitUrl ).appendTo( 'body' ).submit();
	return true;
};

/**
 * Get Wikitext data from the Parsoid API.
 *
 * This method performs an asynchronous action and uses a callback function to handle the result.
 *
 *     target.serialize(
 *         dom,
 *         function ( wikitext ) {
 *             // Do something with the loaded DOM
 *         }
 *     );
 *
 * @method
 * @param {HTMLDocument} doc Document to serialize
 * @param {Function} callback Function to call when complete, accepts error and wikitext arguments
 * @returns {boolean} Serializing has been started
*/
ve.init.mw.Target.prototype.serialize = function ( doc, callback ) {
	// Prevent duplicate requests
	if ( this.serializing ) {
		return false;
	}
	this.serializeCallback = callback;
	this.serializing = this.tryWithPreparedCacheKey( doc, {
		action: 'visualeditor',
		paction: 'serialize',
		page: this.pageName,
		oldid: this.revid
	}, 'serialize' )
		.done( ve.init.mw.Target.onSerialize.bind( this ) )
		.fail( ve.init.mw.Target.onSerializeError.bind( this ) );
	return true;
};

/**
 * Get list of edit notices.
 *
 * @returns {Object|null} List of edit notices or null if none are loaded
 */
ve.init.mw.Target.prototype.getEditNotices = function () {
	return this.editNotices;
};

// FIXME: split out view specific functionality, emit to subclass

/**
 * Switch to editing mode.
 *
 * @method
 * @param {HTMLDocument} doc HTML DOM to edit
 * @param {Function} [callback] Callback to call when done
 */
ve.init.mw.Target.prototype.setupSurface = function ( doc, callback ) {
	var target = this;
	setTimeout( function () {
		// Build model
		var dmDoc = ve.dm.converter.getModelFromDom(
			doc,
			null,
			mw.config.get( 'wgVisualEditor' ).pageLanguageCode,
			mw.config.get( 'wgVisualEditor' ).pageLanguageDir
		);
		setTimeout( function () {
			// Create ui.Surface (also creates ce.Surface and dm.Surface and builds CE tree)
			var surface = target.addSurface( dmDoc, { focusMode: true } );
			surface.$element
				.addClass( 've-init-mw-viewPageTarget-surface' )
				.addClass( target.protectedClasses )
				.appendTo( target.$element );
			target.setSurface( surface );

			setTimeout( function () {
				var surfaceView = surface.getView(),
					$documentNode = surfaceView.getDocument().getDocumentNode().$element;

				// Initialize surface
				surface.getContext().toggle( false );

				// Apply mw-body-content to the view (ve-ce-surface).
				// Not to surface (ve-ui-surface), since that contains both the view
				// and the overlay container, and we don't want inspectors to
				// inherit skin typography styles for wikipage content.
				surfaceView.$element.addClass( 'mw-body-content' );
				$documentNode.addClass(
					// Add appropriately mw-content-ltr or mw-content-rtl class
					'mw-content-' + mw.config.get( 'wgVisualEditor' ).pageLanguageDir
				);
				target.active = true;
				// Now that the surface is attached to the document and ready,
				// let it initialize itself
				surface.initialize();
				setTimeout( callback );
			} );
		} );
	} );
};

/**
 * Fire off the sanity check. Must be called before the surface is activated.
 *
 * To access the result, check whether #sanityCheckPromise has been resolved or rejected
 * (it's asynchronous, so it may still be pending when you check).
 *
 * @method
 * @fires sanityCheckComplete
 */
ve.init.mw.Target.prototype.startSanityCheck = function () {
	// We have to get a copy of the data now, before we unlock the surface and let the user edit,
	// but we can defer the actual conversion and comparison
	var target = this,
		doc = this.getSurface().getModel().getDocument(),
		data = new ve.dm.FlatLinearData( doc.getStore().clone(), ve.copy( doc.getFullData() ) ),
		oldDom = this.doc,
		d = $.Deferred();

	// Reset
	this.sanityCheckFinished = false;
	this.sanityCheckVerified = false;

	setTimeout( function () {
		// We can't compare oldDom.body and newDom.body directly, because the attributes on the
		// <body> were ignored in the conversion. So compare each child separately.
		var i,
			len = oldDom.body.childNodes.length,
			newDoc = new ve.dm.Document( data, oldDom, undefined, doc.getInternalList(), doc.getInnerWhitespace(), doc.getLang(), doc.getDir() ),
			newDom = ve.dm.converter.getDomFromModel( newDoc );

		// Explicitly unlink our full copy of the original version of the document data
		data = undefined;

		if ( len !== newDom.body.childNodes.length ) {
			// Different number of children, so they're definitely different
			d.reject();
			return;
		}
		for ( i = 0; i < len; i++ ) {
			if ( !oldDom.body.childNodes[i].isEqualNode( newDom.body.childNodes[i] ) ) {
				d.reject();
				return;
			}
		}
		d.resolve();
	} );

	this.sanityCheckPromise = d.promise()
		.done( function () {
			// If we detect no roundtrip errors,
			// don't emphasize "review changes" to the user.
			target.sanityCheckVerified = true;
		})
		.always( function () {
			target.sanityCheckFinished = true;
			target.emit( 'sanityCheckComplete' );
		} );
};

/**
 * Move the cursor in the editor to section specified by this.section.
 * Do nothing if this.section is undefined.
 *
 * @method
 */
ve.init.mw.Target.prototype.restoreEditSection = function () {
	if ( this.section !== undefined && this.section > 0 ) {
		var surfaceView = this.getSurface().getView(),
			$documentNode = surfaceView.getDocument().getDocumentNode().$element,
			$section = $documentNode.find( 'h1, h2, h3, h4, h5, h6' ).eq( this.section - 1 ),
			headingNode = $section.data( 'view' );

		if ( $section.length && new mw.Uri().query.summary === undefined ) {
			this.initialEditSummary = '/* ' +
				ve.graphemeSafeSubstring( $section.text(), 0, 244 ) + ' */ ';
		}

		if ( headingNode ) {
			this.goToHeading( headingNode );
		}

		this.section = undefined;
	}
};

/**
 * Move the cursor to a given heading and scroll to it.
 *
 * @method
 * @param {ve.ce.HeadingNode} headingNode Heading node to scroll to
 */
ve.init.mw.Target.prototype.goToHeading = function ( headingNode ) {
	var nextNode, offset,
		target = this,
		offsetNode = headingNode,
		surfaceModel = this.getSurface().getView().getModel(),
		lastHeadingLevel = -1;

	// Find next sibling which isn't a heading
	while ( offsetNode instanceof ve.ce.HeadingNode && offsetNode.getModel().getAttribute( 'level' ) > lastHeadingLevel ) {
		lastHeadingLevel = offsetNode.getModel().getAttribute( 'level' );
		// Next sibling
		nextNode = offsetNode.parent.children[ve.indexOf( offsetNode, offsetNode.parent.children ) + 1];
		if ( !nextNode ) {
			break;
		}
		offsetNode = nextNode;
	}
	offset = surfaceModel.getDocument().data.getNearestContentOffset(
		offsetNode.getModel().getOffset(), 1
	);
	// onDocumentFocus is debounced, so wait for that to happen before setting
	// the model selection, otherwise it will get reset
	this.getSurface().getView().once( 'focus', function () {
		surfaceModel.setLinearSelection( new ve.Range( offset ) );
		target.scrollToHeading( headingNode );
	} );
};

/**
 * Scroll to a given heading in the document.
 *
 * @method
 * @param {ve.ce.HeadingNode} headingNode Heading node to scroll to
 */
ve.init.mw.Target.prototype.scrollToHeading = function ( headingNode ) {
	var $window = $( OO.ui.Element.static.getWindow( this.$element ) );

	$window.scrollTop( headingNode.$element.offset().top - this.getToolbar().$element.height() );
};

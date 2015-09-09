/*!
 * VisualEditor MediaWiki Initialization Target class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
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
 * @param {string} [revisionId] If the editor should load a revision of the page, pass the
 *  revision id here. Defaults to loading the latest version (see #load).
 * @param {Object} [config] Configuration options
 */
ve.init.mw.Target = function VeInitMwTarget( pageName, revisionId, config ) {
	config = config || {};
	config.toolbarConfig = $.extend( {
		shadow: true,
		actions: true,
		floatable: true
	}, config.toolbarConfig );

	// Parent constructor
	ve.init.mw.Target.super.call( this, config );

	// Properties
	this.saveDialog = null;
	this.saveDeferred = null;
	this.captcha = null;
	this.docToSave = null;
	this.toolbarSaveButton = null;
	this.pageName = pageName;
	this.pageExists = mw.config.get( 'wgArticleId', 0 ) !== 0;
	this.toolbarScrollOffset = mw.config.get( 'wgVisualEditorToolbarScrollOffset', 0 );

	// Sometimes we actually don't want to send a useful oldid
	// if we do, PostEdit will give us a 'page restored' message
	this.requestedRevId = revisionId;
	this.revid = revisionId || mw.config.get( 'wgCurRevisionId' );

	this.restoring = !!revisionId;
	this.pageDeletedWarning = false;
	this.editToken = mw.user.tokens.get( 'editToken' );
	this.submitUrl = ( new mw.Uri( mw.util.getUrl( this.pageName ) ) )
		.extend( { action: 'submit' } );
	this.events = new ve.init.mw.TargetEvents( this );

	this.preparedCacheKeyPromise = null;
	this.clearState();
	this.generateCitationFeatures();

	// Initialization
	this.$element.addClass( 've-init-mw-target' );

	// Events
	this.connect( this, {
		surfaceReady: 'onSurfaceReady'
	} );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.Target, ve.init.Target );

/* Events */

/**
 * @event editConflict
 */

/**
 * @event save
 */

/**
 * @event showChanges
 */

/**
 * @event noChanges
 */

/**
 * @event saveErrorEmpty
 * Fired when save API returns no data object
 */

/**
 * @event saveErrorSpamBlacklist
 * Fired when save is considered spam or blacklisted
 */

/**
 * @event saveErrorAbuseFilter
 * Fired when AbuseFilter throws warnings
 */

/**
 * @event saveErrorBadToken
 * Fired on save if we have to fetch a new edit token
 *  this is mainly for analytical purposes.
 */

/**
 * @event saveErrorNewUser
 * Fired when user is logged in as a new user
 */

/**
 * @event saveErrorCaptcha
 * Fired when saveError indicates captcha field is required
 */

/**
 * @event saveErrorUnknown
 * Fired for any other type of save error
 */

/**
 * @event saveErrorPageDeleted
 * Fired when user tries to save page that was deleted after opening VE
 */

/**
 * @event saveErrorTitleBlacklist
 * Fired when the user tries to save page in violation of the TitleBlacklist
 */

/**
 * @event loadError
 */

/**
 * @event showChangesError
 */

/**
 * @event serializeError
 */

/**
 * @event serializeComplete
 * Fired when serialization is complete
 */

/* Static Properties */

ve.init.mw.Target.static.citationToolsLimit = 5;

ve.init.mw.Target.static.toolbarGroups = [
	// History
	{ include: [ 'undo', 'redo' ] },
	// Format
	{
		classes: [ 've-test-toolbar-format' ],
		type: 'menu',
		indicator: 'down',
		title: OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		include: [ { group: 'format' } ],
		promote: [ 'paragraph' ],
		demote: [ 'preformatted', 'blockquote', 'heading1' ]
	},
	// Style
	{
		classes: [ 've-test-toolbar-style' ],
		type: 'list',
		icon: 'textStyle',
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
		classes: [ 've-test-toolbar-cite' ],
		type: 'list',
		label: OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		indicator: 'down',
		include: [ { group: 'cite' }, 'reference', 'reference/existing' ],
		demote: [ 'reference', 'reference/existing' ]
	},
	// Structure
	{
		classes: [ 've-test-toolbar-structure' ],
		type: 'list',
		icon: 'listBullet',
		indicator: 'down',
		include: [ { group: 'structure' } ],
		demote: [ 'outdent', 'indent' ]
	},
	// Insert
	{
		classes: [ 've-test-toolbar-insert' ],
		label: OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		indicator: 'down',
		include: '*',
		forceExpand: [ 'media', 'transclusion', 'insertTable' ],
		promote: [ 'media', 'transclusion' ]
	},
	// Table
	{
		header: OO.ui.deferMsg( 'visualeditor-toolbar-table' ),
		type: 'list',
		icon: 'table',
		indicator: 'down',
		include: [ { group: 'table' } ],
		demote: [ 'deleteTable' ]
	},
	// SpecialCharacter
	{ include: [ 'specialCharacter' ] }
];

ve.init.mw.Target.static.importRules = {
	external: {
		blacklist: [
			// Annotations
			'link', 'textStyle/span', 'textStyle/font', 'textStyle/underline', 'meta/language',
			// Nodes
			'div', 'alienInline', 'alienBlock', 'comment'
		],
		removeOriginalDomElements: true
	},
	all: null
};

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
 * Fix the base URL from Parsoid if necessary.
 *
 * Absolutizes the base URL if it's relative, and sets a base URL based on wgArticlePath
 * if there was no base URL at all.
 *
 * @param {HTMLDocument} doc Parsoid document
 */
ve.init.mw.Target.static.fixBase = function ( doc ) {
	ve.fixBase( doc, document, ve.resolveUrl(
		// Don't replace $1 with the page name, because that'll break if
		// the page name contains a slash
		mw.config.get( 'wgArticlePath' ).replace( '$1', '' ),
		document
	) );
};

/* Methods */

/**
 * Handle response to a successful load request.
 *
 * This method is called within the context of a target instance. If successful the DOM from the
 * server will be parsed, stored in {this.doc} and then {this.onReady} will be called.
 *
 * @method
 * @param {Object} response API response data
 * @param {string} status Text status message
 */
ve.init.mw.Target.prototype.loadSuccess = function ( response ) {
	var i, len, linkData, aboutDoc, docRevIdMatches,
		docRevId = 0,
		data = response ? response.visualeditor : null;

	if ( typeof data.content !== 'string' ) {
		this.loadFail( 've-api', 'No HTML content in response from server' );
	} else {
		ve.track( 'trace.parseResponse.enter' );
		this.originalHtml = data.content;
		this.doc = ve.parseXhtml( this.originalHtml );

		// Fix relative or missing base URL if needed
		this.constructor.static.fixBase( this.doc );
		// ve-upstream-sync - review - @author: Inez Korczyński
		// this.remoteNotices = ve.getObjectValues( data.notices );
		this.protectedClasses = data.protectedClasses;

		this.baseTimeStamp = data.basetimestamp;
		this.startTimeStamp = data.starttimestamp;
		this.revid = data.oldid;

		aboutDoc = this.doc.documentElement.getAttribute( 'about' );
		if ( aboutDoc ) {
			docRevIdMatches = aboutDoc.match( /revision\/([0-9]*)$/ );
			if ( docRevIdMatches.length >= 2 ) {
				docRevId = parseInt( docRevIdMatches[ 1 ] );
			}
		}
		if ( docRevId !== this.revid ) {
			if ( this.retriedRevIdConflict ) {
				// Retried already, just error the second time.
				this.loadFail(
					've-api',
					'Revision IDs (doc=' + docRevId + ',api=' + this.revid + ') ' +
						'returned by server do not match'
				);
			} else {
				this.retriedRevIdConflict = true;
				// TODO this retries both requests, in RESTbase mode we should only retry
				// the request that gave us the lower revid
				this.loading = false;
				// HACK: Load with explicit revid to hopefully prevent this from happening again
				if ( !this.requestedRevId ) {
					this.requestedRevId = Math.max( docRevId, this.revid );
				}
				this.load();
			}
			return;
		} else {
			// Set this to false after a successful load, so we don't immediately give up
			// if a subsequent load mismatches again
			this.retriedRevIdConflict = false;
		}

		// Populate link cache
		if ( data.links ) {
			// Format from the API: { missing: [titles], known: 1|[titles] }
			// Format expected by LinkCache: { title: { missing: true|false } }
			linkData = {};
			for ( i = 0, len = data.links.missing.length; i < len; i++ ) {
				linkData[ data.links.missing[ i ] ] = { missing: true };
			}
			if ( data.links.known === 1 ) {
				// Set back to false by onReady()
				ve.init.platform.linkCache.setAssumeExistence( true );
			} else {
				for ( i = 0, len = data.links.known.length; i < len; i++ ) {
					linkData[ data.links.known[ i ] ] = { missing: false };
				}
			}
			ve.init.platform.linkCache.setMissing( linkData );
		}

		ve.track( 'trace.parseResponse.exit' );
		// Everything worked, the page was loaded, continue initializing the editor
		this.onReady();
	}
};

/**
 * Handle both DOM and modules being loaded and ready.
 *
 * @fires surfaceReady
 */
ve.init.mw.Target.prototype.onReady = function () {
	var target = this;

	// We need to wait until onReady as local notices may require special messages
	this.editNotices = this.remoteNotices.concat(
		this.localNoticeMessages.map( function ( msgKey ) {
			return '<p>' + ve.init.platform.getParsedMessage( msgKey ) + '</p>';
		} )
	);

	this.loading = false;
	this.edited = false;
	this.setupSurface( this.doc, function () {
		// loadSuccess() may have called setAssumeExistence( true );
		ve.init.platform.linkCache.setAssumeExistence( false );
		target.getSurface().getModel().connect( target, {
			history: 'updateToolbarSaveButtonState'
		} );
		target.emit( 'surfaceReady' );
	} );
};

/**
 * Once surface is ready ready, init UI
 *
 * @method
 */
ve.init.mw.Target.prototype.onSurfaceReady = function () {
	this.setupToolbarSaveButton();
	this.attachToolbarSaveButton();
	this.restoreEditSection();
};

/**
 * Handle an unsuccessful load request.
 *
 * This method is called within the context of a target instance.
 *
 * @method
 * @param {string} errorTypeText Error type text from mw.Api
 * @param {Object} error Object containing xhr, textStatus and exception keys
 * @fires loadError
 */
ve.init.mw.Target.prototype.loadFail = function () {
	this.loading = false;
	this.emit( 'loadError' );
};

/**
 * Handle a successful save request.
 *
 * This method is called within the context of a target instance.
 *
 * @method
 * @param {HTMLDocument} doc HTML document we tried to save
 * @param {Object} saveData Options that were used
 * @param {Object} response Response data
 * @param {string} status Text status message
 */
ve.init.mw.Target.prototype.saveSuccess = function ( doc, saveData, response ) {
	var data = response.visualeditoredit;
	this.saving = false;
	if ( !data ) {
		this.saveFail( doc, saveData, null, 'Invalid response from server', response );
	} else if ( data.result !== 'success' ) {
		// Note, this could be any of db failure, hookabort, badtoken or even a captcha
		this.saveFail( doc, saveData, null, 'Save failure', response );
	} else if ( typeof data.content !== 'string' ) {
		this.saveFail( doc, saveData, null, 'Invalid HTML content in response from server', response );
	} else {
		this.saveComplete(
			data.content,
			data.categorieshtml,
			data.newrevid,
			data.isRedirect,
			data.displayTitleHtml,
			data.lastModified,
			data.contentSub,
			data.modules,
			data.jsconfigvars
		);
	}
};

/**
 * Handle successful DOM save event.
 *
 * @method
 * @param {string} html Rendered page HTML from server
 * @param {string} categoriesHtml Rendered categories HTML from server
 * @param {number} newid New revision id, undefined if unchanged
 * @param {boolean} isRedirect Whether this page is a redirect or not
 * @param {string} displayTitle What HTML to show as the page title
 * @param {Object} lastModified Object containing user-formatted date
 *  and time strings, or undefined if we made no change.
 * @param {string} contentSub HTML to show as the content subtitle
 * @param {Array} modules The modules to be loaded on the page
 * @param {Object} jsconfigvars The mw.config values needed on the page
 * @fires save
 */
ve.init.mw.Target.prototype.saveComplete = function () {
	this.saveDeferred.resolve();
	this.emit( 'save' );
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
 */
ve.init.mw.Target.prototype.saveFail = function ( doc, saveData, jqXHR, status, data ) {
	var api, editApi,
		target = this;

	this.saving = false;
	this.pageDeletedWarning = false;

	// Handle empty response
	if ( !data ) {
		this.saveErrorEmpty();
		return;
	}

	editApi = data && data.visualeditoredit && data.visualeditoredit.edit;

	// Handle spam blacklist error (either from core or from Extension:SpamBlacklist)
	if ( editApi && editApi.spamblacklist ) {
		this.saveErrorSpamBlacklist( editApi );
		return;
	}

	// Handle warnings/errors from Extension:AbuseFilter
	// TODO: Move this to a plugin
	if ( editApi && editApi.info && editApi.info.indexOf( 'Hit AbuseFilter:' ) === 0 && editApi.warning ) {
		this.saveErrorAbuseFilter( editApi );
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
				target.saveErrorBadToken();
			} )
			.done( function ( data ) {
				var userMsg,
					userInfo = data.query && data.query.userinfo,
					pageInfo = data.query && data.query.pages && data.query.pageids &&
						data.query.pageids[ 0 ] && data.query.pages[ data.query.pageids[ 0 ] ],
					editToken = pageInfo && pageInfo.edittoken,
					isAnon = mw.user.isAnon();

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
							target.saveErrorNewUser( null );
						} else {
							// New session is a different user
							mw.config.set( { wgUserId: userInfo.id, wgUserName: userInfo.name } );
							userMsg = 'visualeditor-savedialog-identify-user---' + userInfo.name;
							mw.messages.set(
								userMsg,
								mw.messages.get( 'visualeditor-savedialog-identify-user' )
									.replace( /\$1/g, userInfo.name )
							);
							target.saveErrorNewUser( userInfo.name );
						}
					}
				}
			} );
		return;
	} else if ( data.error && data.error.code === 'editconflict' ) {
		this.editConflict();
		return;
	} else if ( data.error && data.error.code === 'pagedeleted' ) {
		this.saveErrorPageDeleted();
		return;
	} else if ( data.error && data.error.code === 'titleblacklist-forbidden-edit' ) {
		this.saveErrorTitleBlacklist();
		return;
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
		editApi.captcha.url ||
		editApi.captcha.type === 'simple' ||
		editApi.captcha.type === 'math' ||
		editApi.captcha.type === 'question'
	) ) {
		this.saveErrorCaptcha( editApi );
		return;
	}

	// Handle (other) unknown and/or unrecoverable errors
	this.saveErrorUnknown( editApi, data );
};

/**
 * Handle a successful show changes request.
 *
 * @method
 * @param {Object} response API response data
 * @param {string} status Text status message
 */
ve.init.mw.Target.prototype.showChangesSuccess = function ( response ) {
	var data = response.visualeditor;
	this.diffing = false;
	if ( !data && !response.error ) {
		this.showChangesFail( null, 'Invalid response from server', null );
	} else if ( response.error ) {
		this.showChangesFail(
			null, 'Unsuccessful request: ' + response.error.info, null
		);
	} else if ( data.result === 'nochanges' ) {
		this.noChanges();
	} else if ( data.result !== 'success' ) {
		this.showChangesFail( null, 'Failed request: ' + data.result, null );
	} else if ( typeof data.diff !== 'string' ) {
		this.showChangesFail(
			null, 'Invalid HTML content in response from server', null
		);
	} else {
		this.showChangesDiff( data.diff );
	}
};

/**
 * Show changes diff HTML
 *
 * @param {string} diffHtml Diff HTML
 * @fires showChanges
 */
ve.init.mw.Target.prototype.showChangesDiff = function () {
	this.emit( 'showChanges' );
};

/**
 * Handle errors during showChanges action.
 *
 * @method
 * @this ve.init.mw.Target
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Mixed} error HTTP status text
 * @fires showChangesError
 */
ve.init.mw.Target.prototype.showChangesFail = function () {
	this.diffing = false;
	this.emit( 'showChangesError' );
};

/**
 * Show an save process error message
 *
 * @method
 * @param {string|jQuery|Node[]} msg Message content (string of HTML, jQuery object or array of
 *  Node objects)
 * @param {boolean} [allowReapply=true] Whether or not to allow the user to reapply.
 *  Reset when swapping panels. Assumed to be true unless explicitly set to false.
 * @param {boolean} [warning=false] Whether or not this is a warning.
 */
ve.init.mw.Target.prototype.showSaveError = function ( msg, allowReapply, warning ) {
	this.saveDeferred.reject( [ new OO.ui.Error( msg, { recoverable: allowReapply, warning: warning } ) ] );
};

/**
 * Handle general save error
 *
 * @method
 * @fires saveErrorEmpty
 */
ve.init.mw.Target.prototype.saveErrorEmpty = function () {
	this.showSaveError( ve.msg( 'visualeditor-saveerror', 'Empty server response' ), false /* prevents reapply */ );
	this.emit( 'saveErrorEmpty' );
};

/**
 * Handle spam blacklist error
 *
 * @method
 * @param {Object} editApi
 * @fires saveErrorSpamBlacklist
 */
ve.init.mw.Target.prototype.saveErrorSpamBlacklist = function ( editApi ) {
	this.showSaveError(
		$( $.parseHTML( editApi.sberrorparsed ) ),
		false // prevents reapply
	);
	this.emit( 'saveErrorSpamBlacklist' );
};

/**
 * Handel abuse filter error
 *
 * @method
 * @param {Object} editApi
 * @fires saveErrorAbuseFilter
 */
ve.init.mw.Target.prototype.saveErrorAbuseFilter = function ( editApi ) {
	this.showSaveError( $( $.parseHTML( editApi.warning ) ) );
	// Don't disable the save button. If the action is not disallowed the user may save the
	// edit by pressing Save again. The AbuseFilter API currently has no way to distinguish
	// between filter triggers that are and aren't disallowing the action.
	this.emit( 'saveErrorAbuseFilter' );
};

/**
 * Handle title blacklist save error
 *
 * @method
 * @fires saveErrorTitleBlacklist
 */
ve.init.mw.Target.prototype.saveErrorTitleBlacklist = function () {
	this.showSaveError( mw.msg( 'visualeditor-saveerror-titleblacklist' ) );
	this.emit( 'saveErrorTitleBlacklist' );
};

/**
 * Handle token fetch indicating another user is logged in
 *
 * @method
 * @param {string|null} username Name of newly logged-in user, or null if anonymous
 * @fires saveErrorNewUser
 */
ve.init.mw.Target.prototype.saveErrorNewUser = function ( username ) {
	var badToken, userMsg;
	badToken = document.createTextNode( mw.msg( 'visualeditor-savedialog-error-badtoken' ) + ' ' );
	// mediawiki.jqueryMsg has a bug with [[User:$1|$1]] (bug 51388)
	if ( username === null ) {
		userMsg = 'visualeditor-savedialog-identify-anon';
	} else {
		userMsg = 'visualeditor-savedialog-identify-user---' + username;
	}
	this.showSaveError(
		$( badToken ).add( $.parseHTML( mw.message( userMsg ).parse() ) )
	);
	this.emit( 'saveErrorNewUser' );
};

/**
 * Handle unknown save error
 *
 * @method
 * @param {Object} editApi
 * @param {Object|null} data API response data
 * @fires onSaveErrorUnknown
 */
ve.init.mw.Target.prototype.saveErrorUnknown = function ( editApi, data ) {
	this.showSaveError(
		$( document.createTextNode(
			( editApi && editApi.info ) ||
			( data.error && data.error.info ) ||
			( editApi && editApi.code ) ||
			( data.error && data.error.code ) ||
			'Unknown error'
		) ),
		false // prevents reapply
	);
	this.emit( 'onSaveErrorUnknown' );
};

/**
 * Handle a bad token
 *
 * @method
 * @fires saveErrorBadToken
 */
ve.init.mw.Target.prototype.saveErrorBadToken = function () {
	this.emit( 'saveErrorBadToken' );
};

/**
 * Handle captcha error
 *
 * @method
 * @param {Object} editApi
 * @fires saveErrorCaptcha
 */
ve.init.mw.Target.prototype.saveErrorCaptcha = function ( editApi ) {
	var $captchaDiv = $( '<div>' ),
		$captchaParagraph = $( '<p>' );

	this.captcha = {
		input: new OO.ui.TextInputWidget(),
		id: editApi.captcha.id
	};
	$captchaDiv.append( $captchaParagraph );
	$captchaParagraph.append(
		$( '<strong>' ).text( mw.msg( 'captcha-label' ) ),
		document.createTextNode( mw.msg( 'colon-separator' ) )
	);
	if ( editApi.captcha.url ) { // FancyCaptcha
		mw.loader.load( 'ext.confirmEdit.fancyCaptcha' );
		$captchaParagraph.append(
			$( $.parseHTML( mw.message( 'fancycaptcha-edit' ).parse() ) )
				.filter( 'a' ).attr( 'target', '_blank' ).end()
		);
		$captchaDiv.append(
			$( '<img>' ).attr( 'src', editApi.captcha.url ).addClass( 'fancycaptcha-image' ),
			' ',
			$( '<a>' ).addClass( 'fancycaptcha-reload' ).text( mw.msg( 'fancycaptcha-reload-text' ) )
		);
	} else if ( editApi.captcha.type === 'simple' || editApi.captcha.type === 'math' ) {
		// SimpleCaptcha and MathCaptcha
		$captchaParagraph.append(
			mw.message( 'captcha-edit' ).parse(),
			'<br>',
			document.createTextNode( editApi.captcha.question )
		);
	} else if ( editApi.captcha.type === 'question' ) {
		// QuestyCaptcha
		$captchaParagraph.append(
			mw.message( 'questycaptcha-edit' ).parse(),
			'<br>',
			editApi.captcha.question
		);
	}

	$captchaDiv.append( this.captcha.input.$element );

	// ProcessDialog's error system isn't great for this yet.
	this.saveDialog.clearMessage( 'api-save-error' );
	this.saveDialog.showMessage( 'api-save-error', $captchaDiv );
	this.saveDialog.popPending();

	this.captcha.input.focus();

	this.emit( 'saveErrorCaptcha' );
};

/**
 * Handle page deleted error
 *
 * @method
 * @fires saveErrorPageDeleted
 */
ve.init.mw.Target.prototype.saveErrorPageDeleted = function () {
	this.pageDeletedWarning = true;
	this.showSaveError( mw.msg( 'visualeditor-recreate', mw.msg( 'ooui-dialog-process-continue' ) ), true, true );
	this.emit( 'saveErrorPageDeleted' );
};

/**
 * Handle an edit conflict
 *
 * @method
 * @fires editConflict
 */
ve.init.mw.Target.prototype.editConflict = function () {
	this.emit( 'editConflict' );
};

/**
 * Handle no changes in diff
 *
 * @method
 * @fires noChanges
 */
ve.init.mw.Target.prototype.noChanges = function () {
	this.emit( 'noChanges' );
};

/**
 * Handle a successful serialize request.
 *
 * This method is called within the context of a target instance.
 *
 * @static
 * @method
 * @param {Object} response API response data
 * @param {string} status Text status message
 * @fires serializeComplete
 */
ve.init.mw.Target.prototype.serializeSuccess = function ( response ) {
	var data = response.visualeditor;
	this.serializing = false;
	if ( !data && !response.error ) {
		this.serializeFail( null, 'Invalid response from server', null );
	} else if ( response.error ) {
		this.serializeFail(
			null, 'Unsuccessful request: ' + response.error.info, null
		);
	} else if ( data.result === 'error' ) {
		this.serializeFail( null, 'Server error', null );
	} else if ( typeof data.content !== 'string' ) {
		this.serializeFail(
			null, 'No Wikitext content in response from server', null
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
 * @method
 * @param {jqXHR|null} jqXHR
 * @param {string} status Text status message
 * @param {Mixed|null} error HTTP status text
 * @fires serializeError
 */
ve.init.mw.Target.prototype.serializeFail = function () {
	this.serializing = false;
	this.emit( 'serializeError' );
};

/**
 * Handle clicks on the review button in the save dialog.
 *
 * @method
 * @fires saveReview
 */
ve.init.mw.Target.prototype.onSaveDialogReview = function () {
	if ( !this.saveDialog.$reviewViewer.find( 'table, pre' ).length ) {
		this.emit( 'saveReview' );
		this.saveDialog.getActions().setAbilities( { approve: false } );
		this.saveDialog.pushPending();
		if ( this.pageExists ) {
			// Has no callback, handled via target.showChangesDiff
			this.showChanges( this.docToSave );
		} else {
			this.serialize( this.docToSave, this.onSaveDialogReviewComplete.bind( this ) );
		}
	} else {
		this.saveDialog.swapPanel( 'review' );
	}
};

/**
 * Handle completed serialize request for diff views for new page creations.
 *
 * @method
 * @param {string} wikitext
 */
ve.init.mw.Target.prototype.onSaveDialogReviewComplete = function ( wikitext ) {
	// Invalidate the viewer wikitext on next change
	this.getSurface().getModel().getDocument().once( 'transact',
		this.saveDialog.clearDiff.bind( this.saveDialog )
	);
	this.saveDialog.setDiffAndReview( $( '<pre>' ).text( wikitext ) );
};

/**
 * Handle clicks on the resolve conflict button in the conflict dialog.
 *
 * @method
 */
ve.init.mw.Target.prototype.onSaveDialogResolveConflict = function () {
	// Get Wikitext from the DOM, and set up a submit call when it's done
	this.serialize(
		this.docToSave,
		this.submitWithSaveFields.bind( this, { wpSave: 1 } )
	);
};

/**
 * Handle dialog retry events
 * So we can handle trying to save again after page deletion warnings
 */
ve.init.mw.Target.prototype.onSaveDialogRetry = function () {
	if ( this.pageDeletedWarning ) {
		this.recreating = true;
		this.pageExists = false;
	}
};

/**
 * Handle dialog close events.
 *
 * @fires saveWorkflowEnd
 */
ve.init.mw.Target.prototype.onSaveDialogClose = function () {
	var target = this;

	function clear() {
		target.docToSave = null;
		target.clearPreparedCacheKey();
	}

	// Clear the cached HTML and cache key once the document changes
	if ( this.getSurface() ) {
		this.getSurface().getModel().getDocument().once( 'transact', clear );
	} else {
		clear();
	}

	this.emit( 'saveWorkflowEnd' );
};

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
	var i, len, item, name, data, tool, tools, dialog, contextItem,
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
			item = tools[ i ];
			data = { template: item.template };

			// Generate citation tool
			name = 'cite-' + item.name;
			if ( !ve.ui.toolFactory.lookup( name ) ) {
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
				tool.static.associatedWindows = [ name ];
				ve.ui.toolFactory.register( tool );
				ve.ui.commandRegistry.register(
					new ve.ui.Command(
						name, 'mwcite', 'open', { args: [ name, data ], supportedSelections: [ 'linear' ] }
					)
				);
			}

			// Generate citation context item
			if ( !ve.ui.contextItemFactory.lookup( name ) ) {
				contextItem = function GeneratedMWCitationContextItem( toolbar, config ) {
					ve.ui.MWCitationContextItem.call( this, toolbar, config );
				};
				OO.inheritClass( contextItem, ve.ui.MWCitationContextItem );
				contextItem.static.name = name;
				contextItem.static.icon = item.icon;
				contextItem.static.label = item.title;
				contextItem.static.commandName = name;
				contextItem.static.template = item.template;
				ve.ui.contextItemFactory.register( contextItem );
			}

			// Generate dialog
			if ( !ve.ui.windowFactory.lookup( name ) ) {
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
	}
};

/**
 * Get HTML to send to Parsoid. This takes a document generated by the converter and
 * transplants the head tag from the old document into it, as well as the attributes on the
 * html and body tags.
 *
 * @param {HTMLDocument} newDoc Document generated by ve.dm.Converter. Will be modified.
 * @return {string} Full HTML document
 */
ve.init.mw.Target.prototype.getHtml = function ( newDoc ) {
	var i, len, oldDoc = this.doc;

	function copyAttributes( from, to ) {
		var i, len;
		for ( i = 0, len = from.attributes.length; i < len; i++ ) {
			to.setAttribute( from.attributes[ i ].name, from.attributes[ i ].value );
		}
	}

	// Copy the head from the old document
	for ( i = 0, len = oldDoc.head.childNodes.length; i < len; i++ ) {
		newDoc.head.appendChild( oldDoc.head.childNodes[ i ].cloneNode( true ) );
	}
	// Copy attributes from the old document for the html, head and body
	copyAttributes( oldDoc.documentElement, newDoc.documentElement );
	copyAttributes( oldDoc.head, newDoc.head );
	copyAttributes( oldDoc.body, newDoc.body );
	$( newDoc )
		.find(
			'script, ' + // T54884, T65229, T96533, T103430
			'object, ' + // T65229
			'style, ' + // T55252
			'embed, ' + // T53521, T54791, T65121
			'div[id="myEventWatcherDiv"], ' + // T53423
			'div[id="sendToInstapaperResults"], ' + // T63776
			'div[id="kloutify"], ' + // T69006
			'div[id^="mittoHidden"]' // T70900
		)
		.remove();
	// Add doctype manually
	return '<!doctype html>' + ve.serializeXhtml( newDoc );
};

/**
 * Get deflated HTML. This function is async because easy-deflate may not have finished loading yet.
 *
 * @param {HTMLDocument} newDoc Document to get HTML for
 * @return {jQuery.Promise} Promise resolved with deflated HTML
 * @see #getHtml
 */
ve.init.mw.Target.prototype.deflateHtml = function ( newDoc ) {
	var html = this.getHtml( newDoc );
	return mw.loader.using( 'easy-deflate.deflate' )
		.then( function () {
			return EasyDeflate.deflate( html );
		} );
};

/**
 * Load the editor.
 *
 * This method initiates an API request for the page data unless dataPromise is passed in,
 * in which case it waits for that promise instead.
 *
 * @param {jQuery.Promise} [dataPromise] Promise for pending request, if any
 * @return {boolean} Loading has been started
*/
ve.init.mw.Target.prototype.load = function ( dataPromise ) {
	// Prevent duplicate requests
	if ( this.loading ) {
		return false;
	}
	this.events.trackActivationStart( mw.libs.ve.activationStart );
	mw.libs.ve.activationStart = null;

	this.loading = dataPromise || mw.libs.ve.targetLoader.requestPageData(
		this.pageName,
		this.requestedRevId,
		this.constructor.name
	);
	this.loading
		.done( this.loadSuccess.bind( this ) )
		.fail( this.loadFail.bind( this ) );

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
	this.remoteNotices = [];
	this.localNoticeMessages = [];
};

/**
 * Switch to edit source mode
 *
 * @abstract
 * @method
 */
ve.init.mw.Target.prototype.editSource = null;

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
 * @return {jQuery.Promise} Abortable promise, resolved with the cache key.
 */
ve.init.mw.Target.prototype.prepareCacheKey = function ( doc ) {
	var xhr, deflated,
		aborted = false,
		start = ve.now(),
		target = this;

	if ( this.preparedCacheKeyPromise && this.preparedCacheKeyPromise.doc === doc ) {
		return this.preparedCacheKeyPromise;
	}
	this.clearPreparedCacheKey();

	this.preparedCacheKeyPromise = this.deflateHtml( doc )
		.then( function ( deflatedHtml ) {
			deflated = deflatedHtml;
			if ( aborted ) {
				return $.Deferred().reject();
			}
			xhr = new mw.Api().post(
				{
					action: 'visualeditor',
					paction: 'serializeforcache',
					html: deflatedHtml,
					page: target.pageName,
					oldid: target.revid
				},
				{ contentType: 'multipart/form-data' }
			);
			return xhr.then(
				function ( response ) {
					var trackData = { duration: ve.now() - start };
					if ( response.visualeditor && typeof response.visualeditor.cachekey === 'string' ) {
						target.events.track( 'performance.system.serializeforcache', trackData );
						return response.visualeditor.cachekey;
					} else {
						target.events.track( 'performance.system.serializeforcache.nocachekey', trackData );
						return $.Deferred().reject();
					}
				},
				function () {
					target.events.track( 'performance.system.serializeforcache.fail', { duration: ve.now() - start } );
				}
			);
		} )
		.promise( {
			abort: function () {
				if ( xhr ) {
					xhr.abort();
				}
				aborted = true;
			},
			getDeflatedHtml: function () {
				return deflated;
			},
			doc: doc
		} );
	return this.preparedCacheKeyPromise;
};

/**
 * Get the prepared wikitext, if any. Same as prepareWikitext() but does not initiate a request
 * if one isn't already pending or finished. Instead, it returns a rejected promise in that case.
 *
 * @param {HTMLDocument} doc Document to serialize
 * @return {jQuery.Promise} Abortable promise, resolved with the cache key.
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
 * @return {jQuery.Promise}
 */
ve.init.mw.Target.prototype.tryWithPreparedCacheKey = function ( doc, options, eventName ) {
	var data,
		preparedCacheKey = this.getPreparedCacheKey( doc ),
		target = this;

	data = ve.extendObject( {}, options, { format: 'json' } );

	function ajaxRequest( cachekey, isRetried ) {
		var fullEventName,
			start = ve.now(),
			deflatePromise = $.Deferred().resolve().promise();

		if ( typeof cachekey === 'string' ) {
			data.cachekey = cachekey;
		} else {
			// Getting a cache key failed, fall back to sending the HTML
			data.html = preparedCacheKey && preparedCacheKey.getDeflatedHtml && preparedCacheKey.getDeflatedHtml();
			if ( !data.html ) {
				deflatePromise = target.deflateHtml( doc ).then( function ( deflatedHtml ) {
					data.html = deflatedHtml;
				} );
			}
			// If using the cache key fails, we'll come back here with cachekey still set
			delete data.cachekey;
		}
		return deflatePromise
			.then( function () {
				return new mw.Api().post( data, { contentType: 'multipart/form-data' } );
			} )
			.then(
				function ( response, jqxhr ) {
					var eventData = {
						bytes: $.byteLength( jqxhr.responseText ),
						duration: ve.now() - start
					};

					// Log data about the request if eventName was set
					if ( eventName ) {
						fullEventName = 'performance.system.' + eventName +
							( typeof cachekey === 'string' ? '.withCacheKey' : '.withoutCacheKey' );
						target.events.track( fullEventName, eventData );
					}
					return jqxhr;
				},
				function ( errorName, errorObject ) {
					var eventData;
					if ( errorObject && errorObject.xhr ) {
						eventData = {
							bytes: $.byteLength( errorObject.xhr.responseText ),
							duration: ve.now() - start
						};

						if ( eventName ) {
							if ( errorName === 'badcachekey' ) {
								fullEventName = 'performance.system.' + eventName + '.badCacheKey';
							} else {
								fullEventName = 'performance.system.' + eventName + '.withoutCacheKey';
							}
							target.events.track( fullEventName, eventData );
						}
					}
					// This cache key is evidently bad, clear it
					target.clearPreparedCacheKey();
					if ( !isRetried && errorName === 'badcachekey' ) {
						// Try again without a cache key
						return ajaxRequest( null, true );
					} else {
						// Failed twice in a row, must be some other error - let caller handle it.
						// FIXME Can't just `return this` because all callers are broken.
						return $.Deferred().reject( null, errorName, errorObject ).promise();
					}
				}
			);
	}

	// If we successfully get prepared wikitext, then invoke ajaxRequest() with the cache key,
	// otherwise invoke it without.
	return preparedCacheKey.then( ajaxRequest, ajaxRequest );
};

/**
 * Prepare to save the article
 *
 * @param {jQuery.Deferred} saveDeferred Deferred object to resolve/reject when the save
 *  succeeds/fails.
 * @fires saveInitiated
 */
ve.init.mw.Target.prototype.startSave = function ( saveDeferred ) {
	var saveOptions;

	if ( this.deactivating ) {
		return false;
	}

	saveOptions = this.getSaveOptions();

	// Reset any old captcha data
	if ( this.captcha ) {
		this.saveDialog.clearMessage( 'captcha' );
		delete this.captcha;
	}

	if (
		+mw.user.options.get( 'forceeditsummary' ) &&
		saveOptions.summary === '' &&
		!this.saveDialog.messages.missingsummary
	) {
		this.saveDialog.showMessage(
			'missingsummary',
			// Wrap manually since this core message already includes a bold "Warning:" label
			$( '<p>' ).append( ve.init.platform.getParsedMessage( 'missingsummary' ) ),
			{ wrap: false }
		);
		this.saveDialog.popPending();
	} else {
		this.emit( 'saveInitiated' );
		if ( !this.docToSave ) {
			this.docToSave = this.getSurface().getDom();
		}
		this.save( this.docToSave, saveOptions );
		this.saveDeferred = saveDeferred;
	}
};

/**
 * Get save form fields from the save dialog form.
 *
 * @return {Object} Form data for submission to the MediaWiki action=edit UI
 */
ve.init.mw.Target.prototype.getSaveFields = function () {
	var fields = {
		wpSummary: this.saveDialog ? this.saveDialog.editSummaryInput.getValue() : this.initialEditSummary,
		wpCaptchaId: this.captcha && this.captcha.id,
		wpCaptchaWord: this.captcha && this.captcha.input.getValue()
	};
	if ( this.recreating ) {
		fields.wpRecreate = true;
	}
	return fields;
};

/**
 * Invoke #submit with the data from #getSaveFields
 *
 * @param {Object} fields Fields to add in addition to those from #getSaveFields
 * @param {string} wikitext Wikitext to submit
 * @return {boolean} Whether submission was started
 */
ve.init.mw.Target.prototype.submitWithSaveFields = function ( fields, wikitext ) {
	return this.submit( wikitext, $.extend( this.getSaveFields(), fields ) );
};

/**
 * Get edit API options from the save dialog form.
 *
 * @return {Object} Save options for submission to the MediaWiki API
 */
ve.init.mw.Target.prototype.getSaveOptions = function () {
	var key,
		options = this.getSaveFields(),
		fieldMap = {
			wpSummary: 'summary',
			wpMinoredit: 'minor',
			wpWatchthis: 'watch',
			wpCaptchaId: 'captchaid',
			wpCaptchaWord: 'captchaword'
		};

	for ( key in fieldMap ) {
		if ( options[ key ] !== undefined ) {
			options[ fieldMap[ key ] ] = options[ key ];
			delete options[ key ];
		}
	}

	return options;
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
 * @return {boolean} Saving has been started
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
		.done( this.saveSuccess.bind( this, doc, data ) )
		.fail( this.saveFail.bind( this, doc, data ) );

	return true;
};

/**
 * Post DOM data to the Parsoid API to retrieve wikitext diff.
 *
 * @method
 * @param {HTMLDocument} doc Document to compare against (via wikitext)
 * @return {boolean} Diffing has been started
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
		.done( this.showChangesSuccess.bind( this ) )
		.fail( this.showChangesFail.bind( this ) );

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
 * @return {boolean} Submitting has been started
*/
ve.init.mw.Target.prototype.submit = function ( wikitext, fields ) {
	var key, $form, params;

	// Prevent duplicate requests
	if ( this.submitting ) {
		return false;
	}
	// Save DOM
	this.submitting = true;
	$form = $( '<form method="post" enctype="multipart/form-data" style="display: none;"></form>' );
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
		$form.append( $( '<input>' ).attr( { type: 'hidden', name: key, value: params[ key ] } ) );
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
 * @return {boolean} Serializing has been started
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
		.done( ve.init.mw.Target.prototype.serializeSuccess.bind( this ) )
		.fail( ve.init.mw.Target.prototype.serializeFail.bind( this ) );
	return true;
};

/**
 * Get list of edit notices.
 *
 * @return {Object|null} List of edit notices or null if none are loaded
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
		var dmDoc;
		ve.track( 'trace.convertModelFromDom.enter' );
		dmDoc = ve.dm.converter.getModelFromDom( doc, {
			lang: mw.config.get( 'wgVisualEditor' ).pageLanguageCode,
			dir: mw.config.get( 'wgVisualEditor' ).pageLanguageDir
		} );
		ve.track( 'trace.convertModelFromDom.exit' );
		// Build DM tree now (otherwise it gets lazily built when building the CE tree)
		ve.track( 'trace.buildModelTree.enter' );
		dmDoc.buildNodeTree();
		ve.track( 'trace.buildModelTree.exit' );
		setTimeout( function () {
			var surface, surfaceView, $documentNode;
			// Clear dummy surfaces
			target.clearSurfaces();

			// Create ui.Surface (also creates ce.Surface and dm.Surface and builds CE tree)
			ve.track( 'trace.createSurface.enter' );
			surface = target.addSurface( dmDoc );
			surfaceView = surface.getView();
			$documentNode = surfaceView.getDocument().getDocumentNode().$element;
			ve.track( 'trace.createSurface.exit' );

			surface.$element
				.addClass( 've-init-mw-target-surface' )
				.addClass( target.protectedClasses )
				.appendTo( target.$element );

			// Apply mw-body-content to the view (ve-ce-surface).
			// Not to surface (ve-ui-surface), since that contains both the view
			// and the overlay container, and we don't want inspectors to
			// inherit skin typography styles for wikipage content.
			surfaceView.$element.addClass( 'mw-body-content' );
			surface.$placeholder.addClass( 'mw-body-content' );
			$documentNode.addClass(
				// Add appropriately mw-content-ltr or mw-content-rtl class
				'mw-content-' + mw.config.get( 'wgVisualEditor' ).pageLanguageDir
			);

			target.setSurface( surface );

			setTimeout( function () {
				// Initialize surface
				ve.track( 'trace.initializeSurface.enter' );
				surface.getContext().toggle( false );

				target.active = true;
				// Now that the surface is attached to the document and ready,
				// let it initialize itself
				surface.initialize();
				ve.track( 'trace.initializeSurface.exit' );
				setTimeout( callback );
			} );
		} );
	} );
};

/**
 * Add content and event bindings to toolbar save button.
 *
 * @param {Object} [config] Configuration options for the button
 */
ve.init.mw.Target.prototype.setupToolbarSaveButton = function ( config ) {
	this.toolbarSaveButton = new OO.ui.ButtonWidget( ve.extendObject( {
		label: ve.msg( 'visualeditor-toolbar-savedialog' ),
		flags: [ 'progressive', 'primary' ],
		disabled: !this.restoring
	}, config ) );

	// NOTE (phuedx, 2014-08-20): This class is used by the firsteditve guided
	// tour to attach a guider to the "Save page" button.
	this.toolbarSaveButton.$element.addClass( 've-ui-toolbar-saveButton' );

	if ( ve.msg( 'accesskey-save' ) !== '-' && ve.msg( 'accesskey-save' ) !== '' ) {
		// FlaggedRevs tries to use this - it's useless on VE pages because all that stuff gets hidden, but it will still conflict so get rid of it
		this.elementsThatHadOurAccessKey = $( '[accesskey="' + ve.msg( 'accesskey-save' ) + '"]' ).removeAttr( 'accesskey' );
		this.toolbarSaveButton.$button.attr( 'accesskey', ve.msg( 'accesskey-save' ) );
	}

	this.updateToolbarSaveButtonState();

	this.toolbarSaveButton.connect( this, { click: 'onToolbarSaveButtonClick' } );
};

/**
 * Add the save button to the user interface.
 */
ve.init.mw.Target.prototype.attachToolbarSaveButton = function () {
	this.toolbar.$actions.append( this.toolbarSaveButton.$element );
};

/**
 * Re-evaluate whether the toolbar save button should be disabled or not.
 */
ve.init.mw.Target.prototype.updateToolbarSaveButtonState = function () {
	var isDisabled;

	this.edited = this.getSurface().getModel().hasBeenModified();
	// Disable the save button if we have no history
	isDisabled = !this.edited && !this.restoring;
	this.toolbarSaveButton.setDisabled( isDisabled );
	mw.hook( 've.toolbarSaveButton.stateChanged' ).fire( isDisabled );
};

/**
 * Handle clicks on the save button in the toolbar.
 */
ve.init.mw.Target.prototype.onToolbarSaveButtonClick = function () {
	if ( this.edited || this.restoring ) {
		this.showSaveDialog();
	}
};

/**
 * Show a save dialog
 *
 * @fires saveWorkflowBegin
 */
ve.init.mw.Target.prototype.showSaveDialog = function () {
	var target = this;
	this.emit( 'saveWorkflowBegin' );

	// Preload the serialization
	if ( !this.docToSave ) {
		this.docToSave = this.getSurface().getDom();
	}
	this.prepareCacheKey( this.docToSave );

	// Connect events to save dialog
	this.getSurface().getDialogs().getWindow( 'mwSave' ).done( function ( win ) {
		if ( !target.saveDialog ) {
			target.saveDialog = win;

			// Connect to save dialog
			target.saveDialog.connect( target, {
				save: 'startSave',
				review: 'onSaveDialogReview',
				resolve: 'onSaveDialogResolveConflict',
				retry: 'onSaveDialogRetry',
				close: 'onSaveDialogClose'
			} );
		}
	} );

	this.openSaveDialog();
};

/**
 * Open the save dialog
 */
ve.init.mw.Target.prototype.openSaveDialog = function () {
	var windowAction = ve.ui.actionFactory.create( 'window', this.getSurface() );

	// Open the dialog
	windowAction.open( 'mwSave', { target: this } );
};

/**
 * Move the cursor in the editor to section specified by this.section.
 * Do nothing if this.section is undefined.
 *
 * @method
 */
ve.init.mw.Target.prototype.restoreEditSection = function () {
	var surfaceView, $documentNode, $section, headingNode;

	if ( this.section !== undefined && this.section > 0 ) {
		surfaceView = this.getSurface().getView();
		$documentNode = surfaceView.getDocument().getDocumentNode().$element;
		$section = $documentNode.find( 'h1, h2, h3, h4, h5, h6' ).eq( this.section - 1 );
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
		surface = this.getSurface(),
		surfaceModel = surface.getModel(),
		surfaceView = surface.getView(),
		lastHeadingLevel = -1;

	// Find next sibling which isn't a heading
	while ( offsetNode instanceof ve.ce.HeadingNode && offsetNode.getModel().getAttribute( 'level' ) > lastHeadingLevel ) {
		lastHeadingLevel = offsetNode.getModel().getAttribute( 'level' );
		// Next sibling
		nextNode = offsetNode.parent.children[ offsetNode.parent.children.indexOf( offsetNode ) + 1 ];
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
	surfaceView.once( 'focus', function () {
		surfaceModel.setLinearSelection( new ve.Range( offset ) );
		// Focussing the document triggers showSelection which calls scrollIntoView
		// which uses a jQuery animation, so make sure this is aborted.
		$( OO.ui.Element.static.getClosestScrollableContainer( surfaceView.$element[ 0 ] ) ).stop( true );
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

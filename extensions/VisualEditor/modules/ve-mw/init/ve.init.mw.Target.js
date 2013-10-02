/*!
 * VisualEditor MediaWiki Initialization Target class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Initialization MediaWiki target.
 *
 * @class
 * @extends ve.init.Target
 *
 * @constructor
 * @param {jQuery} $container Conainter to render target into
 * @param {string} pageName Name of target page
 * @param {number} [revisionId] If the editor should load a revision of the page, pass the
 *  revision id here. Defaults to loading the latest version (see #load).
 */
ve.init.mw.Target = function VeInitMwTarget( $container, pageName, revisionId ) {
	var conf = mw.config.get( 'wgVisualEditorConfig' );

	// Parent constructor
	ve.init.Target.call( this, $container );

	// Properties
	this.pageName = pageName;
	this.pageExists = mw.config.get( 'wgArticleId', 0 ) !== 0;
	this.revid = revisionId || mw.config.get( 'wgCurRevisionId' );
	this.restoring = !!revisionId;
	this.editToken = mw.user.tokens.get( 'editToken' );
	this.apiUrl = mw.util.wikiScript( 'api' );
	this.submitUrl = ( new mw.Uri( mw.util.wikiGetlink( this.pageName ) ) )
		.extend( { 'action': 'submit' } );
	this.modules = [
			( mw.config.get( 'wgUserName' ) === null ?
				conf.defaultUserOptions.experimental :
				mw.user.options.get( 'visualeditor-enable-experimental', conf.defaultUserOptions.experimental ) ) ?
				'ext.visualEditor.experimental' : 'ext.visualEditor.core',
			'ext.visualEditor.data'
		]
		.concat(
			document.createElementNS && document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' ).createSVGRect ?
				['ext.visualEditor.viewPageTarget.icons-vector', 'ext.visualEditor.icons-vector'] :
				['ext.visualEditor.viewPageTarget.icons-raster', 'ext.visualEditor.icons-raster']
		)
		.concat( mw.config.get( 'wgVisualEditorConfig' ).pluginModules || [] );
	this.pluginCallbacks = [];
	this.modulesReady = $.Deferred();
	this.loading = false;
	this.saving = false;
	this.serializing = false;
	this.submitting = false;
	this.baseTimeStamp = null;
	this.startTimeStamp = null;
	this.doc = null;
	this.editNotices = null;
	this.checkboxes = null;
	this.remoteNotices = [];
	this.localNoticeMessages = [];
	this.isMobileDevice = (
		'ontouchstart' in window ||
			( window.DocumentTouch && document instanceof window.DocumentTouch )
	);
};

/**
 * @event load
 * @param {HTMLDocument} dom
 */

/**
 * @event editConflict
 */

/**
 * @event save
 * @param {string} html
 */

/**
 * @event showChanges
 * @param {string} diff
 */

/**
 * @event noChanges
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

/* Inheritance */

ve.inheritClass( ve.init.mw.Target, ve.init.Target );

/* Static Methods */

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
	// Dereference the callbacks
	this.pluginCallbacks = [];
	// Create a master promise tracking all the promises we got, and wait for it
	// to be resolved
	$.when.apply( $, promises ).done( this.modulesReady.resolve ).fail( this.modulesReady.reject );
};

/**
 * Handle response to a successful load request.
 *
 * This method is called within the context of a target instance. If successful the DOM from the
 * server will be parsed, stored in {this.doc} and then {ve.init.mw.Target.onReady} will be called once
 * the modules are ready.
 *
 * @static
 * @method
 * @param {Object} response XHR Response object
 * @param {string} status Text status message
 * @emits loadError
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
		this.doc = ve.createDocumentFromHtml( this.originalHtml );

		this.remoteNotices = ve.getObjectValues( data.notices );
		this.checkboxes = data.checkboxes;

		this.baseTimeStamp = data.basetimestamp;
		this.startTimeStamp = data.starttimestamp;
		this.revid = data.oldid;
		// Everything worked, the page was loaded, continue as soon as the modules are loaded
		this.modulesReady.done( ve.bind( ve.init.mw.Target.onReady, this ) );
	}
};

/**
 * Handle the edit notices being ready for rendering.
 *
 * @static
 * @method
 */
ve.init.mw.Target.onNoticesReady = function () {
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
			.addClass( 've-init-mw-viewPageTarget-toolbar-editNotices-notice' )
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
 * This method is called within the context of a target instance.
 *
 * @static
 * @method
 * @emits load
 */
ve.init.mw.Target.onReady = function () {
	// We need to wait until onReady as local notices may require special messages
	ve.init.mw.Target.onNoticesReady.call( this );

	this.loading = false;
	this.emit( 'load', this.doc );
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
 * @emits loadError
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
 * @param {Object} response Response data
 * @param {string} status Text status message
 * @emits editConflict
 * @emits save
 */
ve.init.mw.Target.onSave = function ( response ) {
	this.saving = false;
	var data = response.visualeditoredit;
	if ( !data && !response.error ) {
		ve.init.mw.Target.onSaveError.call( this, null, 'Invalid response from server', response );
	} else if ( response.error ) {
		if ( response.error.code === 'editconflict' ) {
			this.emit( 'editConflict' );
		} else {
			ve.init.mw.Target.onSaveError.call( this, null, 'Save failure', response );
		}
	} else if ( data.result !== 'success' ) {
		// Note, this could be any of db failure, hookabort, badtoken or even a captcha
		ve.init.mw.Target.onSaveError.call( this, null, 'Save failure', response );
	} else if ( typeof data.content !== 'string' ) {
		ve.init.mw.Target.onSaveError.call(
			this,
			null,
			'Invalid HTML content in response from server',
			response
		);
	} else {
		this.emit( 'save', data.content, data.newrevid );
	}
};

/**
 * Handle an unsuccessful save request.
 *
 * @static
 * @method
 * @this ve.init.mw.Target
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Object|null} data API response data
 * @emits saveError
 */
ve.init.mw.Target.onSaveError = function ( jqXHR, status, data ) {
	this.saving = false;
	this.emit( 'saveError', jqXHR, status, data );
};


/**
 * Handle a successful show changes request.
 *
 * @static
 * @method
 * @param {Object} response API response data
 * @param {string} status Text status message
 * @emits showChanges
 * @emits noChanges
 */
ve.init.mw.Target.onShowChanges = function ( response ) {
	var data = response.visualeditor;
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
 * Handle errors during saveChanges action.
 *
 * @static
 * @method
 * @this ve.init.mw.Target
 * @param {Object} jqXHR
 * @param {string} status Text status message
 * @param {Mixed} error HTTP status text
 * @emits showChangesError
 */
ve.init.mw.Target.onShowChangesError = function ( jqXHR, status, error ) {
	this.saving = false;
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
 * @emits serializeError
 */
ve.init.mw.Target.onSerializeError = function ( jqXHR, status, error ) {
	this.serializing = false;
	this.emit( 'serializeError', jqXHR, status, error );
};

/* Methods */

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
	return '<!doctype html>' + ve.properOuterHtml( newDoc.documentElement );
};

/**
 * Get DOM data from the Parsoid API.
 *
 * This method performs an asynchronous action and uses a callback function to handle the result.
 *
 * A side-effect of calling this method is that it requests {this.modules} be loaded.
 *
 * @method
 * @returns {boolean} Loading has been started
*/
ve.init.mw.Target.prototype.load = function () {
	var data;
	// Prevent duplicate requests
	if ( this.loading ) {
		return false;
	}
	// Start loading the module immediately
	mw.loader.using(
		// Wait for site and user JS before running plugins
		this.modules.concat( [ 'site', 'user' ] ),
		ve.bind( ve.init.mw.Target.onModulesReady, this )
	);

	data = {
		'action': 'visualeditor',
		'paction': 'parse',
		'page': this.pageName,
		'format': 'json'
	};

	// Only request the API to explicitly load the currently visible revision if we're restoring
	// from oldid. Otherwise we should load the latest version. This prevents us from editing an
	// old version if an edit was made while the user was viewing the page and/or the user is
	// seeing (slightly) stale cache.
	if ( this.restoring ) {
		data.oldid = this.revid;
	}

	// Load DOM
	this.loading = $.ajax( {
		'url': this.apiUrl,
		'data': data,
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'cache': 'false',
		'success': ve.bind( ve.init.mw.Target.onLoad, this ),
		'error': ve.bind( ve.init.mw.Target.onLoadError, this )
	} );
	return true;
};

/**
 * Post DOM data to the Parsoid API.
 *
 * This method performs an asynchronous action and uses a callback function to handle the result.
 *
 *     target.save( dom, { 'summary': 'test', 'minor': true, 'watch': false } );
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
	// Prevent duplicate requests
	if ( this.saving ) {
		return false;
	}

	var data = $.extend( {}, options, {
		'format': 'json',
		'action': 'visualeditoredit',
		'page': this.pageName,
		'oldid': this.revid,
		'basetimestamp': this.baseTimeStamp,
		'starttimestamp': this.startTimeStamp,
		'html': this.getHtml( doc ),
		'token': this.editToken
	} );

	// Save DOM
	this.saving = true;
	$.ajax( {
		'url': this.apiUrl,
		'data': data,
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'success': ve.bind( ve.init.mw.Target.onSave, this ),
		'error': ve.bind( ve.init.mw.Target.onSaveError, this )
	} );
	return true;
};

/**
 * Post DOM data to the Parsoid API to retreive wikitext diff.
 *
 * @method
 * @param {HTMLDocument} doc Document to compare against (via wikitext)
*/
ve.init.mw.Target.prototype.showChanges = function ( doc ) {
	$.ajax( {
		'url': this.apiUrl,
		'data': {
			'format': 'json',
			'action': 'visualeditor',
			'paction': 'diff',
			'page': this.pageName,
			'oldid': this.revid,
			'html': this.getHtml( doc )
		},
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'success': ve.bind( ve.init.mw.Target.onShowChanges, this ),
		'error': ve.bind( ve.init.mw.Target.onShowChangesError, this )
	} );
};

/**
 * Post DOM data to the Parsoid API.
 *
 * This method performs a synchronous action and will take the user to a new page when complete.
 *
 *     target.submit( wikitext, { 'summary': 'test', 'minor': true, 'watch': false } );
 *
 * @method
 * @param {string} wikitext Wikitext to submit
 * @param {Object} options Saving options
 *  - {string} summary Edit summary
 *  - {boolean} minor Edit is a minor edit
 *  - {boolean} watch Watch the page
 * @returns {boolean} Submitting has been started
*/
ve.init.mw.Target.prototype.submit = function ( wikitext, options ) {
	// Prevent duplicate requests
	if ( this.submitting ) {
		return false;
	}
	// Save DOM
	this.submitting = true;
	var key,
		$form = $( '<form method="post" enctype="multipart/form-data"></form>' ),
		params = {
			'format': 'text/x-wiki',
			'oldid': this.revid,
			'wpStarttime': this.baseTimeStamp,
			'wpEdittime': this.startTimeStamp,
			'wpTextbox1': wikitext,
			'wpSummary': options.summary,
			'wpWatchthis': Number( options.watch ),
			'wpMinoredit': Number( options.minor ),
			'wpEditToken': this.editToken,
			'wpSave': 1
		};
	// Add params as hidden fields
	for ( key in params ) {
		$form.append( $( '<input type="hidden">' ).attr( { 'name': key, 'value': params[key] } ) );
	}
	// Submit the form, mimicking a traditional edit
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
 * @returns {boolean} Serializing has beeen started
*/
ve.init.mw.Target.prototype.serialize = function ( doc, callback ) {
	// Prevent duplicate requests
	if ( this.serializing ) {
		return false;
	}
	// Load DOM
	this.serializing = true;
	this.serializeCallback = callback;
	$.ajax( {
		'url': this.apiUrl,
		'data': {
			'action': 'visualeditor',
			'paction': 'serialize',
			'html': this.getHtml( doc ),
			'page': this.pageName,
			'oldid': this.revid,
			'format': 'json'
		},
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'cache': 'false',
		'success': ve.bind( ve.init.mw.Target.onSerialize, this ),
		'error': ve.bind( ve.init.mw.Target.onSerializeError, this )
	} );
	return true;
};

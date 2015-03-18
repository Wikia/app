/*!
 * VisualEditor MediaWiki Initialization class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Initialization MediaWiki Target Analytics.
 *
 * @class
 *
 * @constructor
 * @param {ve.init.mw.Target} target Target class to log events for
 */
ve.init.mw.TargetEvents = function ( target ) {
	this.target = target;
	this.timings = { saveRetries: 0 };
	// Events
	this.target.connect( this, {
		saveWorkflowBegin: 'onSaveWorkflowBegin',
		saveWorkflowEnd: 'onSaveWorkflowEnd',
		saveInitiated: 'onSaveInitated',
		save: 'onSaveComplete',
		saveReview: 'onSaveReview',
		saveErrorEmpty: [ 'trackSaveError', 'empty' ],
		saveErrorSpamBlacklist: [ 'trackSaveError', 'spamblacklist' ],
		saveErrorAbuseFilter: [ 'trackSaveError', 'abusefilter' ],
		saveErrorBadToken: [ 'trackSaveError', 'badtoken' ],
		saveErrorNewUser: [ 'trackSaveError', 'newuser' ],
		saveErrorPageDeleted: [ 'trackSaveError', 'pagedeleted' ],
		saveErrorCaptcha: [ 'trackSaveError', 'captcha' ],
		saveErrorUnknown: [ 'trackSaveError', 'unknown' ],
		editConflict: [ 'trackSaveError', 'editconflict' ],
		surfaceReady: 'onSurfaceReady',
		showChanges: 'onShowChanges',
		showChangesError: 'onShowChangesError',
		noChanges: 'onNoChanges',
		serializeComplete: 'onSerializeComplete',
		serializeError: 'onSerializeError'
	} );
};

/**
 * Target specific ve.track wrapper
 *
 * @param {string} topic Event name
 * @param {Object} data Additional data describing the event, encoded as an object
 */
ve.init.mw.TargetEvents.prototype.track = function ( topic, data ) {
	data.targetName = this.target.constructor.static.name;
	ve.track( 'mwtiming.' + topic, data );

	if ( topic.indexOf( 'performance.system.serializeforcache' ) === 0 ) {
		// HACK: track serializeForCache duration here, because there's no event for that
		this.timings.serializeForCache = data.duration;
	}
};

/**
 * Track when user begins the save workflow
 */
ve.init.mw.TargetEvents.prototype.onSaveWorkflowBegin = function () {
	this.timings.saveWorkflowBegin = ve.now();
	this.track( 'behavior.lastTransactionTillSaveDialogOpen', {
		duration: this.timings.saveWorkflowBegin - this.timings.lastTransaction
	} );
	ve.track( 'mwedit.saveIntent' );
};

/**
 * Track when user ends the save workflow
 */
ve.init.mw.TargetEvents.prototype.onSaveWorkflowEnd = function () {
	this.track( 'behavior.saveDialogClose', { duration: ve.now() - this.timings.saveWorkflowBegin } );
	this.timings.saveWorkflowBegin = null;
};

/**
 * Track when document save is initiated
 */
ve.init.mw.TargetEvents.prototype.onSaveInitated = function () {
	this.timings.saveInitiated = ve.now();
	this.timings.saveRetries++;
	this.track( 'behavior.saveDialogOpenTillSave', {
		duration: this.timings.saveInitiated - this.timings.saveWorkflowBegin
	} );
	ve.track( 'mwedit.saveAttempt' );
};

/**
 * Track when the save is complete
 * @param {string} content
 * @param {string} categoriesHtml
 * @param {number} newRevId
 */
ve.init.mw.TargetEvents.prototype.onSaveComplete = function ( content, categoriesHtml, newRevId ) {
	this.track( 'performance.user.saveComplete', { duration: ve.now() - this.timings.saveInitiated } );
	this.timings.saveRetries = 0;
	ve.track( 'mwedit.saveSuccess', {
		timing: ve.now() - this.timings.saveInitiated + ( this.timings.serializeForCache || 0 ),
		'page.revid': newRevId
	} );
};

/**
 * Track a save error by type
 *
 * @method
 * @param {string} type Text for error type
 */
ve.init.mw.TargetEvents.prototype.trackSaveError = function ( type ) {
	var key,
		// Maps mwtiming types to mwedit types
		typeMap = {
			badtoken: 'userBadToken',
			newuser: 'userNewUser',
			abusefilter: 'extensionAbuseFilter',
			captcha: 'extensionCaptcha',
			spamblacklist: 'extensionSpamBlacklist',
			empty: 'responseEmpty',
			unknown: 'responseUnknown',
			pagedeleted: 'editPageDeleted',
			editconflict: 'editConflict'
		},
		// Types that are logged as performance.user.saveError.{type}
		// (for historical reasons; this sucks)
		specialTypes = [ 'editconflict' ];

	key = 'performance.user.saveError';
	if ( specialTypes.indexOf( type ) !== -1 ) {
		key += '.' + type;
	}
	this.track( key, {
		duration: ve.now() - this.timings.saveInitiated,
		retries: this.timings.saveRetries,
		type: type
	} );

	ve.track( 'mwedit.saveFailure', {
		type: typeMap[type] || 'responseUnknown',
		timing: ve.now() - this.timings.saveInitiated + ( this.timings.serializeForCache || 0 )
	} );
};

/**
 * Record the time of the last transaction in response to a 'transact' event on the document.
 */
ve.init.mw.TargetEvents.prototype.recordLastTransactionTime = function () {
	this.timings.lastTransaction = ve.now();
};

/**
 * Track time elapsed from beginning of save workflow to review
 */
ve.init.mw.TargetEvents.prototype.onSaveReview = function () {
	this.timings.saveReview = ve.now();
	this.track( 'behavior.saveDialogOpenTillReview', {
		duration: this.timings.saveReview - this.timings.saveWorkflowBegin
	} );
};

ve.init.mw.TargetEvents.prototype.onSurfaceReady = function () {
	this.track( 'performance.system.activation', { duration: ve.now() - this.timings.activationStart } );
	this.target.surface.getModel().getDocument().connect( this, {
		transact: 'recordLastTransactionTime'
	} );
};

/**
 * Track when the user enters the review workflow
 */
ve.init.mw.TargetEvents.prototype.onShowChanges = function () {
	this.track( 'performance.user.reviewComplete', { duration: ve.now() - this.timings.saveReview } );
};

/**
 * Track when the diff request fails in the review workflow
 */
ve.init.mw.TargetEvents.prototype.onShowChangesError = function () {
	this.track( 'performance.user.reviewError', { duration: ve.now() - this.timings.saveReview } );
};

/**
 * Track when the diff request detects no changes
 */
ve.init.mw.TargetEvents.prototype.onNoChanges = function () {
	this.track( 'performance.user.reviewComplete', { duration: ve.now() - this.timings.saveReview } );
};

/**
 * Track whe serilization is complete in review workflow
 */
ve.init.mw.TargetEvents.prototype.onSerializeComplete = function () {
	this.track( 'performance.user.reviewComplete', { duration: ve.now() - this.timings.saveReview } );
};

/**
 * Track when there is a serlization error
 */
ve.init.mw.TargetEvents.prototype.onSerializeError = function () {
	if ( this.timings.saveWorkflowBegin ) {
		// This function can be called by the switch to wikitext button as well, so only log
		// reviewError if we actually got here from the save workflow
		this.track( 'performance.user.reviewError', { duration: ve.now() - this.timings.saveReview } );
	}
};

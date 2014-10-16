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
	this.timings = { 'saveRetries': 0 };
	// Events
	this.target.connect( this, {
		'saveWorkflowBegin': 'onSaveWorkflowBegin',
		'saveWorkflowEnd': 'onSaveWorkflowEnd',
		'saveInitiated': 'onSaveInitated',
		'save': 'onSaveComplete',
		'saveReview': 'onSaveReview',
		'saveErrorEmpty': 'onSaveErrorEmpty',
		'saveErrorSpamBlacklist': 'onSaveErrorSpamBlacklist',
		'saveErrorAbuseFilter': 'onSaveErrorAbuseFilter',
		'saveErrorBadToken': 'onSaveErrorBadToken',
		'saveErrorNewUser': 'onSaveErrorNewUser',
		'saveErrorCaptcha': 'onSaveErrorCaptcha',
		'saveErrorUnknown': 'onSaveErrorUnknown',
		'surfaceReady': 'onSurfaceReady',
		'editConflict': 'onEditConflict',
		'showChanges': 'onShowChanges',
		'showChangesError': 'onShowChangesError',
		'noChanges': 'onNoChanges',
		'serializeComplete': 'onSerializeComplete',
		'serializeError': 'onSerializeError'
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
	ve.track( topic, data );
};

/**
 * Track when user begins the save workflow
 */
ve.init.mw.TargetEvents.prototype.onSaveWorkflowBegin = function () {
	this.timings.saveWorkflowBegin = ve.now();
	this.track( 'behavior.lastTransactionTillSaveDialogOpen', {
		'duration': this.timings.saveWorkflowBegin - this.timings.lastTransaction
	} );
};

/**
 * Track when user ends the save workflow
 */
ve.init.mw.TargetEvents.prototype.onSaveWorkflowEnd = function () {
	this.track( 'behavior.saveDialogClose', { 'duration': ve.now() - this.timings.saveWorkflowBegin } );
	this.timings.saveWorkflowBegin = null;
};

/**
 * Track when document save is initiated
 */
ve.init.mw.TargetEvents.prototype.onSaveInitated = function () {
	this.timings.saveInitiated = ve.now();
	this.timings.saveRetries++;
	this.track( 'behavior.saveDialogOpenTillSave', {
		'duration': this.timings.saveInitiated - this.timings.saveWorkflowBegin
	} );
};

/**
 * Track when document save is complete
 */
ve.init.mw.TargetEvents.prototype.onSaveComplete = function () {
	this.track( 'performance.user.saveComplete', { 'duration': ve.now() - this.timings.saveInitiated } );
	this.timings.saveRetries = 0;
};

/**
 * Track a save error by type
 *
 * @method
 * @param {string} type Text for error type
 */
ve.init.mw.TargetEvents.prototype.trackSaveError = function ( type ) {
	this.track( 'performance.user.saveError', {
		'duration': ve.now() - this.timings.saveInitiated,
		'retries': this.timings.saveRetries,
		'type': type
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
		'duration': this.timings.saveReview - this.timings.saveWorkflowBegin
	} );
};

/**
 * Track when save api returns no data
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorEmpty = function () {
	this.trackSaveError( 'empty' );
};

/**
 * Track when spamblacklist save error occurs
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorSpamBlacklist = function () {
	this.trackSaveError( 'spamblacklist' );
};

/**
 * Track when abusefilter save error occurs
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorAbuseFilter = function () {
	this.trackSaveError( 'abusefilter' );
};

/**
 * Track when the save request requires a new edit token
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorBadToken = function () {
	this.trackSaveError( 'badtoken' );
};

/**
 * Track when the save request detects a new user session
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorNewUser = function () {
	this.trackSaveError( 'newuser' );
};

/**
 * Track when the save request requires about captcha
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorCaptcha = function () {
	this.trackSaveError( 'captcha' );
};

/**
 * Track when save request has an unknown error
 */
ve.init.mw.TargetEvents.prototype.onSaveErrorUnknown = function () {
	this.trackSaveError( 'unknown' );
};

ve.init.mw.TargetEvents.prototype.onSurfaceReady = function () {
	if ( this.target.wikitext === null ) {
		this.track( 'performance.system.activation', { 'duration': ve.now() - this.timings.activationStart } );
	}
	this.target.surface.getModel().getDocument().connect( this, {
		'transact': 'recordLastTransactionTime'
	} );
};

/**
 * Track when save request results in an edit conflict
 */
ve.init.mw.TargetEvents.prototype.onEditConflict = function () {
	this.track( 'performance.user.saveError.editconflict', {
		'duration': ve.now() - this.timings.saveInitiated,
		'retries': this.timings.saveRetries
	} );
};

/**
 * Track when the user enters the review workflow
 */
ve.init.mw.TargetEvents.prototype.onShowChanges = function () {
	this.track( 'performance.user.reviewComplete', { 'duration': ve.now() - this.timings.saveReview } );
};

/**
 * Track when the diff request fails in the review workflow
 */
ve.init.mw.TargetEvents.prototype.onShowChangesError = function () {
	this.track( 'performance.user.reviewError', { 'duration': ve.now() - this.timings.saveReview } );
};

/**
 * Track when the diff request detects no changes
 */
ve.init.mw.TargetEvents.prototype.onNoChanges = function () {
	this.track( 'performance.user.reviewComplete', { 'duration': ve.now() - this.timings.saveReview } );
};

/**
 * Track whe serilization is complete in review workflow
 */
ve.init.mw.TargetEvents.prototype.onSerializeComplete = function () {
	this.track( 'performance.user.reviewComplete', { 'duration': ve.now() - this.timings.saveReview } );
};

/**
 * Track when there is a serlization error
 */
ve.init.mw.TargetEvents.prototype.onSerializeError = function () {
	if ( this.timings.saveWorkflowBegin ) {
		// This function can be called by the switch to wikitext button as well, so only log
		// reviewError if we actually got here from the save workflow
		this.track( 'performance.user.reviewError', { 'duration': ve.now() - this.timings.saveReview } );
	}
};

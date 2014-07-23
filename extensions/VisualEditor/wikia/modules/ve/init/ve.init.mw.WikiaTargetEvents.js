/*!
 * VisualEditor MediaWiki Initialization WikiaTargetEvents class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Initialization MediaWiki Target Analytics.
 *
 * @class
 * @extends ve.init.mw.TargetEvents
 *
 * @constructor
 * @param {ve.init.mw.Target} target Target class to log events for
 */
ve.init.mw.WikiaTargetEvents = function ( target ) {
	// Parent constructor
	ve.init.mw.WikiaTargetEvents.super.call( this, target );

	// Events
	this.target.connect( this, {
		'beforeUnload': 'onBeforeUnload'
	} );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.WikiaTargetEvents, ve.init.mw.TargetEvents );

/* Methods */

ve.init.mw.WikiaTargetEvents.prototype.onSurfaceReady = function () {
	this.timings.surfaceReady = ve.now();
	ve.init.mw.WikiaTargetEvents.super.prototype.onSurfaceReady.call( this );
};

ve.init.mw.WikiaTargetEvents.prototype.onBeforeUnload = function () {
	// Check whether this timing is set to prevent it being called more than once
	if ( !this.timings.beforeUnload ) {
		this.timings.beforeUnload = ve.now();
		this.track( 'wikia', {
			'action': ve.track.actions.CLOSE,
			'label': 'window',
			'duration': this.timings.beforeUnload - this.timings.surfaceReady
		} );
	}
};

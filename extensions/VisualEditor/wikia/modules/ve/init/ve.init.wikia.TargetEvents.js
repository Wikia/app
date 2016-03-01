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
ve.init.wikia.TargetEvents = function ( target ) {
	// Parent constructor
	ve.init.wikia.TargetEvents.super.call( this, target );

	// Events
	this.target.connect( this, {
		beforeUnload: 'onBeforeUnload',
		popStateDeactivated: 'onPopStateDeactivated'
	} );
};

/* Inheritance */

OO.inheritClass( ve.init.wikia.TargetEvents, ve.init.mw.TargetEvents );

/* Methods */

/*
 * Store timestamp when the surface is ready
 */
ve.init.wikia.TargetEvents.prototype.onSurfaceReady = function () {
	this.timings.surfaceReady = ve.now();
	ve.init.wikia.TargetEvents.super.prototype.onSurfaceReady.call( this );
};

/*
 * Track just before the window is unloaded
 */
ve.init.wikia.TargetEvents.prototype.onBeforeUnload = function () {
	// Check whether this timing is set to prevent it being called more than once
	if ( !this.timings.beforeUnload ) {
		this.timings.beforeUnload = ve.now();
		ve.track( 'wikia', {
			action: ve.track.actions.CLOSE,
			label: 'window',
			value: ve.track.normalizeDuration( this.timings.beforeUnload - this.timings.surfaceReady )
		} );
	}
};

/**
 * Track when document save is complete
 */
ve.init.wikia.TargetEvents.prototype.onSaveComplete = function () {
	ve.init.wikia.TargetEvents.super.prototype.onSaveComplete.call( this );
	ve.track( 'wikia', {
		action: ve.track.actions.CLICK,
		label: 'dialog-save-publish',
		value: ve.track.normalizeDuration( ve.now() - this.timings.saveInitiated )
	} );
};

/*
 * Track when user deactivates VE by clicking back button
 */
ve.init.wikia.TargetEvents.prototype.onPopStateDeactivated = function () {
	ve.track( 'wikia', {
		action: ve.track.actions.CLICK,
		label: 'back',
		value: ve.track.normalizeDuration( ve.now() - this.timings.surfaceReady )
	} );
};

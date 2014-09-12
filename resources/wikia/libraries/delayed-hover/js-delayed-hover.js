/**
 * JS delayed hover is module that enable fires event when you
 * hover over element and move your mouse slow enough.
 *
 * Usage:
 *
 *	var container = document.getElementById( 'testContainer' );
 *	delayedHover(
 *		container, // HTML node element to watch
 *		{
 *			checkInterval: 100, // How often mouse speed is calculated
 *			maxActivationDistance: 20, // Breakpoint for activation,
 *											onActivate callback will be fired when mouse speed is below this value
 *			onActivate: function () { // Function to call when mouse speed meets required conditions
 *				container.classList.add( 'active' );
 *			},
 *			onDeactivate: function() { // Function to call when you stop hovering element
 *				container.classList.remove( 'active' );
 *			}
 *		}
 *	);
 *
 * Copyright 2014 Wikia Inc.
 * Released under the MIT license
 * https://github.com/Wikia/js-delayed-hover
 */

(function() {
	'use strict';
	var utils, DelayedHoverModule;

	/**
	 * Additional functions to help module to work.
	 */
	utils = {
		/**
		 * Returns first object extended by the properties of the second
		 * @param {Object} dst Object to be extended
		 * @param {Object} src Object with properties that should be added to the previous
		 * @return {Object} Extended object
		 */
		extend: function( dst, src ) {
			var p;
			for ( p in src ) {
				if (src.hasOwnProperty( p )) {
					dst[p] = src[p];
				}
			}
			return dst;
		}
	};

	/**
	 * Module core
	 */
	DelayedHoverModule = function() {
		var getSquaredMoveDistance,
			mouseEnterHandler, mouseLeaveHandler, mouseMoveHandler,
			lastLocation, lastCheckedLocation, options, possiblyActivate, timeoutId;

		/**
		 * Module options
		 */
		options = {
			checkInterval: 100,
			maxActivationDistance: 20,
			onActivate: Function.prototype,
			onDeactivate: Function.prototype
		};

		/**
		 * Calculate squared distance between locations. We use squared values for better performance.
		 * We don't need squared root when comparing to squared max distance.
		 * @returns {number}
		 */
		getSquaredMoveDistance = function() {
			return ( lastCheckedLocation.x - lastLocation.x ) * ( lastCheckedLocation.x - lastLocation.x ) +
				( lastCheckedLocation.y - lastLocation.y ) * ( lastCheckedLocation.y - lastLocation.y );
		};

		/**
		 * Function that checks mouse speed  activates callback when conditions are met
		 */
		possiblyActivate = function() {
			if ( lastLocation && getSquaredMoveDistance() <= options.maxSquaredActivationDistance ) {
				options.onActivate();
			} else {
				if ( timeoutId ) {
					clearTimeout( timeoutId );
				}
				timeoutId = setTimeout( possiblyActivate, options.checkInterval );
			}

			if ( lastLocation ) {
				lastCheckedLocation = lastLocation;
			}
		};

		/**
		 * Mouse move handler
		 */
		mouseMoveHandler = function( e ) {
			lastLocation = {x: e.pageX, y: e.pageY};
		};

		mouseEnterHandler = function( e ) {
			lastCheckedLocation = {x: e.pageX, y: e.pageY};
			lastLocation = null;
			possiblyActivate();
		};

		mouseLeaveHandler = function() {
			if ( timeoutId ) {
				clearTimeout( timeoutId );
			}

			options.onDeactivate();
		};

		/**
		 * Prepare variable, hook handler
		 */
		this.init = function( elem, opts ) {
			options = utils.extend(options, opts);
			options.maxSquaredActivationDistance = options.maxActivationDistance * options.maxActivationDistance;

			elem.addEventListener( 'click', options.onActivate );
			elem.addEventListener( 'mouseenter', mouseEnterHandler );
			elem.addEventListener( 'mouseleave', mouseLeaveHandler );
			elem.addEventListener( 'mousemove', mouseMoveHandler );

			return this;
		};
	};


	window.delayedHover = function( elem, options ) {
		var delayedHover = new DelayedHoverModule();
		return delayedHover.init( elem, options );
	};
})();

/**
 * Library to lazy initialize components of a web page
 *
 * @example
 * sloth({
 * 		on: document.getElementById('lazyModule'),
 * 		callback: function(element){
 * 			element.innerHTML = ajax('/get/some/stuff');
 * 		}
 * });
 *
 * @author Hakubo bukaj.kelo<@gmail.com>
 * @see https://github.com/hakubo/Sloth
 */

(function ( context ) {
	'use strict';

	var sloth = function () {
		//some private vars
		var slice = Array.prototype.slice,
			wTop,
			wBottom,
			undef,
			debounce = (function ( element ) {
				return element ? parseInt( element.getAttribute( 'data-sloth-debounce' ), 10 ) : 200;
			})( context.document.querySelector( 'script[data-sloth-debounce]' ) ),
			delegate = context.setTimeout,
			branches = [],
			Branch = function ( element, threshold, callback ) {
				this.elem = element;
				this.threshold = threshold;
				this.callback = function () {
					callback( element );
				};
			},
			addEvent = function () {
				context.addEventListener( 'scroll', execute );
			},
			removeEvent = function () {
				context.removeEventListener( 'scroll', execute );
			},
			lock = 0,
			execute = function ( force ) {
				var i = branches.length,
					branch;

				if ( debounce ) {
					removeEvent();
				}

				if ( i && ( force || !lock ) ) {
					if ( debounce ) {
						lock = delegate( function () {
							lock = 0;
							addEvent();
						}, debounce );
					}

					// in IE10 window.scrollY doesn't work
					// but window.pageYOffset is basically the same
					// https://developer.mozilla.org/en-US/docs/Web/API/window.scrollY
					wTop = context.scrollY || context.pageYOffset;
					wBottom = wTop + context.innerHeight;

					while ( i-- ) {
						branch = branches[i];

						if ( branch.isVisible() ) {
							delegate( branch.callback, 0 );
							branches.splice( i, 1 );
						}
					}
				}
			};

		Branch.prototype.isVisible = function () {
			var elem = this.elem,
				mayBeVisible = elem.scrollHeight || elem.scrollWidth,
				height,
				threshold,
				top,
				bottom;

			if ( mayBeVisible ) {
				threshold = this.threshold;
				height = elem.offsetHeight;
				top = (elem.offsetTop || elem.y) - threshold;
				bottom = top + height + threshold;

				return wBottom >= top && wTop <= bottom;
			}

			return false;
		};

		Branch.prototype.compare = function( element ){
			return this.elem === element;
		};

		//return Sloth function
		return function ( params ) {
			if ( params ) {
				var elements = params.on,
					prune = params.off,
					threshold = params.threshold !== undef ? params.threshold : 100,
					callback = params.callback,
					i;

				if ( elements && callback ) {
					if ( elements.length !== undef ) {
						elements = slice.call( elements );
						i = elements.length;

						while ( i-- ) {
							branches.push( new Branch( elements[i], threshold, callback ) );
						}
					} else {
						branches.push( new Branch( elements, threshold, callback ) );
					}
				}

				if ( prune ) {
					if ( prune.length !== undef ) {
						prune = slice.call( prune );
						i = prune.length;

						while ( i-- ) {
							branches = branches.filter(function( branch ) {
								return !branch.compare( prune[i] );
							});
						}
					} else {
						branches = branches.filter(function( branch ) {
							return !branch.compare( prune );
						});
					}
				}
			}

			execute( true );
		};
	};

	if ( context.define && context.define.amd ) {
		context.define( 'sloth', sloth );
	} else {
		context.sloth = sloth();
	}
})( this );

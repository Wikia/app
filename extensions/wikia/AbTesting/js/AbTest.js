/**
 * Wikia A/B Testing Framework
 *
 * @author Sean Colombo
 * @author Kyle Florence
 * @author Władysław Bodzek
 *
 * This file should be loaded very early in page execution so that these methods
 * will be accessible to javascript files loaded afterward. Be aware that this
 * file is loaded in a blocking manor so care should be taken to keep it small
 * and fast (comments will be removed during minification, so please use them).
 */

(function( window, Wikia, undefined ) {

var _AbTest = Wikia.AbTest || {},
	console = window.console || {},
	serverTimeString = window.varnishTime,
	serverTime = new Date( serverTimeString ).getTime() / 1000,
	tracker = window.WikiaTracker;

// Internal logging, becomes a no-op if window.console isn't present
var log = typeof console == 'object' ? function( methodName, message ) {
	console.log( 'Wikia.AbTest' + ( message ? '.' + methodName + '()' : '' ) + ':', message );
} : function() {};

// The AbTest class. Instantiating is not required but it allows you to provide
// an experiment context to all of the function calls. You may also call all
// of the functions statically, providing an experiment context yourself.
var AbTest = function( experimentKey ) {
	this.experimentKey = experimentKey;
	this.methodArguments = [ experimentKey ];
};

// Define our experiments, filtering out those that are inactive.
AbTest.experiments = (function( experiments ) {
	var i, experimentKey, version, versions, versionsLength,
		activeExperiments = {},
		count = 0;

	for ( experimentKey in experiments ) {
		var active;

		versions = experiments[ experimentKey ].versions;
		versionsLength = versions.length;

		// Iterate through available versions and find out which one is active now
		for ( i = 0; i < versionsLength; i++ ) {
			version = versions[ i ];

			if ( serverTime >= version.startTime && serverTime <= version.endTime ) {
				active = version;
				break;
			}
		}

		// Active version has been found
		if ( active ) {
			activeExperiments[ experimentKey ] = active;
			count++;
		}
	}

	// Useful for checking if there are any experiments running.
	AbTest.experimentCount = count;

	return activeExperiments;
})( _AbTest.experiments || {} );

// The experiments we have tracked for the user.
AbTest.tracked = _AbTest.tracked || {};

// The treatment groups the user is participating in.
AbTest.treatmentGroups = _AbTest.treatmentGroups || {};

// Used to uniquely identify users.
AbTest.uuid = (function( uuid ) {
	return uuid && uuid != 'ThisIsFake' ? uuid : null;
})( window.beacon_id );

// Returns true if we have tracked the experiment, false otherwise.
AbTest.isTracked = function( experimentKey ) {
	return !!( AbTest.tracked[ experimentKey ] );
};

// Returns true if the user is in the treatment group, false otherwise.
AbTest.inTreatmentGroup = function( experimentKey, treatmentGroupKey ) {
	return AbTest.getTreatmentGroup( experimentKey ) === treatmentGroupKey;
};

// Returns the GA slot that tracking should be reported to
AbTest.getGaSlot = function( experimentKey ) {
	var experiment = AbTest.experiments[ experimentKey ];
	return experiment && experiment.gaSlot;
};

// Returns the treatment group the user belongs to for the given experiment.
// This is generally determined by the user's UUID. If the user has no UUID,
// or they haven't been assigned to a treatment group, the control group is
// used. In the case that we fail to place this user in any group whatsoever,
// the value 'undefined' will be returned.
AbTest.getTreatmentGroup = function( experimentKey ) {
	var experiment, treatmentGroupKey,
		methodName = 'getTreatmentGroup';

	if ( experimentKey === undefined ) {
		log( methodName, 'Missing required argument "experimentKey."' );

	} else if ( ( treatmentGroupKey = AbTest.treatmentGroups[ experimentKey ] ) === undefined ) {
		if ( ( experiment = AbTest.experiments[ experimentKey ] ) === undefined ) {
			log( methodName, 'Experiment configuration not found for "' + experimentKey + '."' );

		} else {
			var key;

			// This user doesn't have a UUID yet or no active configuration was found,
			// treat them with the control group.
			if ( AbTest.uuid === null || !experiment.treatmentGroups ) {
				log( methodName, 'No uuid set, falling back to control group.' );

				for ( key in experiment.treatmentGroups ) {
					if ( experiment.treatmentGroups[ key ].isControl ) {
						treatmentGroupKey = key;
						break;
					}
				}

				if ( treatmentGroupKey === undefined ) {
					log( methodName, 'No control group defined for experiment "' + experimentKey + '."' );
				}

			// User has a uuid, figure out the treatment group based on that.
			} else {
				var controlGroupKey, i, range, ranges, rangesLength, treatmentGroup,
					slot = AbTest.getUserSlot( experimentKey );

				for ( key in experiment.treatmentGroups ) {
					treatmentGroup = experiment.treatmentGroups[ key ];
					ranges = treatmentGroup.ranges;

					if ( treatmentGroup.isControl ) {
						controlGroupKey = key;
					}

					// Try to match the user's slot to a treatment group range
					for ( i = 0, rangesLength = ranges.length; i < rangesLength; i++ ) {
						range = ranges[ i ];

						// User gets treated with this treatment group only if their
						// assigned slot is within the allotted range.
						if ( slot >= range.min && slot <= range.max ) {
							treatmentGroupKey = key;
						}
					}
				}

				// User isn't assigned to any treatment group.
				// Show the user the control group, but don't log a treatment event.
				if ( treatmentGroupKey === undefined ) {
					treatmentGroupKey = controlGroupKey;
					AbTest.tracked[ experimentKey ] = false;

				} else {
					// TODO: when we start tracking through GA, we will need to add the slot here.
					tracker.trackEvent( 'ab_treatment', {
						time: serverTimeString,
						experiment: experimentKey,
						treatmentGroup: treatmentGroupKey
					}, 'internal' );

					// Mark this experiment as tracked for this page view.
					AbTest.tracked[ experimentKey ] = true;
				}
			}
		}

		// Cache the result of this lookup
		AbTest.treatmentGroups[ experimentKey ] = treatmentGroupKey;
	}

	return treatmentGroupKey;
};

// Returns a hash of all the treatment groups the user is participating in,
// keyed by experiment id. Calling getTreatmentGroup here updates the cache.
AbTest.getTreatmentGroups = function() {
	var experimentKey;

	for ( experimentKey in AbTest.experiments ) {
		AbTest.getTreatmentGroup( experimentKey );
	}

	return AbTest.treatmentGroups;
};

// Returns the slot the user belongs to within an experiment (0 - 99, inclusive).
// If the user has not been assigned a uuid yet, they will belong to slot 0.
AbTest.getUserSlot = function( experimentKey ) {
	var slot = 0;

	if ( AbTest.uuid !== null ) {
		var i,
			str = AbTest.uuid + experimentKey,
			len = str.length;

		for ( i = 0; i < len; i++ ) {
			slot += str.charCodeAt( i ) * ( i + 1 );
		}

		slot = Math.abs( slot ) % 100;
	}

	return slot;
};

// Set up instance methods for AbTest. Allows you to call any of the listed methods
// with a pre-determined experiment context (which is provided on instantiation).
(function( prototype ) {
	var i, length,
		methodNames = [ 'isTracked', 'inTreatmentGroup', 'getTreatmentGroup', 'getTreatmentGroups', 'getUserSlot' ];

	for ( i = 0, length = methodNames.length; i < length; i++ ) {
		(function( methodName ) {
			prototype[ methodName ] = function() {
				return AbTest[ methodName ].apply( AbTest, this.methodArguments.concat( arguments ) );
			};
		})( methodNames[ i ] );
	}
})( AbTest.prototype );

// Allow forcing yourself into a certain treatment group for the duration of a pageview
// for any number of experiments simultaneously. The URL params are of the format:
//     AbTest.EXPERIMENT_ID=TREATMENT_GROUP_ID
// For example:
//     ?AbTest.MY_EXPERIMENT=MY_TREATMENT_GROUP
(function( queryString ) {
	var experimentKey, matches,
		rTreatmentGroups = /AbTest\.([^=]+)=([^?&]+)/gi;

	if ( queryString ) {
		while ( ( matches = rTreatmentGroups.exec( queryString ) ) != null ) {
			experimentKey = matches[ 1 ];
			AbTest.tracked[ experimentKey ] = true;
			AbTest.treatmentGroups[ experimentKey ] = matches[ 2 ];
		}
	}
})( window.location.search );

// Exports
Wikia.AbTest = AbTest;
window.Wikia = Wikia;

})( window, window.Wikia || {} );
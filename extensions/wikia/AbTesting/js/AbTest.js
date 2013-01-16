/**
 * Wikia A/B Testing Framework
 *
 * @author Sean Colombo
 * @author Kyle Florence
 * @author Władysław Bodzek
 *
 * This file should be loaded very early in page execution so that these methods
 * will be accessible to javascript files loaded afterward. Be aware that this
 * file is loaded in a blocking manner so care should be taken to keep it small
 * and fast (comments will be removed during minification, so please use them).
 */

(function( window ) {

	var Wikia = window.Wikia = (window.Wikia || {}),
		config = Wikia.AbTestConfig || {},
		AbTest,
		serverTimeString = window.varnishTime,
		serverTime = new Date( serverTimeString ).getTime() / 1000;

	// Function to log different things (could not use Wikia.Log because it may not be available yet)
	var log = function( methodName, message ) {
		// Internal logging, becomes a no-op if window.console isn't present
		if ( window.console && window.console.log ) {
			if ( !message ) {
				methodName = undefined;
				message = arguments[0];
			}
			window.console.log( 'Wikia.AbTest' + ( methodName ? '.' + methodName + '()' : '' ) + ':', message );
		}
	};

	/* --------------------------- */
	/* AbTest class implementation */

	// The AbTest class. Instantiating is not required but it allows you to provide
	// an experiment context to all of the function calls. You may also call all
	// of the functions statically, providing an experiment context yourself.

	/* Public interface */

	// Object-oriented class constructor
	AbTest = function( expName ) {
		this.expName = expName;
	};

	// Used to uniquely identify users.
	AbTest.uuid = (function( uuid ) {
		var ret = uuid && uuid != 'ThisIsFake' ? uuid : null;
		if ( !ret ) {
			log('init','UUID is not available, A/B testing will be disabled');
		}
		return ret;
	})( window.beacon_id );

	// Returns active group name for the given experiment
	AbTest.getGroup = function( expName ) {
		var exp = getExperiment(expName,'getGroup'),
			group = exp && exp.group;
		return group && group.name;
	};

	// Returns true if the user is in the treatment group, false otherwise.
	AbTest.inGroup = function( expName, groupName ) {
		return AbTest.getGroup(expName) === groupName;
	};

	// Returns true if the specified group name exists in experiment
	AbTest.isValidGroup = function( expName, groupName ) {
		var exp = getExperiment(expName,'isValidGroup'),
			current = exp && exp.current;
		return !!(current && current.groups[groupName]);
	};

	// Returns the GA slot that tracking should be reported to
	AbTest.getGASlot = function( expName ) {
		var exp = getExperiment(expName,'getGASlot'),
			current = exp && exp.current;
		return current && current.gaSlot;
	};

	// Returns list of active experiments with IDs and names of them and groups that user fell in
	// in the following format:
	//   [ {id: EXP_ID, name: EXP_NAME, group: {id: GROUP_ID, name: GROUP_NAME} }, ... ]
	// If includeAll is true, you will also get experiments without assigned groups for the current user
	// and then the "group" property will be missing.
	AbTest.getExperiments = function( includeAll ) {
		var expName, exp, group, el, list = [];

		for ( expName in AbTest.experiments ) {
			exp = AbTest.experiments[expName];
			group = exp.group;
			if ( !group && !includeAll ) {
				continue;
			}
			el = {
				id: exp.id,
				name: exp.name
			};
			if ( group ) {
				el.group = {
					id: group.id,
					name: group.name
				}
			}
			list.push(el);
		}

		return list;
	};

	// Set up instance methods for AbTest. Allows you to call any of the listed methods
	// with a pre-determined experiment context (which is provided on instantiation).
	(function( prototype ) {
		var i, length,
			methodNames = [ 'inGroup', 'getGroup', 'getGASlot', 'getUserSlot' ];

		for ( i = 0, length = methodNames.length; i < length; i++ ) {
			(function( methodName ) {
				prototype[ methodName ] = function() {
					return AbTest[ methodName ].apply( AbTest, [ this.expName ].concat( arguments ) );
				};
			})( methodNames[ i ] );
		}
	})( AbTest.prototype );

	/* Private functions */

	// Returns the experiment configuration, emits a message to the console if it doesn't exist
	function getExperiment( expName, methodName ) {
		if ( !expName ) {
			log( methodName, 'Missing required argument "expName".' );
		}
		var exp = AbTest.experiments[expName];
		if ( !exp ) {
			log( methodName, 'Experiment configuration not found for "' + expName + '."' );
		}
		return exp;
	}

	// Computes hash of the string
	function hash( s ) {
		var slot = 0, i;
		for ( i = 0; i < s.length; i++ ) {
			slot += s.charCodeAt( i ) * ( i + 1 );
		}
		return Math.abs( slot ) % 100;
	}

	// Returns slot (<0,99>) for the given experiments, -1 if UUID is not available
	function getSlot( expName ) {
		return AbTest.uuid
			? hash( AbTest.uuid + expName )
			: -1;
	}

	// Sets the active group in the experiment
	function setActiveGroup( expName, groupName, force ) {
		var exp = getExperiment(expName,'setActiveGroup'),
			current = exp && exp.current,
			group = current && current.groups[groupName];
		if ( group && ( !exp.group || force ) ) {
			exp.group = group;
			return true;
		}
		return false;
	}

	// Returns true if value falls into provided ranges
	function isInRanges( value, ranges ) {
		var i, range;
		for ( i = 0; i < ranges.length; i++ ) {
			range = ranges[ i ];

			// User gets treated with this treatment group only if their
			// assigned slot is within the allotted range.
			if ( value >= range.min && value <= range.max ) {
				return true;
			}
		}
		return false;
	}

	/* ----------------------------------------- */
	/* Initialization and configuration handling */

	// Process experiments from configuration (remove inactive ones and select proper version of actives ones)
	AbTest.experiments = (function( experiments ) {
		var expName, exp, versions, version, i, activeExperiments = {}, count = 0;

		for ( expName in experiments ) {
			exp = experiments[expName];
			versions = exp.versions;

			// Check if any given version is active now
			for ( i = 0; i < versions.length; i++ ) {
				version = versions[ i ];

				// If this version is active remember this information
				if ( serverTime >= version.startTime && serverTime < version.endTime ) {
					exp.current = version;
					count++;
					break;
				}
			}

			if ( exp.current ) {
				activeExperiments[expName] = exp;
			}
		}

		AbTest.experimentCount = count;

		return activeExperiments;
	})( config.experiments || {} );

	// Determine active group for every experiment
	// This is based on current version, however you can override it in cookies (TBD) and query string
	(function( experiments ) {

		// 1. Handle input from query string
		// Get configuration from query string (allows overriding)
		var matches,
			rTreatmentGroups = /AbTest\.([^=]+)=([^?&]+)/gi,
			queryString = window.location.search,
			expName, groupName, exp, slot;

		if ( queryString ) {
			while ( ( matches = rTreatmentGroups.exec( queryString ) ) != null ) {
				expName = matches[1];
				groupName = matches[2];
				if ( !AbTest.isValidGroup( expName, groupName ) ) {
					log('init','Invalid experiment/group specified in URL: '+expName+'/'+groupName);
					continue;
				}
				setActiveGroup( expName, groupName );
			}
		}

		// 2. Compute active groups for remaining experiments
		for ( expName in experiments ) {
			exp = experiments[expName];
			slot = getSlot(expName);
			// Skip this experiment if the group is already set or the slot couldn't have been calculated
			if ( exp.group || !exp.current || slot < 0 ) {
				continue;
			}
			for ( groupName in exp.current.groups ) {
				if ( isInRanges( slot, exp.current.groups[groupName].ranges ) ) {
					setActiveGroup( expName, groupName );
				}
			}
		}
	})( AbTest.experiments );

	// Track active experiments
/*	// disabled temporarily due to Jonathan's request
	(function( experiments ) {
		var expName, exp;
		for ( expName in experiments ) {
			exp = experiments[expName];
			if ( exp.group ) {
				window.WikiaTracker.trackEvent( 'ab_treatment', {
					time: serverTimeString,
					experiment: exp.name,
					experimentId: exp.id,
					treatmentGroup: exp.group.name,
					treatmentGroupId: exp.group.id
				}, 'internal' );
			}
		}
	})( AbTest.experiments );
*/
	// Exports
	Wikia.AbTest = AbTest;

})( window );
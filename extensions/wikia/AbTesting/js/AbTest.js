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

	var AbTest,
		Wikia = window.Wikia = (window.Wikia || {}),
		config = Wikia.AbTestConfig || {},
		logCache = {},
		beacon = window.beacon_id || getCookie('wikia_beacon_id'),
		serverTimeString = window.varnishTime,
		serverDate = serverTimeString ? new Date( serverTimeString ) : new Date(),
		serverTime = serverDate.getTime() / 1000;

	// Function to log different things (could not use Wikia.Log because it may not be available yet)
	var log = (function( console ) {

		// Internal logging, becomes a no-op if window.console isn't present
		return (console && console.log) ? function( methodName, message ) {
			if ( !message ) {
				message = methodName;
				methodName = undefined;
			}

			// Don't display duplicate messages (BugId:96400)
			if ( !logCache[ message ] ) {
				logCache[ message ] = true;
				console.log( 'Wikia.AbTest' + ( methodName ? '.' + methodName + '()' : '' ) + ':', message );
			}
		} : function() {};
	})( window.console );

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
	})( beacon );

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

	/**
	 * Returns the GA slot that tracking should be reported to
	 *
	 * @param expName
	 * @returns {Number|undefined}
	 */
	AbTest.getGASlot = function( expName ) {
		var exp = getExperiment(expName,'getGASlot'),
			current = exp && exp.current,
			gaSlot = current && current.gaSlot;
		return parseInt(gaSlot,10) || undefined;
	};

	// Returns list of active experiments with IDs and names of them and groups that user fell in
	// in the following format:
	//   [ {id: EXP_ID, name: EXP_NAME, group: {id: GROUP_ID, name: GROUP_NAME} }, ... ]
	// If includeAll is true, you will also get experiments without assigned groups for the current user
	// and then the "group" property will be missing.
	AbTest.getExperiments = function( includeAll ) {
		var expName, exp, group, el, list = [];

		if ( !AbTest.uuid ) {
			list.nouuid = true;
		}

		for ( expName in AbTest.experiments ) {
			exp = AbTest.experiments[expName];
			group = exp.group;
			if ( !group && !includeAll ) {
				continue;
			}
			el = {
				id: exp.id,
				name: exp.name,
				flags: exp.flags
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

	AbTest.loadExternalData = function( data ) {
		var index, groupData, html = '';
		log('init', 'Received external configuration');
		for ( index in data ) {
			groupData = data[index];
			if ( groupData.styles ) {
				html += '<style>'+groupData.styles+'</style>';
			}
			if ( groupData.scripts ) {
				html += '<script>'+groupData.scripts+'</script>';
			}
		}
		if ( html != '' ) {
			document.write(html);
		}
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
		if ( !ranges || !ranges.length ) {
			return false;
		}
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

	// From https://developer.mozilla.org/en-US/docs/Web/API/Document/cookie/Simple_document.cookie_framework
	function getCookie(name) {
		if (!name) { return null; }
		return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(name).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
	}

	/* ----------------------------------------- */
	/* Initialization and configuration handling */

	// Process experiments from configuration (remove inactive ones and select proper version of actives ones)
	AbTest.experiments = (function( experiments ) {
		var expName, exp, versions, version, i, activeExperiments = {}, count = 0;

		for ( expName in experiments ) {
			if ( experiments.hasOwnProperty( expName ) ) {
				exp = experiments[expName];
				versions = exp.versions;

				// Check if any given version is active now
				for ( i = 0; i < versions.length; i++ ) {
					version = versions[ i ];

					// If this version is active remember this information
					if ( serverTime >= version.startTime && serverTime < version.endTime ) {
						exp.current = version;
						exp.flags = version.flags;
						count++;
						break;
					}
				}

				if ( exp.current ) {
					activeExperiments[expName] = exp;
				}
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
			expName, groupName, exp, slot,
			externalIds = [];

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
			// Skip this experiment if it's Special Wiki experiment only and this is not a special wiki
			if (exp.flags && exp.flags.limit_to_special_wikis && !window.wgIsGASpecialWiki) {
				log('init', 'Skipping experiment ' + expName + ' - not a special Wiki');
				continue;
			}
			for ( groupName in exp.current.groups ) {
				if ( isInRanges( slot, exp.current.groups[groupName].ranges ) ) {
					setActiveGroup( expName, groupName );
				}
			}
		}

		// Handle fetching external data
		for ( expName in experiments ) {
			exp = experiments[expName];
			if ( exp.current.external && exp.group ) {
				externalIds.push(exp.name+'.'+exp.current.id+'.'+exp.group.id);
			}
		}

		//external AB test scripts are currently not supported by Mercury
		if ( externalIds.length > 0 && !window.Mercury ) {
			log('init', 'Loading external configuration');
			var url = window.wgCdnApiUrl + '/wikia.php?controller=AbTesting&method=externalData&callback=Wikia.AbTest.loadExternalData&ids=';
			url += externalIds.join(',');
			document.write('<scr'+'ipt src="'+encodeURI(url)+'"></script>');
		}
	})( AbTest.experiments );

	// Track active experiments
	(function( experiments ) {
		var expName, exp;
		for ( expName in experiments ) {
			exp = experiments[expName];
			if ( Wikia.Tracker && exp.flags && exp.flags.dw_tracking && exp.group ) {
				Wikia.Tracker.track({
					eventName: 'ab_treatment',
					experiment: exp.name,
					experimentId: exp.id,
					time: serverTimeString,
					trackingMethod: 'internal',
					treatmentGroup: exp.group.name,
					treatmentGroupId: exp.group.id
				});
			}
		}
	})( AbTest.experiments );

	// Exports
	Wikia.AbTest = AbTest;
})( window );

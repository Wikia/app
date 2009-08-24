/* JavaScript for DataCenter extension */

/**
 * Queued rendering system
 * 
 * Adding a queue:
 * dataCenter.renderer.addQueue( 'map', DataCenterMap );
 * 
 * Adding a job:
 * dataCenter.renderer.addJob( 'map', 'locations', function( map ) { } );
 * 
 */
function DataCenterRenderer() {
	
	/* Private Members */

	var self = this;
	var queues = {};
	var jobs = {};
	var targets = {};
	
	/* Public Functions */
	
	/**
	 * Gets a reference to a target by it's id
	 * @param	target	String or Integer of ID of target
	 */
	this.getTarget = function(
		target
	) {
		if ( targets[target] !== undefined  ) {
			return targets[target];
		}
	}
	/**
	 * Adds a relationship between a handler and queue name
	 * @param	queue	The name that this queue will be referred to by jobs.
	 * @param	type	A function object which will be created and then passed
	 * 					to each job for each target
	 */
	this.addQueue = function(
		queue,
		type
	) {
		queues[queue] = type;
	}
	/**
	 * Adds a relationship between a job and target using a specific queue
	 * @param	queue	String of name of rendering system used to reference it
	 * @param	target	String of XML ID of element to perform this job for
	 */
	this.addJob = function(
		queue,
		target,
		job
	) {
		if ( jobs[queue] === undefined  ) {
			jobs[queue] = {};
		}
		if ( jobs[queue][target] === undefined  ) {
			jobs[queue][target] = [];
		}
		jobs[queue][target][jobs[queue][target].length] = job;
	}
	/**
	 * Performs all jobs on all queues
	 */
	this.setup = function() {
		for ( queue in jobs ) {
			if ( queues[queue] !== undefined ) {
				for ( target in jobs[queue] ) {
					targets[target] = new queues[queue]( target );
					for ( job in jobs[queue][target] ) {
						jobs[queue][target][job]( targets[target] );
					}
				}
			} else {
				 alert(
					queue + " is not a valid rendering system.\n\n" +
					"Please add this system using: " +
					"dataCenter.renderer.addQueue( name, type );"
				);
			}
		}
	}
	/**
	 * Attempts to perform a render on all targets
	 */
	this.render = function() {
		for ( queue in queues ) {
			for ( target in targets ) {
				if ( targets[target].render ) {
					targets[target].render();
				}
			}
		}
	}
}
/**
 * Temporary global access system
 * 
 * When an object calls a function which expects a call-back function as an
 * argument, and a member function of an object is given, the context of the
 * object is lost as only the prototype of the function is taken. To solve this
 * the call-back function can reference the object directly using a global
 * reference. The pool is a collection of globally accessible object references
 * which can be added, accessed and removed during run-time.
 */
function DataCenterPool() {
	
	/* Private Members */

	var self = this;
	var objects = {};
	var count = 0;
	
	/* Public Functions */
	
	/**
	 * Adds an object to pool, and returns it's unique ID
	 * @param	object	Object reference to add
	 */
	this.addObject = function(
		object
	) {
		var id = count++;
		objects[id] = object;
		return id;
	}
	/**
	 * Removes an object form pool
	 * @param	id	ID number of object to remove
	 */
	this.removeObject = function(
		id
	) {
		if ( objects[id] !== undefined ) {
			delete objects[id];
		}
	}
	/**
	 * Gets an object from pool
	 * @param	id	ID number of object to get
	 */
	this.getObject = function(
		id
	) {
		if ( objects[id] !== undefined ) {
			return objects[id];
		}
	}
}
/**
 * Scene object
 * @param	target	The XML ID of a DIV in which a plan should be rendered
 * 					into.
 */
function DataCenterScene(
	target
) {
	
	/* Private Members */
	
	// Reference to itself
	var self = this;
	// Colors used in rendering
	var colors = { background: '#626262' };
	// XML ID of element this space is being rendered in
	var target = target;
	// Module to render
	var module = null;
	// Flag indicating the scene can be re-rendered
	var live = false;
	// Features
	var features = {
		radialGradient: true
	};
	
	/* Configuration */
	
	// Gets target element
	var element = document.getElementById( target );
	// Sets element's background color so there's consistency when resizing
	element.style.backgroundColor = colors.background;
	// Sets element's overflow to hidden to resizing smaller looks better
	element.style.overflow = 'hidden';
	// Creates canvas
	var canvas = document.createElement( 'canvas' );
	// Sets canvas' size to pixel size of element, allowing use of
	// percentage values in element's CSS defined width
	canvas.setAttribute( 'width', element.offsetWidth );
	canvas.setAttribute( 'height', element.offsetHeight );
	// Adds canvas to element
	element.appendChild( canvas );
	// IE support ?
	if ( typeof( G_vmlCanvasManager ) != 'undefined' ) {
		canvas = G_vmlCanvasManager.initElement( canvas );
		features.radialGradient = false;
	}
	// Gets canvas' 2D rendering context
	var context = canvas.getContext( '2d' );
	// Attaches click event
	var target = "dataCenter.renderer.getTarget( '" + target + "' )";
	addHandler(
		element,
		'click',
		new Function( target + ".getModule().click();" )
	);
	
	/* Public Functions */
	
	/**
	 * Checks if scene that rack is part of is live
	 */
	this.isLive = function() {
		return live;
	}
	/**
	 * Gets reference to scene's context
	 */
	this.getContext = function() {
		return context;
	}
	/**
	 * Gets reference to scene's canvas
	 */
	this.getCanvas = function() {
		return canvas;
	}
	/**
	 * Gets reference to the module
	 */
	this.getModule = function() {
		// Returns module
		return module;
	}
	/**
	 * Gets list of features supported
	 */
	this.getFeatures = function() {
		return features;
	}
	/**
	 * Sets module to render
	 * @param	newModule	Object of scene compatible module to render
	 * @param	update		Boolean flag indicating desire to re-render now
	 */
	this.setModule = function (
		newModule,
		update
	) {
		newModule.setScene( self );
		module = newModule;
		// Automatically re-render
		self.update( update );
	}
	/**
	 * Re-renders scene
	 * @param	update		Boolean flag indicating desire to re-render now
	 */
	this.update = function (
		update
	) {
		// Check if scene is live and update flag is set
		if ( self.isLive() && update ) {
			// Renders scene
			self.render();
		}
	}
	/**
	 * Renders scene onto canvas
	 */
	this.render = function() {
		// Checks if element's width has changed
		if ( element.width != canvas.width ) {
			// Updates canvas's width
			canvas.setAttribute( 'width', element.offsetWidth );
		}
		// Checks if element's height has changed
		if ( element.height != canvas.height ) {
			// Updates canvas's height
			canvas.setAttribute( 'height', element.offsetHeight );
		}
		// Sets live attribute, making all future changes also re-render
		live = true;
		// Saves state of rendering context
		context.save();
		// Adjusts translation to make lines render as whole pixels
		context.translate( -0.5, -0.5 );
		// Fills canvas with a background color
		context.fillStyle = colors.background;
		context.fillRect(
			0, 0, canvas.width + 1, canvas.height + 1
		);
		// Checks if there is a module render
		if ( module !== null && module.render != undefined ) {
			// Renders module
			module.render();
		}
		// Restores state of rendering context
		context.restore();
	}
}
/**
 * Abstraction for a Google Maps object
 */
function DataCenterMap(
	target
) {
	// Checks that browser is compatible with Google Maps
	if ( !GBrowserIsCompatible() ) {
		return;
	}

	/* Private Members */

	var self = this;
	var target = target;
	var element = document.getElementById( target );
	var map = new GMap2( element );
	var geocoder = new GClientGeocoder();
	var showAddressOptions = {};
	var poolID = null;

	// Initializes map with basic controls and centers it just north of
	// equator at prime-meridian
	map.addControl( new GSmallMapControl() );
	//map.addControl( new GMapTypeControl() );
	map.setCenter( new GLatLng( 25, 0 ), 1 );

	/* Public Functions */

	/**
	 * Adds a marker to map
	 * @param	lat			Float of latitude position to place marker at
	 * @param	lng			Float of longitude position to place marker at
	 * @param	options		Object containing the following members
	 * 			content		String of content to place in info window (optional)
	 * 			popup		Boolean of whether to initially show info window
	 */
	this.addMarker = function(
		lat,
		lng,
		options
	) {
		var marker = new GMarker( new GLatLng( lat, lng ) );
		map.addOverlay( marker );
		if ( options && options.content ) {
			GEvent.addListener( marker, 'click',
				function() {
					marker.openInfoWindowHtml( options.content );
				}
			);
			if ( options.popup ) {
				marker.openInfoWindowHtml( options.content );
			}
		}
	}
	/**
	 * Finds location of a textual address and takes map to that point,
	 * optionally modifying values of XML form elements
	 * @param	address		String of geographical location to look for
	 * @param	options		Object containing the following members
	 * 			content		String of content to place in info window (optional)
	 * 			popup		Boolean of whether to initially show info window
	 * 			latField	Object reference of XML form element to update
	 * 			lngField	Object reference of XML form element to update
	 */
	this.showAddress = function(
		address,
		options
	) {
		// Adds this object to pool and gets it's ID
		poolID = dataCenter.pool.addObject( self );
		// Stores the options last used for later reference
		showAddressOptions = options;
		geocoder.getLatLng( address,
			new Function(
				'point',
				'dataCenter.pool.getObject(' + poolID + ').respond( point );'
			)
		);
	}
	/**
	 * Response to address lookup which is called asynchronously
	 * @param	point	GPoint object of address lookup result
	 */
	this.respond = function(
		point
	) {
		if ( point ) {
			map.setCenter( point, 14 );
			map.clearOverlays();
			self.addMarker(
				point.lat(),
				point.lng(),
				showAddressOptions
			);
			if ( showAddressOptions ) {
				if ( showAddressOptions.latField ) {
					showAddressOptions.latField.value = point.lat();
				}
				if ( showAddressOptions.lngField ) {
					showAddressOptions.lngField.value = point.lng();
				}
			}
		}
		// Removes this object from pool
		dataCenter.pool.removeObject( poolID );
	}
	/**
	 * Moves view of map to a specific geographical location and places
	 * a marker, optionally showing an info window
	 * @param	lat			Float of latitude position to place marker at
	 * @param	lng			Float of longitude position to place marker at
	 * @param	options		Object containing the following members
	 * 			content		String of content to place in info window (optional)
	 * 			popup		Boolean of whether to initially show info window
	 */
	this.showPosition = function(
		lat,
		lng,
		options
	) {
		var point = new GLatLng( lat, lng );
		map.setCenter( point, 14 );
		map.clearOverlays();
		self.addMarker( lat, lng, options );
	}
}
/**
 * General object which encapsulates all systems
 */
var dataCenter = {};
dataCenter.renderer = new DataCenterRenderer();
dataCenter.pool = new DataCenterPool();
dataCenter.ui = {};
dataCenter.ui.layouts = {};
dataCenter.ui.widgets = {};
// Adds hooks that cause dataCenter systems to react to window events
hookEvent( "load", dataCenter.renderer.setup );
hookEvent( "resize", dataCenter.renderer.render );
// Adds rendering queues for scene system
dataCenter.renderer.addQueue( 'scene', DataCenterScene );
// Adds rendering queues for map system
dataCenter.renderer.addQueue( 'map', DataCenterMap );

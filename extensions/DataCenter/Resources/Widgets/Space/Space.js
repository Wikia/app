/* Configuration */

var DATACENTER_SPACE_Z_SCALE = 1.5;

/**
 * Object for rendering a space into a scene
 * @param	id			Integer of row ID of plan
 * @param	physical	Object of space physical structure
 */
function DataCenterSceneSpace(
	id,
	physical
) {
	/* Private Members */

	var self = this;
	var scene = null;
	var cache = { canvas: null, context: null, features: null };
	var synced = false;
	var virtual = {};
	var colors = {
		shadowOutter: 'rgba( 0, 0, 0, 0 )',
		shadowInner: 'rgba( 0, 0, 0, 0.5 )',
		floor: 'rgb( 204, 204, 204 )',
		grid: 'rgb( 255, 255, 255 )',
		walls: 'rgba( 255, 255, 255, 0.1 )',
		corners: 'rgba( 0, 0, 0, 0.1 )'
	};
	if ( !physical ) {
		physical = { width: 1, height: 1, depth: 1, orientation: 0 };
	}
	
	/* Public Functions */
	
	/**
	 * Sets a flag that the current virtual dimensions are invalid
	 */
	this.resync = function() {
		synced = false;
	}
	/**
	 * Checks if plan that rack is part of is live
	 */
	this.isLive = function() {
		return scene !== null && scene.isLive();
	}
	/**
	 * Gets a reference to scene this plan is in
	 */
	this.getScene = function() {
		return scene;
	}
	/**
	 * Sets reference to scene this plan is in
	 */
	this.setScene = function(
		newScene
	) {
		scene = newScene
	}
	/**
	 * Gets this plan's row id
	 */
	this.getID = function() {
		return id;
	}
	
	this.setWidth = function(
		width	
	) {
		physical.width = width;
		self.resync();
		// Automatically re-render
		if ( scene && scene.isLive() ) {
			scene.render();
		}
	}

	this.setHeight = function(
		height	
	) {
		physical.height = height;
		self.resync();
		// Automatically re-render
		if ( scene && scene.isLive() ) {
			scene.render();
		}
	}

	this.setDepth = function(
		depth	
	) {
		physical.depth = depth;
		self.resync();
		// Automatically re-render
		if ( scene && scene.isLive() ) {
			scene.render();
		}
	}
	
	/**
	 * Handles click event
	 */
	this.click = function() {
		physical.orientation = ( physical.orientation + 1 ) % 4;
		self.resync();
		// Automatically re-render
		if ( scene && scene.isLive() ) {
			scene.render();
		}
	}
	/**
	 * Synchronizes space, racks and objects' virtual and physical dimensions
	 */
	this.sync = function() {
		if ( synced || !scene ) {
			return;
		}
		cache.canvas = scene.getCanvas();
		cache.context = scene.getContext();
		cache.features = scene.getFeatures();
		// Reset all virtual dimensions
		virtual = {};
		// Rebuild all virtual dimensions
		self.syncSpace();
		synced = true;
	}
	/**
	 * Synchronizes space's virtual and physical dimensions
	 */
	this.syncSpace = function() {
		if ( !physical.orientation ) {	
			physical.orientation = 0;
		}
		var factor = Math.min(
			cache.canvas.width / physical.width,
			cache.canvas.height / physical.depth
		);
		virtual.orientation = physical.orientation;
		virtual.normal = {
			x: ( virtual.orientation > 1 ? 1 : -1 ),
			y: ( ( virtual.orientation ) % 3 > 0 ? 1 : -1 )
		};
		virtual.width = factor * physical.width;
		virtual.height = factor * physical.height * DATACENTER_SPACE_Z_SCALE;
		virtual.depth = factor * physical.depth;
		virtual.x = ( cache.canvas.width / 2 ) - ( virtual.width / 2 );
		virtual.y = ( cache.canvas.height / 2 ) - ( virtual.depth / 2 );
		virtual.meter = virtual.width / physical.width;
		virtual.base = [
		    { x: virtual.width, y: 0 },
		    { x: 0, y: 0 },
		    { x: 0, y: virtual.depth },
		    { x: virtual.width, y: virtual.depth }
		];
		virtual.top = {
			x: virtual.normal.x * virtual.height,
			y: virtual.normal.y * virtual.height
		};
	}
	/**
	 * Draws space onto it's plan's canvas
	 */
	this.render = function() {
		self.sync();
		self.renderSpace();
	}
	
	this.renderSpace = function() {
		// View offset
		var offset = {
			x: -virtual.width * 0.5,
			y: -virtual.depth * 0.5,
			z: -virtual.height * 0.5,
			zoom: 0
		};
		// View transformations
		cache.context.translate(
			virtual.x + ( virtual.width * 0.5 ),
			virtual.y + ( virtual.depth * 0.5 )
		);
		var factor = 1.0 / ( Math.PI / 2 );
		cache.context.scale(
			( 0.75 + offset.zoom ), ( 0.75 + offset.zoom ) * 0.5
		);
		cache.context.rotate(
			( 45 + ( virtual.orientation * 90 ) ) * ( Math.PI / 180 )
		);
		cache.context.translate( offset.x, offset.y);
		cache.context.translate(
			offset.z * virtual.normal.x, offset.z * virtual.normal.y
		);
		// Shadows
		if ( cache.features.radialGradient ) {
			var max = Math.max( virtual.width, virtual.depth );
			var shadow = cache.context.createRadialGradient(
				( virtual.width * 0.5 ), ( virtual.depth * 0.5 ), 0.1,
				( virtual.width * 0.5 ), ( virtual.depth * 0.5 ), max * 0.75
			);
			shadow.addColorStop(0, colors.shadowInner );
			shadow.addColorStop(1, colors.shadowOutter );
			cache.context.fillStyle = shadow;
			cache.context.fillRect( max * -2, max * -2, max * 4, max * 4 );
		}
		// Walls
		cache.context.fillStyle = colors.walls;
		cache.context.strokeStyle = colors.corners;
		for ( var corner = virtual.orientation; corner < virtual.orientation + 2; corner++ ) {
			var a = corner % 4;
			var b = ( corner + 1 ) % 4;
			cache.context.beginPath()
			cache.context.moveTo( virtual.base[a].x, virtual.base[a].y );
			cache.context.lineTo( virtual.base[b].x, virtual.base[b].y );
			cache.context.lineTo(
				virtual.base[b].x + virtual.top.x,
				virtual.base[b].y + virtual.top.y
			);
			cache.context.lineTo(
				virtual.base[a].x + virtual.top.x,
				virtual.base[a].y + virtual.top.y
			);
			cache.context.closePath();
			cache.context.fill();
			cache.context.stroke();
		}
		// Floor
		cache.context.fillStyle = colors.floor;
		cache.context.fillRect( 0, 0, virtual.width + 1, virtual.depth + 1 );
		// Grid
		cache.context.strokeStyle = colors.grid;
		cache.context.beginPath();
		for ( var x = 1; x < physical.width; x++ ) {
			cache.context.moveTo( x * virtual.meter, 1 );
			cache.context.lineTo( x * virtual.meter, virtual.depth );
		}
		for ( var y = 1; y < physical.depth; y++ ) {
			cache.context.moveTo( 1, y * virtual.meter );
			cache.context.lineTo( virtual.width, y * virtual.meter );
		}
		cache.context.closePath();
		cache.context.stroke();
	}
}
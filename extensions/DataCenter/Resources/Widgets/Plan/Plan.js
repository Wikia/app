/* Configuration */

var DATACENTER_PLAN_U_HEIGHT = 0.05;
var DATACENTER_PLAN_Z_SCALE = 1.5;

/**
 * Object for rendering a plan into a scene
 * @param	id			Integer of row ID of plan
 * @param	physical	Object of space/rack/object physical structure
 * @param	state		Object of highlight/focus state
 */
function DataCenterScenePlan(
	id,
	physical,
	state
) {
	/* Private Members */

	var self = this;
	var scene = null;
	var cache = { canvas: null, context: null, features: null };
	var synced = false;
	var virtual = {};
	var colors = {
		space: {
			shadowOutter: 'rgba( 0, 0, 0, 0 )',
			shadowInner: 'rgba( 0, 0, 0, 0.5 )',
			floor: 'rgb( 204, 204, 204 )',
			grid: 'rgb( 255, 255, 255 )',
			walls: 'rgba( 255, 255, 255, 0.1 )',
			corners: 'rgba( 0, 0, 0, 0.1 )'
		},
		rack: {
			outline: 'rgba( 0, 0, 0, 0.75 )',
			safe: {
				normal: {
				    side: 'rgba( 25, 25, 25, 0.75 )',
				    bottom: 'rgba( 50, 50, 50, 0.75 )',
				    top: 'rgba( 75, 75, 75, 0.75 )'
				},
				current: {
					side: 'rgba( 50, 75, 100, 0.5 )',
				    bottom: 'rgba( 125, 150, 175, 0.5 )',
				    top: 'rgba( 150, 175, 200, 0.5 )'
				}
			},
			overlap: {
				normal: {
					side: 'rgba( 150, 100, 100, 0.75 )',
				    bottom: 'rgba( 175, 125, 125, 0.75 )',
				    top: 'rgba( 200, 150, 150, 0.75 )'
				},
				current: {
					side: 'rgba( 200, 150, 150, 0.5 )',
				    bottom: 'rgba( 225, 175, 175, 0.5 )',
				    top: 'rgba( 250, 200, 200, 0.5 )'
				}
			}
		},
		object: {
			outline: '#333333',
			safe: {
				normal: {
					side: 'rgb( 100, 100, 100 )',
				    top: 'rgb( 125, 125, 125 )'
				},
				current: {
					side: 'rgb( 100, 125, 150 )',
					top:  'rgb( 125, 150, 175 )'
				}
			},
			overlap: {
				normal: {
					side: 'rgba( 125, 75, 75, 0.5 )',
					top: 'rgba( 175, 125, 125, 0.5 )'
				},
				current: {
					side: 'rgba( 175, 125, 125, 0.5 )',
					top: 'rgba( 225, 175, 175, 0.5 )'
				}
			}
		}
	};
	if ( !physical ) {
		physical = { width: 1, height: 1, depth: 1, orientation: 0, racks: {} };
	}
	if ( !state ) {
		state = {
			focus: { id: null, progress: 1, inc: true, begin: null },
			highlight: { rack: null, object: null }
		};
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
	/**
	 * Sets rack orientation
	 * @param	rackId			Integer of row ID of rack to modify
	 * @param	orientation		Integer of orientation to set
	 */
	this.setRackOrientation = function(
		rackId,
		orientation,
		update
	) {
		physical.racks[rackId].orientation = orientation;
		self.resync();
		self.update( update );
	}
	/**
	 * Sets rack position
	 * @param	rackId			Integer of row ID of rack to modify
	 * @param	x				Integer of x position to set
	 * @param	y				Integer of y position to set
	 */
	this.setRackPosition = function(
		rackId,
		x,
		y,
		update
	) {
		physical.racks[rackId].x = x;
		physical.racks[rackId].y = y;
		self.resync();
		self.update( update );
	}
	/**
	 * Sets object orientation
	 * @param	rackId			Integer of row ID of rack object is in
	 * @param	objectId		Integer of row ID of object to modify
	 * @param	orientation		Integer of orientation to set
	 */
	this.setObjectOrientation = function(
		rackId,
		objectId,
		orientation,
		update
	) {
		physical.racks[rackId].objects[objectId].orientation = orientation;
		self.resync();
		self.update( update );
	}
	/**
	 * Sets object position
	 * @param	rackId			Integer of row ID of rack object is in
	 * @param	objectId		Integer of row ID of object to modify
	 * @param	z				Integer of x position to set
	 */
	this.setObjectPosition = function(
		rackId,
		objectId,
		z,
		update
	) {
		physical.racks[rackId].objects[objectId].z = z;
		self.resync();
		self.update( update );
	}
	/**
	 * Sets rack highlight
	 * @param	rackId		Integer of row ID of rack to highlight
	 */
	this.setRackHighlight = function(
		rackId,
		update
	) {
		state.highlight.rack = rackId ? rackId : null;
		self.update( update );
	}
	/**
	 * Clears rack highlight
	 */
	this.clearRackHighlight = function(
		update
	) {
		state.highlight.rack = null;
		self.update( update );
	}
	/**
	 * Sets object highlight
	 * @param	rackId		Integer of row ID of rack to highlight
	 */
	this.setObjectHighlight = function(
		objectId,
		update
	) {
		state.highlight.object = objectId ? objectId : null;
		self.update( update );
	}
	/**
	 * Clears object highlight
	 */
	this.clearObjectHighlight = function(
		update
	) {
		state.highlight.object = null;
		self.update( update );
	}
	/**
	 * Handles click event
	 */
	this.click = function() {
		physical.orientation = ( physical.orientation + 1 ) % 4;
		self.resync();
		self.update( true );
	}
	/**
	 * Updates rendering of space
	 * @param	update			Flag of whether to actually update
	 */
	this.update = function(
		update
	) {
		if ( update && scene && scene.isLive() ) {
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
		for ( rack in physical.racks ) {
			self.syncRack( rack );
			for ( object in physical.racks[rack].objects ) {
				self.syncObject( rack, object )
			}
		}
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
		virtual.height = factor * physical.height * DATACENTER_PLAN_Z_SCALE;
		virtual.depth = factor * physical.depth;
		virtual.x = ( cache.canvas.width / 2 ) - ( virtual.width / 2 );
		virtual.y = ( cache.canvas.height / 2 ) - ( virtual.depth / 2 );
		virtual.meter = virtual.width / physical.width;
		virtual.base = [
		    { x: virtual.width, y: 0 },
		    { x: 0, y: 0 },
		    { x: 0, y: virtual.depth },
		    { x: virtual.width, y: virtual.depth },
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
		// Focus
		if ( state.focus.id !== null ) {
			var rack = physical.racks[state.focus.id];
			var progress = state.focus.inc ? 1 : 0;
			if ( state.focus.progress < 1 ) {
				var now = new Date();
				if ( state.focus.begin == null ) {
					state.focus.begin = now.getTime();
				}
				state.focus.progress = Math.min(
					( ( now.getTime() - state.focus.begin ) * 0.001 ) * 2, 1
				);
				if ( state.focus.inc ) {
					progress = state.focus.progress;
				} else {
					progress = 1.0 - state.focus.progress;
				}
			}
			var factor = Math.sin( progress * ( Math.PI * 0.5 ) );
			offset.x += (
				factor * ( -offset.x - ( virtual.meter * ( rack.x - 0.5 ) ) )
			);
			offset.y += (
				factor * ( -offset.y - ( virtual.meter * ( rack.y - 0.5 ) ) )
			);
			offset.z += (
				factor *
				( -offset.z -
					( virtual.meter *
						( rack.units * DATACENTER_PLAN_U_HEIGHT *
							DATACENTER_PLAN_Z_SCALE * 0.5
						)
					)
				)
			);
			offset.zoom += progress;
			offset.zoom -= ( rack.units * 0.005 ) * progress;
		}
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
			shadow.addColorStop(0, colors.space.shadowInner );
			shadow.addColorStop(1, colors.space.shadowOutter );
			cache.context.fillStyle = shadow;
			cache.context.fillRect( max * -2, max * -2, max * 4, max * 4 );
		}
		// Walls
		cache.context.fillStyle = colors.space.walls;
		cache.context.strokeStyle = colors.space.corners;
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
		cache.context.fillStyle = colors.space.floor;
		cache.context.fillRect( 0, 0, virtual.width + 1, virtual.depth + 1 );
		// Grid
		cache.context.strokeStyle = colors.space.grid;
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
		// Racks
		var passes = [ 'shadows', 'geometry', ];
		if ( state.focus.id !== null && state.focus.inc ) {
			for ( var pass = 0; pass < passes.length; pass++ ) {
				self.renderRack( state.focus.id, passes[pass] );
			}
		} else {
			var orderedRacks = [];
			var positions = {};
			for ( rack in physical.racks ) {
				x = parseInt( physical.racks[rack].x );
				y = parseInt( physical.racks[rack].y );
				width = parseInt( physical.width );
				depth = parseInt( physical.depth );
				var position = 0;
				switch ( virtual.orientation ) {
				case 0: position = y + ( x * depth );
					break;
				case 1: position = ( x * depth ) - y;
					break;
				case 2: position = ( width * depth ) - ( x + ( y * width ) );
					break;
				case 3: position = ( width * depth ) - ( ( x * depth ) - y );
					break;
				}
				if ( positions[position] !== undefined ) {
					positions[position]++;
				} else {
					positions[position] = 1;
				}
				orderedRacks[position] = rack;
			}
			for ( var pass = 0; pass < passes.length; pass++ ) {
				for ( position in orderedRacks ) {
					self.renderRack(
						orderedRacks[position],
						passes[pass],
						( positions[position] > 1 )
					);
				}
			}
		}
		// Checks if there's something to look at and the progress is incomplete
		if ( state.focus.id !== null && state.focus.progress < 1 ) {
			// Re-renders in 10ms
			setTimeout(
				"dataCenter.renderer.getTarget( '" + target + "' ).render()", 10
			);
		}
	}
	/**
	 * Synchronizes rack's virtual and physical dimensions
	 */
	this.syncRack = function(
		rackId
	) {
		var rack = {};
		// Calculates and stores rack dimensional information
		rack.orientation =
			( virtual.orientation + physical.racks[rackId].orientation ) % 4;
		rack.normal = {
			x: ( rack.orientation > 1 ? 1 : -1 ),
			y: ( ( rack.orientation ) % 3 > 0 ? 1 : -1 )
		};
		rack.width = virtual.meter;
		rack.depth = virtual.meter;
		rack.height = physical.racks[rackId].units * virtual.meter *
			DATACENTER_PLAN_U_HEIGHT * DATACENTER_PLAN_Z_SCALE;
		rack.x = virtual.meter * ( physical.racks[rackId].x - 1 );
		rack.y = virtual.meter * ( physical.racks[rackId].y - 1 );
		rack.meter = virtual.meter;
		rack.base = [
			{ x: 0, y: rack.depth },
			{ x: 0, y: 0 },
			{ x: rack.width, y: 0 },
			{ x: rack.width, y: rack.depth }
		];
		rack.top = {
			x: rack.normal.x * rack.height, y: rack.normal.y * rack.height
		};
		if ( virtual.racks == undefined ) {
			virtual.racks = {};
		}
		// Adds / updates rack dimensions
		virtual.racks[rackId] = rack;
	}
	/**
	 * Draws rack onto it's plan's canvas
	 */
	this.renderRack = function(
		rackId,
		pass,
		overlap
	) {
		var rack = {
			physical: physical.racks[rackId],
			virtual: virtual.racks[rackId],
			state: ( state.highlight.rack == rackId ? 'current' : 'normal' ),
			status: overlap ? 'overlap' : 'safe'
		};
		var orientation = virtual.orientation;
		// Checks what should be rendered
		if ( pass == 'shadows' ) {
			if ( cache.features.radialGradient ) {
				var max = Math.max( rack.virtual.width, rack.virtual.height )
				var shadow = cache.context.createRadialGradient(
					rack.virtual.x + ( rack.virtual.width * 0.5 ),
					rack.virtual.y + ( rack.virtual.depth * 0.5 ),
					0.1,
					rack.virtual.x + ( rack.virtual.width * 0.5 ),
					rack.virtual.y + ( rack.virtual.depth * 0.5 ),
					max * 0.3 + ( rack.virtual.height * 0.3 )
				);
				shadow.addColorStop( 0, 'rgba( 0, 0, 0, 0.5 )' );
				shadow.addColorStop( 1, 'rgba( 0, 0, 0, 0 )' );
				cache.context.fillStyle = shadow;
				cache.context.fillRect(
					0, 0, virtual.width, virtual.depth
				);
			}
		} else if ( pass == 'geometry' ) {
			// Saves current rack.state
			cache.context.save();
			// Moves into position
			cache.context.translate( rack.virtual.x, rack.virtual.y );
			cache.context.translate(
				rack.virtual.width * 0.5, rack.virtual.depth * 0.5
			);
			cache.context.rotate(
				rack.physical.orientation * 90 * ( Math.PI / 180 )
			);
			cache.context.translate(
				-rack.virtual.width * 0.5, -rack.virtual.depth * 0.5
			);
			cache.context.strokeStyle = colors.rack.outline;
			// Bottom
			cache.context.fillStyle =
				colors.rack[rack.status][rack.state].bottom;
			cache.context.fillRect(
				0, 0, rack.virtual.width, rack.virtual.depth
			);
			cache.context.strokeRect(
				0, 0, rack.virtual.width, rack.virtual.depth
			);
			for ( var i = 0; i < 3; i++ ) {
				if ( i !== 1 ) {
					var side = (
						rack.virtual.orientation < 2 ?
						[( 0 + i ) % 4, ( 1 + i ) % 4] :
						[( 2 + i ) % 4, ( 3 + i ) % 4]
					);
					// Side
					cache.context.fillStyle =
						colors.rack[rack.status][rack.state].side;
					cache.context.beginPath()
					cache.context.moveTo(
						rack.virtual.base[side[0]].x,
						rack.virtual.base[side[0]].y
					);
					cache.context.lineTo(
						rack.virtual.base[side[1]].x,
						rack.virtual.base[side[1]].y
					);
					cache.context.lineTo(
						rack.virtual.base[side[1]].x + rack.virtual.top.x,
						rack.virtual.base[side[1]].y + rack.virtual.top.y
					);
					cache.context.lineTo(
						rack.virtual.base[side[0]].x + rack.virtual.top.x,
						rack.virtual.base[side[0]].y + rack.virtual.top.y
					);
					cache.context.closePath();
					cache.context.fill();
					cache.context.stroke();
				} else {
					// Contents
					var map = [ [], [], [], [] ];
					var overlaps = [];
					var dimensions = [];
					for ( object in rack.physical.objects ) {
						dimensions[object] = rack.physical.objects[object];
						for ( var x = 0; x < dimensions[object].depth; x++ ) {
							for (
								var y = dimensions[object].z;
								y < parseInt( dimensions[object].z ) +
									parseInt( dimensions[object].units );
								y++
							) {
								if ( dimensions[object].orientation ) {
									xPosition = x;
								} else {
									xPosition = 3 - x;
								}
								if ( map[xPosition][y] ) {
									overlaps[map[xPosition][y]] = true;
									overlaps[object] = true;
								} else {
									map[xPosition][y] = object;
								}
							}
						}
					}
					var orderedObjects = [ [], [] ];
					for ( object in rack.physical.objects ) {
						var side = parseInt( dimensions[object].orientation );
						var top = parseInt( dimensions[object].z ) +
							parseInt( dimensions[object].units );
						if ( orderedObjects[side][top] ) {
							var newIndex = orderedObjects[side][top].length;
							orderedObjects[side][top][newIndex] = object;
						} else {
							orderedObjects[side][top] = [ object ];
						}
					}
					if ( ( rack.virtual.orientation % 4 ) % 3 > 0 ) {
						orderedObjects.reverse();
					}
					for ( var u = 0; u < rack.physical.units + 2; u++ ) {
						for ( var side = 0; side < 2; side++ ) {
							if ( orderedObjects[side][u] ) {
								for ( x in orderedObjects[side][u] ) {
									self.renderObject(
										rackId,
										orderedObjects[side][u][x],
										overlaps[orderedObjects[side][u][x]]
									)
								}
							}
						}
					}
				}
			}
			// Top
			cache.context.fillStyle = colors.rack[rack.status][rack.state].top;
			cache.context.fillRect(
				rack.virtual.top.x,
				rack.virtual.top.y,
				rack.virtual.width,
				rack.virtual.depth
			);
			cache.context.strokeRect(
				rack.virtual.top.x,
				rack.virtual.top.y,
				rack.virtual.width,
				rack.virtual.depth
			);
			// Restores previous rack.state
			cache.context.restore();
		}
	}
	/**
	 * Synchronizes object's virtual and physical dimensions
	 */
	this.syncObject = function(
		rackId,
		objectId
	) {
		var object = {};
		// Scale and orientation
		var unit = virtual.meter * DATACENTER_PLAN_U_HEIGHT *
			DATACENTER_PLAN_Z_SCALE;
		var front = physical.racks[rackId].objects[objectId].orientation > 0;
		var position = ( physical.racks[rackId].objects[objectId].z - 1 ) *
			( front ? 1 : -1 );
		// Calculates and stores virtual dimensional information
		object.orientation = ( virtual.racks[rackId].orientation +
			( physical.racks[rackId].objects[objectId].orientation * 2 ) ) % 4;
		object.normal = {
			x: ( object.orientation > 1 ? 1 : -1 ),
			y: ( ( object.orientation ) % 3 > 0 ? 1 : -1 )
		};
		object.width = virtual.meter;
		object.depth = physical.racks[rackId].objects[objectId].depth *
			( virtual.meter * 0.25 );
		object.height = physical.racks[rackId].objects[objectId].units * unit;
		object.x = -object.normal.x * position * unit;
		object.y = -object.normal.y * position * unit;
		object.meter = virtual.meter;
		object.base = [
			{ x: 0, y: object.depth },
			{ x: 0, y: 0 },
			{ x: object.width, y: 0 },
			{ x: object.width, y: object.depth }
		];
		object.top = {
			x: object.normal.x * object.height,
			y: object.normal.y * object.height
		};
		if ( virtual.racks[rackId].objects == undefined ) {
			virtual.racks[rackId].objects = {};
		}
		// Adds / updates object dimensions
		virtual.racks[rackId].objects[objectId] = object;
	}
	/**
	 * Draws object onto it's plan's canvas
	 */
	this.renderObject = function(
		rackId,
		objectId,
		overlap
	) {
		var object = {
			physical: physical.racks[rackId].objects[objectId],
			virtual: virtual.racks[rackId].objects[objectId],
			state: (
				state.highlight.object == objectId ? 'current' : 'normal'
			),
			status: overlap ? 'overlap' : 'safe'
		};
		cache.context.save();
		cache.context.translate( object.virtual.x, object.virtual.y );
		cache.context.translate( virtual.meter * 0.5, virtual.meter * 0.5 );
		cache.context.rotate(
			object.physical.orientation * 2 * 90 * ( Math.PI / 180 )
		);
		cache.context.translate( -virtual.meter * 0.5, -virtual.meter * 0.5 );
		cache.context.strokeStyle = colors.object.outline;
		// Bottom
		cache.context.strokeRect(
			0,
			object.virtual.base[1].y,
			object.virtual.width,
			object.virtual.depth
		);
		// Side
		cache.context.fillStyle =
			colors.object[object.status][object.state].side;
		var start = object.virtual.orientation;
		var end = object.virtual.orientation + 2;
		if ( object.virtual.orientation % 2 == 0 ) {
			start = object.virtual.orientation + 2;
			end = object.virtual.orientation + 4;
		}
		for ( var corner = start; corner < end; corner++ ) {
			var a = corner % 4;
			var b = ( corner + 1 ) % 4;
			cache.context.beginPath()
			cache.context.moveTo(
				object.virtual.base[a].x, object.virtual.base[a].y
			);
			cache.context.lineTo(
				object.virtual.base[b].x, object.virtual.base[b].y
			);
			cache.context.lineTo(
				object.virtual.base[b].x + object.virtual.top.x,
				object.virtual.base[b].y + object.virtual.top.y
			);
			cache.context.lineTo(
				object.virtual.base[a].x + object.virtual.top.x,
				object.virtual.base[a].y + object.virtual.top.y
			);
			cache.context.closePath();
			cache.context.fill();
			cache.context.stroke();
		}
		// Top
		cache.context.fillStyle =
			colors.object[object.status][object.state].top;
		cache.context.fillRect(
			object.virtual.top.x,
			object.virtual.top.y + object.virtual.base[1].y,
			object.virtual.width,
			object.virtual.depth
		);
		cache.context.strokeRect(
			object.virtual.top.x,
			object.virtual.top.y + object.virtual.base[1].y,
			object.virtual.width,
			object.virtual.depth
		);
		cache.context.restore();
	}
}
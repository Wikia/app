/*!
 * VisualEditor DataModel Scalable class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Scalable object.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [fixedRatio=true] Object has a fixed aspect ratio
 * @cfg {Object} [currentDimensions] Current dimensions, width & height
 * @cfg {Object} [originalDimensions] Original dimensions, width & height
 * @cfg {Object} [defaultDimensions] Default dimensions, width & height
 * @cfg {boolean} [isDefault] Object is using its default dimensions
 * @cfg {Object} [minDimensions] Minimum dimensions, width & height
 * @cfg {Object} [maxDimensions] Maximum dimensions, width & height
 * @cfg {boolean} [enforceMin=true] Enforce the minimum dimensions
 * @cfg {boolean} [enforceMax=true] Enforce the maximum dimensions
 */
ve.dm.Scalable = function VeDmScalable( config ) {
	config = ve.extendObject( {
		'fixedRatio': true,
		'enforceMin': true,
		'enforceMax': true
	}, config );

	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.fixedRatio = config.fixedRatio;
	if ( config.currentDimensions ) {
		this.setCurrentDimensions( config.currentDimensions );
	}
	if ( config.originalDimensions ) {
		this.setOriginalDimensions( config.originalDimensions );
	}
	if ( config.defaultDimensions ) {
		this.setDefaultDimensions( config.defaultDimensions );
	}
	if ( !!config.isDefault ) {
		this.toggleDefault( !!config.isDefault );
	}
	if ( config.minDimensions ) {
		this.setMinDimensions( config.minDimensions );
	}
	if ( config.maxDimensions ) {
		this.setMaxDimensions( config.maxDimensions );
	}

	this.setEnforcedMin( config.enforceMin );
	this.setEnforcedMax( config.enforceMax );

	// Computed properties
	this.ratio = null;
	this.valid = null;
};

/* Inheritance */

OO.mixinClass( ve.dm.Scalable, OO.EventEmitter );

/* Events */

/**
 * Default size or state changed
 *
 * @event defaultSizeChange
 * @param {boolean} The size is default
 */

/**
 * Original size changed
 *
 * @event originalSizeChange
 * @param {Object} Original dimensions width and height
 */

/**
 * Min size changed
 *
 * @event minSizeChange
 * @param {Object} Min dimensions width and height
 */

/**
 * Max size changed
 *
 * @event maxSizeChange
 * @param {Object} Max dimensions width and height
 */

/* Methods */

/**
 * Set the fixed aspect ratio from specified dimensions.
 *
 * @param {Object} dimensions Dimensions object with width & height
 */
ve.dm.Scalable.prototype.setRatioFromDimensions = function ( dimensions ) {
	if ( dimensions && dimensions.width && dimensions.height ) {
		this.ratio = dimensions.width / dimensions.height;
	}
	this.valid = null;
};

/**
 * Set the current dimensions
 *
 * Also sets the aspect ratio if not set and in fixed ratio mode.
 *
 * @param {Object} dimensions Dimensions object with width & height
 */
ve.dm.Scalable.prototype.setCurrentDimensions = function ( dimensions ) {
	if ( this.isDimensionsObjectValid( dimensions ) ) {
		this.currentDimensions = ve.copy( dimensions );
		// Only use current dimensions for ratio if it isn't set
		if ( this.fixedRatio && !this.ratio ) {
			this.setRatioFromDimensions( this.getCurrentDimensions() );
		}
		this.valid = null;
	}
};

/**
 * Set the original dimensions
 *
 * Also resets the aspect ratio if in fixed ratio mode.
 *
 * @param {Object} dimensions Dimensions object with width & height
 * @fires originalSizeChange
 */
ve.dm.Scalable.prototype.setOriginalDimensions = function ( dimensions ) {
	if (
		!this.originalDimensions ||
		(
			this.isDimensionsObjectValid( dimensions ) &&
			!ve.compare( this.originalDimensions, dimensions )
		)
	) {
		this.originalDimensions = ve.copy( dimensions );
		// Always overwrite ratio
		if ( this.fixedRatio ) {
			this.setRatioFromDimensions( this.getOriginalDimensions() );
		}
		this.valid = null;
		this.emit( 'originalSizeChange', this.getOriginalDimensions() );
	}
};

/**
 * Set the default dimensions
 *
 * @param {Object} dimensions Dimensions object with width & height
 * @fires defaultSizeChange
 */
ve.dm.Scalable.prototype.setDefaultDimensions = function ( dimensions ) {
	if (
		!this.defaultDimensions ||
		(
			this.isDimensionsObjectValid( dimensions ) &&
			!ve.compare( this.defaultDimensions, dimensions )
		)
	) {
		this.defaultDimensions = ve.copy( dimensions );
		this.valid = null;
		this.emit( 'defaultSizeChange', this.isDefault() );
	}
};

/**
 * Toggle the default size setting, or set it to particular value
 *
 * @param {boolean} [isDefault] Default or not, toggles if unset
 * @fires defaultSizeChange
 */
ve.dm.Scalable.prototype.toggleDefault = function ( isDefault ) {
	if ( isDefault === undefined ) {
		isDefault = !this.isDefault();
	}
	if ( this.isDefault() !== isDefault ) {
		this.defaultSize = isDefault;
		if ( isDefault ) {
			this.setCurrentDimensions(
				this.getDefaultDimensions()
			);
		}
		this.emit( 'defaultSizeChange', this.isDefault() );
	}
};

/**
 * Set the minimum dimensions
 *
 * @param {Object} dimensions Dimensions object with width & height
 * @fires minSizeChange
 */
ve.dm.Scalable.prototype.setMinDimensions = function ( dimensions ) {
	if (
		!this.minDimensions ||
		(
			this.isDimensionsObjectValid( dimensions ) &&
			!ve.compare( this.minDimensions, dimensions )
		)
	) {
		this.minDimensions = ve.copy( dimensions );
		this.valid = null;
		this.emit( 'minSizeChange', dimensions );
	}
};

/**
 * Set the maximum dimensions
 *
 * @param {Object} dimensions Dimensions object with width & height
 * @fires maxSizeChange
 */
ve.dm.Scalable.prototype.setMaxDimensions = function ( dimensions ) {
	if (
		!this.maxDimensions ||
		(
			this.isDimensionsObjectValid( dimensions ) &&
			!ve.compare( this.maxDimensions, dimensions )
		)
	) {
		this.maxDimensions = ve.copy( dimensions );
		this.emit( 'maxSizeChange', dimensions );
		this.valid = null;
	}
};

/**
 * Unset the minimum dimensions
 * @fires minSizeChange
 */
ve.dm.Scalable.prototype.unsetMinDimensions = function () {
	if ( this.minDimensions !== null ) {
		this.minDimensions = null;
		this.valid = null;
		this.emit( 'minSizeChange', this.minDimensions );
	}
};

/**
 * Unset the maximum dimensions
 * @fires maxSizeChange
 */
ve.dm.Scalable.prototype.unsetMaxDimensions = function () {
	if ( this.maxDimensions !== null ) {
		this.maxDimensions = null;
		this.valid = null;
		this.emit( 'maxSizeChange', this.maxDimensions );
	}
};
/**
 * Get the original dimensions
 *
 * @returns {Object} Dimensions object with width & height
 */
ve.dm.Scalable.prototype.getCurrentDimensions = function () {
	return this.currentDimensions;
};

/**
 * Get the original dimensions
 *
 * @returns {Object} Dimensions object with width & height
 */
ve.dm.Scalable.prototype.getOriginalDimensions = function () {
	return this.originalDimensions;
};

/**
 * Get the default dimensions
 *
 * @returns {Object} Dimensions object with width & height
 */
ve.dm.Scalable.prototype.getDefaultDimensions = function () {
	return this.defaultDimensions;
};

/**
 * Get the default state of the scalable object
 * @return {boolean} Default size or custom
 */
ve.dm.Scalable.prototype.isDefault = function () {
	return this.defaultSize;
};

/**
 * Get the minimum dimensions
 *
 * @returns {Object} Dimensions object with width & height
 */
ve.dm.Scalable.prototype.getMinDimensions = function () {
	return this.minDimensions;
};

/**
 * Get the maximum dimensions
 *
 * @returns {Object} Dimensions object with width & height
 */
ve.dm.Scalable.prototype.getMaxDimensions = function () {
	return this.maxDimensions;
};

/**
 * The object enforces the minimum dimensions when scaling
 *
 * @returns {boolean} Enforces the minimum dimensions
 */
ve.dm.Scalable.prototype.isEnforcedMin = function () {
	return this.enforceMin;
};

/**
 * The object enforces the maximum dimensions when scaling
 *
 * @returns {boolean} Enforces the maximum dimensions
 */
ve.dm.Scalable.prototype.isEnforcedMax = function () {
	return this.enforceMax;
};

/**
 * Set enforcement of minimum dimensions
 *
 * @param {boolean} enforceMin Enforces the minimum dimensions
 */
ve.dm.Scalable.prototype.setEnforcedMin = function ( enforceMin ) {
	this.valid = null;
	this.enforceMin = !!enforceMin;
};

/**
 * Set enforcement of maximum dimensions
 *
 * @param {boolean} enforceMax Enforces the maximum dimensions
 */
ve.dm.Scalable.prototype.setEnforcedMax = function ( enforceMax ) {
	this.valid = null;
	this.enforceMax = !!enforceMax;
};

/**
 * Get the fixed aspect ratio (width/height)
 *
 * @returns {number} Aspect ratio
 */
ve.dm.Scalable.prototype.getRatio = function () {
	return this.ratio;
};

/**
 * Check if the object has a fixed ratio
 *
 * @returns {boolean} The object has a fixed ratio
 */
ve.dm.Scalable.prototype.isFixedRatio = function () {
	return this.fixedRatio;
};

/**
 * Get the current scale of the object
 *
 * @returns {number|null} A scale (1=100%), or null if not applicable
 */
ve.dm.Scalable.prototype.getCurrentScale = function () {
	if ( !this.isFixedRatio() || !this.getCurrentDimensions() || !this.getOriginalDimensions() ) {
		return null;
	}
	return this.getCurrentDimensions().width / this.getOriginalDimensions().width;
};

/**
 * Check if current dimensions are smaller than minimum dimensions in either direction
 *
 * Only possible if enforceMin is false.
 *
 * @returns {boolean} Current dimensions are greater than maximum dimensions
 */
ve.dm.Scalable.prototype.isTooSmall = function () {
	return !!( this.getCurrentDimensions() && this.getMinDimensions() && (
			this.getCurrentDimensions().width < this.getMinDimensions().width ||
			this.getCurrentDimensions().height < this.getMinDimensions().height
		) );
};

/**
 * Check if current dimensions are greater than maximum dimensions in either direction
 *
 * Only possible if enforceMax is false.
 *
 * @returns {boolean} Current dimensions are greater than maximum dimensions
 */
ve.dm.Scalable.prototype.isTooLarge = function () {
	return !!( this.getCurrentDimensions() && this.getMaxDimensions() && (
			this.getCurrentDimensions().width > this.getMaxDimensions().width ||
			this.getCurrentDimensions().height > this.getMaxDimensions().height
		) );
};

/**
 * Calculate the dimensions from a given value of either width or height.
 * This method doesn't take into account any restrictions of minimum or maximum,
 * it simply calculates the new dimensions according to the aspect ratio in case
 * it exists.
 *
 * If aspect ratio does not exist, or if the original object is empty, or if the
 * original object is fully specified, the object is returned as-is without
 * calculations.
 *
 * @param {Object} dimensions Dimensions object with either width or height
 * if both are given, the object will be returned as-is.
 * @param {number} [dimensions.width] The width of the image
 * @param {number} [dimensions.height] The height of the image
 * @returns {Object} Dimensions object with width and height
 */
ve.dm.Scalable.prototype.getDimensionsFromValue = function ( dimensions ) {
	dimensions = ve.copy ( dimensions );

	// Normalize for 'empty' values that are specifically given
	// so if '' is explicitly given, it should be translated to 0
	if ( dimensions.width === '' ) {
		dimensions.width = 0;
	}
	if ( dimensions.height === '' ) {
		dimensions.height = 0;
	}

	// Calculate the opposite size if needed
	if ( !dimensions.height && this.getRatio() !== null && $.isNumeric( dimensions.width ) ) {
		dimensions.height = Math.round( dimensions.width / this.getRatio() );
	}
	if ( !dimensions.width && this.getRatio() !== null && $.isNumeric( dimensions.height ) ) {
		dimensions.width = Math.round( dimensions.height * this.getRatio() );
	}

	return dimensions;
};

/**
 * Get a set of dimensions bounded by current restrictions, from specified dimensions
 *
 * @param {Object} dimensions Dimensions object with width & height
 * @param {number} [grid] Optional grid size to snap to
 * @returns {Object} Dimensions object with width & height
 */
ve.dm.Scalable.prototype.getBoundedDimensions = function ( dimensions, grid ) {
	var ratio, snap, snapMin, snapMax,
		minDimensions = this.isEnforcedMin() && this.getMinDimensions(),
		maxDimensions = this.isEnforcedMax() && this.getMaxDimensions();

	dimensions = ve.copy( dimensions );

	// Bound to min/max
	if ( minDimensions ) {
		dimensions.width = Math.max( dimensions.width, this.minDimensions.width );
		dimensions.height = Math.max( dimensions.height, this.minDimensions.height );
	}
	if ( maxDimensions ) {
		dimensions.width = Math.min( dimensions.width, this.maxDimensions.width );
		dimensions.height = Math.min( dimensions.height, this.maxDimensions.height );
	}

	// Bound to ratio
	if ( this.isFixedRatio() ) {
		ratio = dimensions.width / dimensions.height;
		if ( ratio < this.getRatio() ) {
			dimensions.height = Math.round( dimensions.width / this.getRatio() );
		} else {
			dimensions.width = Math.round( dimensions.height * this.getRatio() );
		}
	}

	// Snap to grid
	if ( grid ) {
		snapMin = minDimensions ? Math.ceil( minDimensions.width / grid ) : -Infinity;
		snapMax = maxDimensions ? Math.floor( maxDimensions.width / grid ) : Infinity;
		snap = Math.round( dimensions.width / grid );
		dimensions.width = Math.max( Math.min( snap, snapMax ), snapMin ) * grid;
		if ( this.isFixedRatio() ) {
			// If the ratio is fixed we can't snap both to the grid, so just snap the width
			dimensions.height = Math.round( dimensions.width / this.getRatio() );
		} else {
			snapMin = minDimensions ? Math.ceil( minDimensions.height / grid ) : -Infinity;
			snapMax = maxDimensions ? Math.floor( maxDimensions.height / grid ) : Infinity;
			snap = Math.round( dimensions.height / grid );
			dimensions.height = Math.max( Math.min( snap, snapMax ), snapMin ) * grid;
		}
	}

	return dimensions;
};

/**
 * Checks whether the current dimensions are numeric and within range
 *
 * @returns {boolean} Current dimensions are valid
 */
ve.dm.Scalable.prototype.isCurrentDimensionsValid = function () {
	var dimensions = this.getCurrentDimensions(),
		minDimensions = this.isEnforcedMin() && this.getMinDimensions(),
		maxDimensions = this.isEnforcedMax() && this.getMaxDimensions();

	this.valid = (
		$.isNumeric( dimensions.width ) &&
		$.isNumeric( dimensions.height ) &&
		(
			!minDimensions || (
				dimensions.width >= minDimensions.width &&
				dimensions.height >= minDimensions.height
			)
		) &&
		(
			!maxDimensions || (
				dimensions.width <= maxDimensions.width &&
				dimensions.height <= maxDimensions.height
			)
		)
	);
	return this.valid;
};

/**
 * Check if an object is a dimensions object.
 * Make sure that if width or height are set, they are not 'undefined'.
 *
 * @param {Object} dimensions A dimensions object to test
 * @returns {boolean} Valid or invalid dimensions object
 */
ve.dm.Scalable.prototype.isDimensionsObjectValid = function ( dimensions ) {
	if (
		dimensions &&
		!$.isEmptyObject( dimensions ) &&
		(
			dimensions.width !== undefined ||
			dimensions.height !== undefined
		)
	) {
		return true;
	}
	return false;
};

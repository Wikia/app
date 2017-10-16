/*!
 * VisualEditor Standalone Initialization Target class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Initialization Standalone target.
 *
 * @class
 * @extends ve.init.Target
 *
 * @constructor
 * @param {string} [surfaceType] Type of surface to use, 'desktop' or 'mobile'
 * @throws {Error} Unknown surfaceType
 */
ve.init.sa.Target = function VeInitSaTarget( surfaceType ) {
	// Parent constructor
	ve.init.Target.call( this, { shadow: true, actions: true, floatable: true } );

	this.surfaceType = surfaceType || this.constructor.static.defaultSurfaceType;
	this.actions = null;

	switch ( this.surfaceType ) {
		case 'desktop':
			this.surfaceClass = ve.ui.DesktopSurface;
			break;
		case 'mobile':
			this.surfaceClass = ve.ui.MobileSurface;
			break;
		default:
			throw new Error( 'Unknown surfaceType: ' + this.surfaceType );
	}

	// The following classes can be used here:
	// ve-init-sa-target-mobile
	// ve-init-sa-target-desktop
	this.$element.addClass( 've-init-sa-target ve-init-sa-target-' + this.surfaceType );
};

/* Inheritance */

OO.inheritClass( ve.init.sa.Target, ve.init.Target );

/* Static properties */

ve.init.sa.Target.static.defaultSurfaceType = 'desktop';

/* Methods */

/**
 * @inheritdoc
 */
ve.init.sa.Target.prototype.addSurface = function () {
	var surface = ve.init.sa.Target.super.prototype.addSurface.apply( this, arguments );
	this.$element.append( surface.$element );
	if ( !this.getSurface() ) {
		this.setSurface( surface );
	}
	surface.initialize();
	return surface;
};

/**
 * @inheritdoc
 */
ve.init.sa.Target.prototype.createSurface = function ( dmDoc, config ) {
	config = ve.extendObject( {
		excludeCommands: OO.simpleArrayUnion(
			this.constructor.static.excludeCommands,
			this.constructor.static.documentCommands,
			this.constructor.static.targetCommands
		),
		importRules: this.constructor.static.importRules
	}, config );
	return new this.surfaceClass( dmDoc, config );
};

/**
 * @inheritdoc
 */
ve.init.sa.Target.prototype.setupToolbar = function ( surface ) {
	// Parent method
	ve.init.sa.Target.super.prototype.setupToolbar.call( this, surface );

	if ( !this.getToolbar().initialized ) {
		this.getToolbar().$element.addClass( 've-init-sa-target-toolbar' );
		this.actions = new ve.ui.TargetToolbar( this );
		this.getToolbar().$actions.append( this.actions.$element );
	}
	this.getToolbar().initialize();

	this.actions.setup( [
		{
			type: 'list',
			icon: 'menu',
			title: ve.msg( 'visualeditor-pagemenu-tooltip' ),
			include: [ 'findAndReplace', 'commandHelp' ]
		}
	], this.getSurface() );

	// HACK: On mobile place the context inside toolbar.$bar which floats
	if ( this.surfaceType === 'mobile' ) {
		this.getToolbar().$bar.append( surface.context.$element );
	}
};

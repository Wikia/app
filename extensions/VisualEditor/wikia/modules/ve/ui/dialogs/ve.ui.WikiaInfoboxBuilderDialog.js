/*
 * VisualEditor user interface WikiaInfobooxBuilderDialog class.
 */

/**
 * Dialog for inserting portable infobox templates.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInfoboxBuilderDialog = function VeUiWikiaInfoboxBuilderDialog( config ) {
    // Parent constructor
    ve.ui.WikiaInfoboxBuilderDialog.super.call( this, config );

    // Properties
    this.surface = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaInfoboxBuilderDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaInfoboxInsertDialog.static.name = 'wikiaInfoboxBuilderDialog';

ve.ui.WikiaInfoboxInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-infobox-insert-title' );

ve.ui.WikiaInfoboxInsertDialog.static.size = 'full';

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getSetupProcess = function ( data ) {
    return ve.ui.WikiaInfoboxBuilderDialog.super.prototype.getSetupProcess.call( this, data )
        .next( function () {
            this.surface = data.surface;
        }, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getBodyHeight = function () {
    return 1000;
};

/* Methods */

ve.ui.WikiaInfoboxBuilderDialog.initialize = function () {
    // Parent method
    ve.ui.WikiaInfoboxBuilderDialog.super.prototype.initialize.call( this );

    // Content
    this.content = new OO.ui.PanelLayout( { padded: true, expanded: false } );
    this.content.$element.append( '<p>A simple dialog window. Press \'Esc\' to close.</p>' );
    this.$body.append( this.content.$element );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getReadyProcess = function ( data ) {
    return ve.ui.WikiaInfoboxBuilderDialog.super.prototype.getReadyProcess.call( this, data );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxBuilderDialog );

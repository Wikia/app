/*!
 * VisualEditor user interface WikiaMapInsertDialog class.
 */

/**
 * Dialog for inserting Wikia map objects.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMapInsertDialog = function VeUiWikiaMapInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaMapInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMapInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaMapInsertDialog.static.name = 'wikiaMapInsert';

ve.ui.WikiaMapInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-map-insert-title' );

ve.ui.WikiaMapInsertDialog.static.icon = 'map';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaMapInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaMapInsertDialog.super.prototype.initialize.call( this );
	this.getMaps().always( ve.bind( function ( data ) {
		if ( data && data.items ) {
			this.displayMaps( data.items );
		}
	}, this ) );

	this.results = new OO.ui.SelectWidget( { '$': this.$ } );
	this.$results = this.$( '<div>' );
	this.$results.append( this.results.$element );
	this.$body.append( this.$results );
	this.results.on( 'select', ve.bind( this.onSelect, this ) );
};

ve.ui.WikiaMapInsertDialog.prototype.getMaps = function () {
	var apiUrl = 'http://dev-interactive-maps.wikia.nocookie.net/api/v1/map?city_id=' + wgCityId + '&cb=' + Math.floor( Math.random() * 1000000 );
	return $.ajax({
		dataType: "json",
		url: 'http://json2jsonp.com/?url=' + encodeURIComponent( apiUrl ) + '&callback=?',
	});
};

ve.ui.WikiaMapInsertDialog.prototype.displayMaps = function ( data ) {
	var items = [],
		i,
		option;
	for ( i = 0; i < data.length; i++ ) {
		option = new OO.ui.OptionWidget( data[i] );
		option.$element.html( data[i].title );
		items.push( option );
	}
	this.results.addItems( items );
};

ve.ui.WikiaMapInsertDialog.prototype.onSelect = function ( option ) {
	var data = option.getData(),
		offset,
		structuralOffset,
		fragment;

	offset = this.getFragment().getRange().start;
	structuralOffset = this.getFragment().getDocument().data.getNearestStructuralOffset( offset, -1 );
	fragment = this.getFragment().clone( new ve.Range( structuralOffset ) );
	fragment.insertContent( [
		{
			type:'wikiaMap',
			attributes: {
				mw: {
					name: 'imap',
					body: {
						extsrc:''
					},
					attrs: {
						"map-id": data.id.toString()
					}
				}
			}
		},
		{
			type: '/wikiaMap'
		}
	] );
	this.close();
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaMapInsertDialog );

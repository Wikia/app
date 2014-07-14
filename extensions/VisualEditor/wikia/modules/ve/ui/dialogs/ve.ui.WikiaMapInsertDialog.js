/*!
 * VisualEditor user interface WikiaMapInsertDialog class.
 */

/*global wgCityId */

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
ve.ui.WikiaMapInsertDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaMapInsertDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.loadingPanel = new OO.ui.PanelLayout( { '$': this.$ } );
			this.zeroPanel = new OO.ui.PanelLayout( { '$': this.$ } );
			this.mapsPanel = new OO.ui.PanelLayout( { '$': this.$ } );

			this.stackLayout = new OO.ui.StackLayout( { '$': this.$ } );
			this.stackLayout.addItems( [ this.loadingPanel, this.zeroPanel, this.mapsPanel ] );
			this.$body.append(this.stackLayout.$element);

			this.loadingPanel.$element.html( 'please wait' );

			this.select = new ve.ui.WikiaMediaSelectWidget( { '$': this.$ } );
			this.select.$element.appendTo( this.mapsPanel.$element );

			this.getMaps().always( ve.bind( function ( data ) {
				console.log(data.items);
				this.stackLayout.setItem( this.mapsPanel );
				var items = [];
				for ( var i = 0; i < data.items.length; i++ ) {
					var item = new ve.ui.WikiaMediaOptionWidget(
						{
							title: data.items[i].title,
							url: data.items[i].image
						},
						{ '$': this.$ }
					);
					items.push( item );
				}
				this.select.addItems( items );
			}, this ) );
		}, this );
};


/**
 * @inheritdoc
 */
/*
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

	this.zeroPanel = new OO.ui.PanelLayout( { '$': this.$ } );
	this.loadingPanel = new OO.ui.PanelLayout( { '$': this.$ } );
	this.mapsPanel = new OO.ui.PanelLayout( { '$': this.$ } );

	this.stackLayout = new OO.ui.StackLayout( { '$': this.$ } );
	this.stackLayout.addItems( [ this.zeroPanel, this.loadingPanel, this.mapsPanel ] );
	this.$body.append(this.stackLayout.$element);
	this.stackLayout.setItem( this.mapsPanel );
};
*/



ve.ui.WikiaMapInsertDialog.prototype.getMaps = function () {
	var apiUrl = 'http://dev-interactive-maps.wikia.nocookie.net/api/v1/map?city_id=' + wgCityId + '&cb=' + Math.floor( Math.random() * 1000000 );
	return $.ajax({
		dataType: 'json',
		url: 'http://json2jsonp.com/?url=' + encodeURIComponent( apiUrl ) + '&callback=?'
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

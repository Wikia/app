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
			this.showMaps( data.items );
		}
	}, this ) );
};

ve.ui.WikiaMapInsertDialog.prototype.getMaps = function () {
	var apiUrl = 'http://dev-interactive-maps.wikia.nocookie.net/api/v1/map?city_id=' + wgCityId + '&cb=' + Math.floor( Math.random() * 1000000 );
	return $.ajax({
		dataType: "json",
		url: 'http://json2jsonp.com/?url=' + encodeURIComponent( apiUrl ) + '&callback=?',
	});
};

ve.ui.WikiaMapInsertDialog.prototype.showMaps = function ( data ) {
	var i,
		$ul = this.$( '<ul>' ).appendTo( this.$body ),
		$li;

	ve.log( 'data', data );

	for ( i = 0; i < data.length; i++ ) {
		var item = data[i];
		$li = this.$( '<li>' ).html( 'Map: ' + item.title + ' / ' + item.id ).appendTo( $ul );
		$li.on( 'click', ve.bind( function() {
			this.insertMap(item.id);
		}, this ) );
	}
};

ve.ui.WikiaMapInsertDialog.prototype.insertMap = function ( mapId ) {
	ve.instances[0].view.model.getFragment().insertContent(
		[
			{
				type:'wikiaMap',
				attributes: {
					mw: {
						name: 'imap',
						body: {
							extsrc:''
						},
						attrs: {
							"map-id": mapId.toString()
						}
					}
				}
			},
			{
				type: '/wikiaMap'
			}
		]
	);

};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaMapInsertDialog );

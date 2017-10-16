/*!
 * VisualEditor user interface MWLanguagesPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki meta dialog Languages page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLanguagesPage = function VeUiMWLanguagesPage( name, config ) {
	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.languagesFieldset = new OO.ui.FieldsetLayout( {
		$: this.$,
		label: ve.msg( 'visualeditor-dialog-meta-languages-label' ),
		icon: 'language'
	} );

	// Initialization
	this.languagesFieldset.$element.append(
		this.$( '<span>' )
			.text( ve.msg( 'visualeditor-dialog-meta-languages-readonlynote' ) )
	);
	this.$element.append( this.languagesFieldset.$element );

	this.getAllLanguageItems().done( this.onLoadLanguageData.bind( this ) );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLanguagesPage, OO.ui.PageLayout );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWLanguagesPage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'language' )
			.setLabel( ve.msg( 'visualeditor-dialog-meta-languages-section' ) );
	}
};

ve.ui.MWLanguagesPage.prototype.onLoadLanguageData = function ( languages ) {
	var i, $languagesTable = this.$( '<table>' ), languageslength = languages.length;

	$languagesTable
		.addClass( 've-ui-mwLanguagesPage-languages-table' )
		.append( this.$( '<tr>' )
			.append(
				this.$( '<th>' )
					.append( ve.msg( 'visualeditor-dialog-meta-languages-code-label' ) )
			)
			.append(
				this.$( '<th>' )
					.append( ve.msg( 'visualeditor-dialog-meta-languages-name-label' ) )
			)
			.append(
				this.$( '<th>' )
					.append( ve.msg( 'visualeditor-dialog-meta-languages-link-label' ) )
			)
		);

	for ( i = 0; i < languageslength; i++ ) {
		languages[i].safelang = languages[i].lang;
		languages[i].dir = 'auto';
		if ( $.uls ) {
			// site codes don't always represent official language codes
			// using real language code instead of a dummy ('redirect' in ULS' terminology)
			languages[i].safelang = $.uls.data.isRedirect( languages[i].lang ) || languages[i].lang;
			languages[i].dir = ve.init.platform.getLanguageDirection( languages[i].safelang );
		}
		$languagesTable
			.append( this.$( '<tr>' )
				.append( this.$( '<td>' ).text( languages[i].lang ) )
				.append( this.$( '<td>' ).text( languages[i].langname ).add(
						this.$( '<td>' ).text( languages[i].title )
					)
					.attr( 'lang', languages[i].safelang )
					.attr( 'dir', languages[i].dir ) )
			);
	}

	this.languagesFieldset.$element.append( $languagesTable );
};

/**
 * Handle language items being loaded.
 */
ve.ui.MWLanguagesPage.prototype.onAllLanguageItemsSuccess = function ( deferred, response ) {
	var i, iLen, languages = [],
		langlinks = response && response.visualeditor && response.visualeditor.langlinks;
	if ( langlinks ) {
		for ( i = 0, iLen = langlinks.length; i < iLen; i++ ) {
			languages.push( {
				lang: langlinks[i].lang,
				langname: langlinks[i].langname,
				title: langlinks[i]['*'],
				metaItem: null
			} );
		}
	}
	deferred.resolve( languages );
};

/**
 * Gets language item from meta list item
 *
 * @param {ve.dm.MWLanguageMetaItem} metaItem
 * @returns {Object} item
 */
ve.ui.MWLanguagesPage.prototype.getLanguageItemFromMetaListItem = function ( metaItem ) {
	// TODO: get real values from metaItem once Parsoid actually provides them - bug 48970
	return {
		lang: 'lang',
		langname: 'langname',
		title: 'title',
		metaItem: metaItem
	};
};

/**
 * Get array of language items from meta list
 *
 * @returns {Object[]} items
 */
ve.ui.MWLanguagesPage.prototype.getLocalLanguageItems = function () {
	var i,
		items = [],
		languages = this.metaList.getItemsInGroup( 'mwLanguage' ),
		languageslength = languages.length;

	// Loop through MWLanguages and build out items

	for ( i = 0; i < languageslength; i++ ) {
		items.push( this.getLanguageItemFromMetaListItem( languages[i] ) );
	}
	return items;
};

/**
 * Get array of language items from meta list
 *
 * @returns {jQuery.Promise}
 */
ve.ui.MWLanguagesPage.prototype.getAllLanguageItems = function () {
	var deferred = $.Deferred();
	// TODO: Detect paging token if results exceed limit
	ve.init.target.constructor.static.apiRequest( {
		action: 'visualeditor',
		paction: 'getlanglinks',
		page: mw.config.get( 'wgPageName' )
	} )
		.done( this.onAllLanguageItemsSuccess.bind( this, deferred ) )
		.fail( this.onAllLanguageItemsError.bind( this, deferred ) );
	return deferred.promise();
};

/**
 * Handle language items failing to be loaded.
 *
 * TODO: This error function should probably not be empty.
 */
ve.ui.MWLanguagesPage.prototype.onAllLanguageItemsError = function () {};

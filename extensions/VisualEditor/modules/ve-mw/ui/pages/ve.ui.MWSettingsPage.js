/*!
 * VisualEditor user interface MWSettingsPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki meta dialog settings page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWSettingsPage = function VeUiMWSettingsPage( name, config ) {
	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.metaList = null;
	this.tocOptionTouched = false;
	this.redirectOptionsTouched = false;
	this.tableOfContentsTouched = false;
	this.label = ve.msg( 'visualeditor-dialog-meta-settings-section' );

	this.settingsFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-meta-settings-label' ),
		'icon': 'settings'
	} );

	// Initialization

	// Table of Contents items
	this.tableOfContents = new OO.ui.FieldLayout(
		new OO.ui.ButtonSelectWidget( { '$': this.$ } )
			.addItems( [
				new OO.ui.ButtonOptionWidget(
					'mwTOCForce',
					{ 'label': ve.msg( 'visualeditor-dialog-meta-settings-toc-force' ) }
				),
				new OO.ui.ButtonOptionWidget(
					'default',
					{ 'label': ve.msg( 'visualeditor-dialog-meta-settings-toc-default' ) }
				),
				new OO.ui.ButtonOptionWidget(
					'mwTOCDisable',
					{ 'label': ve.msg( 'visualeditor-dialog-meta-settings-toc-disable' ) }
				)
			] )
			.connect( this, { 'select': 'onTableOfContentsFieldChange' } ),
		{
			'$': this.$,
			'align': 'top',
			'label': ve.msg( 'visualeditor-dialog-meta-settings-toc-label' )
		}
	);

	// Redirect items
	this.enableRedirectInput = new OO.ui.CheckboxInputWidget( { '$': this.$ } );
	this.enableRedirectField = new OO.ui.FieldLayout(
		this.enableRedirectInput,
		{
			'$': this.$,
			'align': 'inline',
			'label': ve.msg( 'visualeditor-dialog-meta-settings-redirect-label' )
		}
	);
	this.redirectTargetInput = new ve.ui.MWTitleInputWidget( {
		'$': this.$,
		'placeholder': ve.msg( 'visualeditor-dialog-meta-settings-redirect-placeholder' ),
	} );
	this.redirectTargetField = new OO.ui.FieldLayout(
		this.redirectTargetInput,
		{
			'$': this.$,
			'align': 'top'
		}
	);
	this.enableRedirectInput.connect( this, { 'change': 'onEnableRedirectChange' } );
	this.redirectTargetInput.connect( this, { 'change': 'onRedirectTargetChange' } );

	// Disable section edit links items
	this.disabledSectionEditLinks = new OO.ui.FieldLayout(
		new OO.ui.CheckboxInputWidget( { '$': this.$ } ),
		{
			'$': this.$,
			'align': 'inline',
			'label': ve.msg( 'visualeditor-dialog-meta-settings-noeditsection-label' ),
		}
	);

	this.settingsFieldset.addItems( [
		this.enableRedirectField,
		this.redirectTargetField,
		this.tableOfContents,
		this.disabledSectionEditLinks
	] );
	this.$element.append( this.settingsFieldset.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWSettingsPage, OO.ui.PageLayout );

/* Methods */

/* Table of Contents methods */

/**
 * @inheritdoc
 */
ve.ui.MWSettingsPage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'settings' )
			.setLabel( ve.msg( 'visualeditor-dialog-meta-settings-section' ) );
	}
};

/**
 * Handle Table Of Contents display change events.
 *
 * @method
 */
ve.ui.MWSettingsPage.prototype.onTableOfContentsFieldChange = function () {
	this.tableOfContentsTouched = true;
};

/**
 * Get Table Of Contents option
 *
 * @returns {ve.dm.MetaItem|null} TOC option, if any
 */
ve.ui.MWSettingsPage.prototype.getTableOfContentsMetaItem = function () {
	return this.metaList.getItemsInGroup( 'mwTOC' )[0] || null;
};

/* Redirect methods */

/**
 * Handle redirect state change events.
 *
 * @param {boolean} value Whether a redirect is to be set for this page
 */
ve.ui.MWSettingsPage.prototype.onEnableRedirectChange = function ( value ) {
	this.redirectTargetInput.setDisabled( !value );
	if ( !value ) {
		this.redirectTargetInput.setValue( '' );
	}
	this.redirectOptionsTouched = true;
};

/**
 * Handle redirect target change events.
 */
ve.ui.MWSettingsPage.prototype.onRedirectTargetChange = function () {
	this.redirectOptionsTouched = true;
};

/**
 * Get the redirect item
 *
 * @returns {Object|null} Redirect target, if any
 */
ve.ui.MWSettingsPage.prototype.getRedirectTargetItem = function () {
	return this.metaList.getItemsInGroup( 'mwRedirect' )[0] || null;
};

/**
 * Get the section edit link disabling item
 *
 * @returns {Object|null} Section edit link disabling meta item, if any
 */
ve.ui.MWSettingsPage.prototype.getDisableSectionEditLinksItem = function () {
	return this.metaList.getItemsInGroup( 'mwNoEditSection' )[0] || null;
};

/**
 * Setup settings page.
 *
 * @param {ve.dm.MetaList} metaList Meta list
 * @param {Object} [data] Dialog setup data
 */
ve.ui.MWSettingsPage.prototype.setup = function ( metaList ) {
	this.metaList = metaList;

	var // Table of Contents items
		tableOfContentsMetaItem = this.getTableOfContentsMetaItem(),
		tableOfContentsField = this.tableOfContents.getField(),
		tableOfContentsMode = tableOfContentsMetaItem &&
			tableOfContentsMetaItem.getType() || 'default',

		// Redirect items
		redirectTargetItem = this.getRedirectTargetItem(),
		redirectTarget = redirectTargetItem && redirectTargetItem.getAttribute( 'title' ) || '';

	// Table of Contents items
	tableOfContentsField.selectItem( tableOfContentsField.getItemFromData( tableOfContentsMode ) );
	this.tableOfContentsTouched = false;

	// Redirect items (disabled states set by change event)
	this.enableRedirectInput.setValue( !!redirectTargetItem );
	this.redirectTargetInput.setValue( redirectTarget );
	this.redirectTargetInput.setDisabled( !redirectTargetItem );
	this.redirectOptionsTouched = false;

	// Disable section edit links items
	this.disabledSectionEditLinks.getField().setValue( !!this.getDisableSectionEditLinksItem() );
};

/**
 * Tear down settings page.
 *
 * @param {Object} [data] Dialog tear down data
 */
ve.ui.MWSettingsPage.prototype.teardown = function ( data ) {
	// Data initialisation
	data = data || {};

	var // Table of Contents items
		tableOfContentsMetaItem = this.getTableOfContentsMetaItem(),
		tableOfContentsSelectedItem = this.tableOfContents.getField().getSelectedItem(),
		tableOfContentsValue = tableOfContentsSelectedItem && tableOfContentsSelectedItem.getData(),

		// Redirect items
		currentRedirectTargetItem = this.getRedirectTargetItem(),
		newRedirectData = this.redirectTargetInput.getValue(),
		newRedirectItemData = { 'type': 'mwRedirect', 'attributes': { 'title': newRedirectData } },

		// Disable section edit links items
		currentDisableSectionEditLinksItem = this.getDisableSectionEditLinksItem(),
		newDisableSectionEditState = this.disabledSectionEditLinks.getField().getValue();

	// Alter the TOC option flag iff it's been touched & is actually different
	if ( this.tableOfContentsTouched ) {
		if ( tableOfContentsValue === 'default' ) {
			if ( tableOfContentsMetaItem ) {
				tableOfContentsMetaItem.remove();
			}
		} else {
			if ( !tableOfContentsMetaItem ) {
				this.metaList.insertMeta( { 'type': tableOfContentsValue } );
			} else if ( tableOfContentsMetaItem.getType() !== tableOfContentsValue ) {
				tableOfContentsMetaItem.replaceWith(
					ve.extendObject( true, {},
						tableOfContentsMetaItem.getElement(),
						{ 'type': tableOfContentsValue }
					)
				);
			}
		}
	}

	// Alter the redirect options iff they've been touched & are different
	if ( this.redirectOptionsTouched ) {
		if ( currentRedirectTargetItem ) {
			if ( newRedirectData ) {
				if ( currentRedirectTargetItem.getAttribute( 'title' ) !== newRedirectData ) {
					// There was a redirect and is a new one, but they differ, so replace
					currentRedirectTargetItem.replaceWith(
						ve.extendObject( true, {},
							currentRedirectTargetItem.getElement(),
							newRedirectItemData
					) );
				}
			} else {
				// There was a redirect and is no new one, so remove
				currentRedirectTargetItem.remove();
			}
		} else {
			if ( newRedirectData ) {
				// There's no existing redirect but there is a new one, so create
				// HACK: Putting this at index 0, offset 0 so that it works – bug 61862
				this.metaList.insertMeta( newRedirectItemData, 0, 0 );
			}
		}
	}

	// Disable section edit links items
	if ( currentDisableSectionEditLinksItem && !newDisableSectionEditState ) {
		currentDisableSectionEditLinksItem.remove();
	}
	if ( !currentDisableSectionEditLinksItem && newDisableSectionEditState ) {
		this.metaList.insertMeta( { 'type': 'mwNoEditSection' } );
	}

	this.metaList = null;
};

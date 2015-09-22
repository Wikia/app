/*!
 * VisualEditor UserInterface WikiaInsertInfoboxEmptyState class.
 */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInsertInfoboxEmptyState = function VeUiWikiaInsertInfoboxEmptyState( config ) {
	var noInfoboxFoundMsg = ve.msg( 'wikia-visualeditor-dialog-infobox-insert-empty-state'),
		convertInfoboxesMsg = ve.msg( 'wikia-visualeditor-dialog-infobox-insert-empty-state-has-unconverted-infoboxes'),

		insigthsURL = new mw.Uri(
			new mw.Title( 'Insights/nonportableinfoboxes', -1 ).getUrl()
		).toString(),

		noInfoboxesFoundLabel = new OO.ui.LabelWidget( {
			label: noInfoboxFoundMsg
		} ),
		convertInfoboxesLabel = new OO.ui.LabelWidget( {
			label: $( '<a href="' + insigthsURL + '">' + convertInfoboxesMsg + '</a>' )
		}),

		showInsightsLink = config.showInsightsLink || false;

	// Parent constructor
	ve.ui.WikiaInsertInfoboxEmptyState.super.call( this, config );

	this.$element.addClass( 've-ui-insert-infobox-empty-state' );
	this.$element.append( noInfoboxesFoundLabel.$element, showInsightsLink ? convertInfoboxesLabel.$element : '' );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaInsertInfoboxEmptyState, OO.ui.Widget );

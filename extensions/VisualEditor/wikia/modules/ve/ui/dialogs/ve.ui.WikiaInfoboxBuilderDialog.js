/* globals require */

/*
 * VisualEditor user interface WikiaInfobooxBuilderDialog class.
 */

/**
 * Dialog for inserting portable infobox templates.
 *
 * @class
 * @extends OO.ui.ProcessDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInfoboxBuilderDialog = function VeUiWikiaInfoboxBuilderDialog(config) {
	// Parent constructor
	ve.ui.WikiaInfoboxBuilderDialog.super.call(this, config);

	ve.ui.commandRegistry.on('infoboxBuilderReturnToVE', function (infoboxTitle) {
		var wikiaInfoboxInsertCommand = new ve.ui.Command(
				'wikiaInfoboxInsert', 'window', 'open',
				{ args: ['wikiaInfoboxInsert', { infoboxTitle: infoboxTitle }] }
			);
		this.close();
		wikiaInfoboxInsertCommand.execute(this.surface);
	}.bind(this));
};

/* Inheritance */

OO.inheritClass(ve.ui.WikiaInfoboxBuilderDialog, OO.ui.ProcessDialog);

/* Static Properties */

ve.ui.WikiaInfoboxBuilderDialog.static.name = 'wikiaInfoboxBuilder';
ve.ui.WikiaInfoboxBuilderDialog.static.title = 'Infobox Builder';
ve.ui.WikiaInfoboxBuilderDialog.static.size = 'dynamic';
ve.ui.WikiaInfoboxBuilderDialog.static.sizeSourceElement = $('#WikiaPage');

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getSetupProcess = function (data) {
	return ve.ui.WikiaInfoboxBuilderDialog.super.prototype.getSetupProcess.call(this, data)
		.next(function () {
			this.surface = data.surface;
		}, this);
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getBodyHeight = function () {
	// 100% refers to the OO UI window object which is a container for the dialog.
	// It is an absolutely positioned div which overlays the whole viewport.
	return '100%';
};

/* Methods */

ve.ui.WikiaInfoboxBuilderDialog.prototype.initialize = function () {
	var self = this;

	// Parent method
	ve.ui.WikiaInfoboxBuilderDialog.super.prototype.initialize.call(this);

	require(['wikia.loader', 'wikia.mustache', 'wikia.location'], function (loader, mustache, location) {
		loader({
			type: loader.MULTI,
			resources: {
				mustache: 'extensions/wikia/PortableInfoboxBuilder/templates/PortableInfoboxBuilderSpecialController_builder.mustache',
				scripts: 'portable_infobox_builder_js'
			}
		}).done(function (assets) {
			var html = mustache.render(assets.mustache[0], {
				iframeUrl: location.origin + '/infobox-builder/',
				classes: 've-ui-infobox-builder'
			});

			loader.processScript(assets.scripts);

			// Content
			self.content = new OO.ui.PanelLayout({ padded: false, expanded: true });
			self.content.$element.append(html);
			self.$body.append(self.content.$element);
		});
	});
};

/**
 * @returns {string}
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getDynamicSize = function () {
	return ve.ui.WikiaInfoboxBuilderDialog.static.sizeSourceElement.outerWidth();
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxBuilderDialog.prototype.getReadyProcess = function (data) {
	return ve.ui.WikiaInfoboxBuilderDialog.super.prototype.getReadyProcess.call(this, data);
};

/* Registration */

ve.ui.windowFactory.register(ve.ui.WikiaInfoboxBuilderDialog);

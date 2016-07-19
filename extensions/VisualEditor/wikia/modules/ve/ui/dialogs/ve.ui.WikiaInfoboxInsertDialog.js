/*
 * VisualEditor user interface WikiaInfoboxInsertDialog class.
 */

/**
 * Dialog for inserting portable infobox templates.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInfoboxInsertDialog = function VeUiWikiaInfoboxInsertDialog(config) {
	// Parent constructor
	ve.ui.WikiaInfoboxInsertDialog.super.call(this, config);

	// Properties
	this.surface = null;
};

/* Inheritance */

OO.inheritClass(ve.ui.WikiaInfoboxInsertDialog, ve.ui.FragmentDialog);

/* Static Properties */

ve.ui.WikiaInfoboxInsertDialog.static.name = 'wikiaInfoboxInsert';

ve.ui.WikiaInfoboxInsertDialog.static.title = OO.ui.deferMsg('wikia-visualeditor-dialog-infobox-insert-title');

ve.ui.WikiaInfoboxInsertDialog.static.size = 'small';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getSetupProcess = function (data) {
	return ve.ui.WikiaInfoboxInsertDialog.super.prototype.getSetupProcess.call(this, data)
		.next(function () {
			this.surface = data.surface;
			if (data.infoboxTitle) {
				this.refreshInfoboxesList();
				this.onInfoboxTemplateSelect({ data: data.infoboxTitle });
			}
		}, this);
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getBodyHeight = function () {
	return 600;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaInfoboxInsertDialog.super.prototype.initialize.call(this);

	// Initialization
	this.$content.addClass('ve-ui-wikiaInfoboxInsertDialog');

	this.getInfoboxTemplates()
		.then(this.createDialogContent.bind(this))
		.then(this.setDialogContent.bind(this));
};

/**
 * Handle selecting infobox template.
 *
 * @method
 * @param {Object|null} itemData Data of selected item, or null
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onInfoboxTemplateSelect = function (itemData) {
	var template;

	if (itemData) {
		this.$frame.startThrobbing();
		this.transclusionModel = new ve.dm.WikiaTransclusionModel();
		this.transclusionModel.setIsInfobox(true);
		template = ve.dm.MWTemplateModel.newFromName(
			this.transclusionModel, itemData.data
		);

		this.transclusionModel.addPart(template)
			.done(this.insertInfoboxTemplate.bind(this));

		ve.track('wikia', {
			action: ve.track.actions.ADD,
			label: 'infobox-template-insert-from-plain-list'
		});
	}
};

/**
 * Fetch infobox template names from API
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getInfoboxTemplates = function () {
	var deferred = $.Deferred();

	ve.init.target.constructor.static.apiRequest({
			action: 'query',
			list: 'allinfoboxes'
		})
		.done(function (data) {
			deferred.resolve(data);
		})
		.fail(function () {
			// TODO: Add better error handling.
			ve.track('wikia', {
				action: ve.track.actions.ERROR,
				label: 'infobox-templates-api'
			});
			deferred.resolve({});
		});

	return deferred.promise();
};

/**
 * Insert template
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.insertInfoboxTemplate = function () {
	ve.init.target.constructor.static.apiRequest({
			action: 'visualeditor',
			paction: 'parsefragment',
			page: mw.config.get('wgRelevantPageName'),
			wikitext: this.transclusionModel.getWikitext()
		}, { type: 'POST' })
		.done(this.onParseSuccess.bind(this))
		.fail(function () {
			// TODO: Add better error handling.
			ve.track('wikia', {
				action: ve.track.actions.ERROR,
				label: 'dialog-infobox-template-insert'
			});
		}.bind(this));
};

/**
 * @desc creates infobox item option widget
 * @param {Object} data
 * @returns {OO.ui.DecoratedOptionWidget}
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.createInfoboxItemOptionWidget = function (data) {
	return new OO.ui.DecoratedOptionWidget({
		data: data.title,
		label: data.label || data.title
	});
};

/**
 * @desc creates select widget with infobox option widgets
 * @param {OO.ui.DecoratedOptionWidget[]} items
 * @returns {OO.ui.OoUiSelectWidget}
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.createInfoboxSelectWidget = function (items) {
	var select = new OO.ui.SelectWidget();

	select.addItems(items);

	return select;
};

/**
 * @desc creates dialog content
 * @param {Object} data Response data from API
 * @returns {Promise}
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.createDialogContent = function (data) {
	var deferred = $.Deferred(),
		infoboxTemplatesData = data.query ? data.query.allinfoboxes : [],
		infoboxTemplateOptionWidgets;

	if (infoboxTemplatesData.length > 0) {
		this.sortTemplateTitles.apply(this, [infoboxTemplatesData]);
		infoboxTemplateOptionWidgets = infoboxTemplatesData.map(this.createInfoboxItemOptionWidget);

		this.select = this.createInfoboxSelectWidget(infoboxTemplateOptionWidgets);

		this.select.connect(this, {
			select: 'onInfoboxTemplateSelect'
		});

		deferred.resolve(this.select.$element);
	} else {
		// creates empty state content
		this.getUnconvertedInfoboxes()
			.then(this.createEmptyStateContent.bind(this))
			.then(deferred.resolve);
	}

	return deferred.promise();
};

/**
 * @desc gets list of unconverted infoboxes
 * @returns {Promise}
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getUnconvertedInfoboxes = function () {
	var deferred = $.Deferred();

	ve.init.target.constructor.static.apiRequest({
			action: 'query',
			list: 'unconvertedinfoboxes'
		})
		.done(function (data) {
			deferred.resolve(
				this.validateGetUnconvertedInfoboxesResponseData(data) ? data.query.unconvertedinfoboxes : []
			);
		}.bind(this))
		.fail(function () {
			deferred.resolve([]);
		});

	return deferred.promise();
};

/**
 * @desc validates get unconverted infoboxes response data
 * @param {Object} data
 * @returns {Boolean}
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.validateGetUnconvertedInfoboxesResponseData = function (data) {
	return data.query && data.query.unconvertedinfoboxes && data.query.unconvertedinfoboxes.length > 0;
};

/**
 * @desc creates empty state dialog content
 * @param {Array} unconvertedInfoboxes
 * @returns {HTMLElement}
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.createEmptyStateContent = function (unconvertedInfoboxes) {
	var emptyStateWidget = new ve.ui.WikiaInsertInfoboxEmptyState({
		showInsightsLink: unconvertedInfoboxes.length > 0
	});

	return emptyStateWidget.$element;
};

/**
 * @desc sets HTML content for insert infobox dialog
 * @param {HTMLElement} $content
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.setDialogContent = function ($content) {
	this.$body.html($content);

	if (window.wgEnablePortableInfoboxBuilderInVE) {
		this.$body.append(this.addNewTemplateWidget());
	}
};

ve.ui.WikiaInfoboxInsertDialog.prototype.refreshInfoboxesList = function () {
	this.getInfoboxTemplates()
		.then(this.createDialogContent.bind(this))
		.then(this.setDialogContent.bind(this));
};

ve.ui.WikiaInfoboxInsertDialog.prototype.addNewTemplateWidget = function () {
	var $container = $('<div>', { class: 've-ui-wikiaInfoboxInsertDialog-add-container' }),
		button = new OO.ui.ButtonWidget({
			classes: ['ve-ui-wikiaInfoboxInsertDialog-add-button'],
			framed: false,
			icon: 'add',
			iconTitle: OO.ui.deferMsg('wikia-visualeditor-dialog-infobox-insert-add-new-template'),
			label: OO.ui.deferMsg('wikia-visualeditor-dialog-infobox-insert-add-new-template')
		});

	button.connect(this, {
		click: 'onAddNewTemplateClick'
	});

	return $container.html(button.$element);
};

ve.ui.WikiaInfoboxInsertDialog.prototype.onAddNewTemplateClick = function () {
	this.$frame.stopThrobbing();
	this.close();

	ve.track('wikia', {
		category: 've-ib-integration',
		action: ve.track.actions.CLICK,
		label: 'add-new-template-button'
	});

	setTimeout(function () {
		ve.ui.commandRegistry.getCommandByName('wikiaInfoboxBuilder').execute(this.surface);
	}.bind(this), 0);
};

/**
 * Sort template titles alphabetically. We don't need to use toLowerCase() or toUpperCase()
 * to unify titles for sorting because title in response from API always will be UpperCased
 *
 * @param {Array} infoboxes
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.sortTemplateTitles = function (infoboxes) {
	var title1, title2;

	return infoboxes.sort(function (template1, template2) {
		title1 = template1.title;
		title2 = template2.title;

		if (title1 < title2) {
			return -1;
		} else if (title1 > title2) {
			return 1;
		}
		return 0;
	});
};

/**
 * Insert prepared linear model to surface.
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onParseSuccess = function () {
	var type = ve.dm.WikiaInfoboxTransclusionBlockNode.static.name,
		linmod = [
			{
				type: type,
				attributes: {
					mw: this.transclusionModel.getPlainObject()
				}
			},
			{ type: '/' + type }
		];

	this.surface.getModel().getDocument().once('transact', this.onTransact.bind(this));
	this.fragment = this.getFragment()
		.collapseToEnd()
		.setAutoSelect(true)
		.insertContent(linmod);
};

/**
 * Handle document model transaction
 *
 * Once the transclusionModel has inserted the transclusion, the new node in the surface will be selected.
 * We can ask the commandRegistry for the command for the node and execute it.
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onTransact = function () {
	ve.track('wikia', {
		action: ve.track.actions.ADD,
		label: 'dialog-infobox-insert'
	});
	this.$frame.stopThrobbing();
	this.close();

	//setTimeout used for calling command for the node after current stack is cleared.
	//getFocusedNode can be not known here yet
	setTimeout(function () {
		ve.ui.commandRegistry.getCommandForNode(this.surface.getView().getFocusedNode()).execute(this.surface);
	}.bind(this), 0);
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getTeardownProcess = function (data) {
	return ve.ui.WikiaInfoboxInsertDialog.super.prototype.getTeardownProcess.call(this, data)
		.next(function () {
			if (this.select) {
				this.select.selectItem();
			}
		}, this);
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getReadyProcess = function (data) {
	return ve.ui.WikiaInfoboxInsertDialog.super.prototype.getReadyProcess.call(this, data);
};

/* Registration */

ve.ui.windowFactory.register(ve.ui.WikiaInfoboxInsertDialog);

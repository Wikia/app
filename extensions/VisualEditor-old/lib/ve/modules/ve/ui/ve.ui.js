/*!
 * VisualEditor UserInterface namespace.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Namespace for all VisualEditor UserInterface classes, static methods and static properties.
 *
 * @class
 * @singleton
 */
ve.ui = {
	//'actionFactory' instantiated in ve.ui.ActionFactory.js
	//'commandRegistry' instantiated in ve.ui.CommandRegistry.js
	//'triggerRegistry' instantiated in ve.ui.TriggerRegistry.js
	//'toolFactory' instantiated in ve.ui.ToolFactory.js
	'windowFactory': new OO.Factory()
};

ve.ui.windowFactory.register( OO.ui.ConfirmationDialog );

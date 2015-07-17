/*!
 * VisualEditor UserInterface namespace.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
	//'fileDropHandlerFactory' instantiated in ve.ui.FileDropHandlerFactory.js
	windowFactory: new OO.Factory()
};

ve.ui.windowFactory.register( OO.ui.MessageDialog );

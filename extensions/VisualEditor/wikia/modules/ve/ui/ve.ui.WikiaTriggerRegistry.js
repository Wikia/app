/*!
 * VisualEditor TriggerRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Wikia Trigger Registrations */

ve.ui.triggerRegistry.register(
	'wikiaSourceMode', {
		'mac': new ve.ui.WikiaTrigger( ve.ui.WikiaTrigger.static.accessKeyPrefix + '[' ),
		'pc': new ve.ui.WikiaTrigger( ve.ui.WikiaTrigger.static.accessKeyPrefix + '[' )
	}
);

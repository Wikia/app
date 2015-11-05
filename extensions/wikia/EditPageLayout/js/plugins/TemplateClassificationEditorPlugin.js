/**
 * Editor plugin to force template classification type choose on publish if doesn't exist and break article submit
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */
(function (window, $) {
		'use strict';

		var WE = window.WikiaEditor = window.WikiaEditor || (new window.Observable());

		WE.plugins.templateclassificationeditorplugin = $.createClass(WE.plugin, {

			init: function () {
				this.editor.on('save', this.proxy(this.forceType));
			},

			forceType: function () {
				/* Break article submit if modal was forced */
				return !require('TemplateClassificationModalForce').forceType();
			}

		});

})(this, jQuery);

/**
 * Editor plugin to force template classification type choose on publish if doesn't exist and break article submit
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */
(function (window, $) {
		'use strict';

		var WE = window.WikiaEditor = window.WikiaEditor || (new window.Observable()),
			templateClassificationForceModal;

		WE.plugins.templateclassificationeditorplugin = $.createClass(WE.plugin, {

			init: function () {
				this.editor.on('save', this.proxy(this.forceType));
				require(['TemplateClassificationModalForce'], function forceTemplateClassificationModal(tcForce) {
					templateClassificationForceModal = tcForce;
				});
			},

			forceType: function () {
				/* Break article submit if modal was forced */
				return !templateClassificationForceModal.forceType();
			}

		});

})(this, jQuery);

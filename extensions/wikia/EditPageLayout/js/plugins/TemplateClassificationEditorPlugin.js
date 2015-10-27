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
				if (templateClassificationForceModal.forceType() === true) {
					// Break article submit
					return false;
				} else {
					return true;
				}
			}

		});

})(this, jQuery);

/**
 * Editor plugin to force template classification type choose on publish if doesn't exist
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
				var	$typeField = $('#editform').find('input[name=templateClassificationType]'),
					type;

				if ($typeField.length > 0) {
					type = $typeField.attr('value');
					if (type !== '') {
						// Type defined
						return true;
					}
				}

				// Type not defined force modal
				require(['TemplateClassificationInEdit'], function forceTemplateClassificationModal(tc) {
					tc.open();
				});

				// Break article submit
				return false;
			}

		});

})(this, jQuery);

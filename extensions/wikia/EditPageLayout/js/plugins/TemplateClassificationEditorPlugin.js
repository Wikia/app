/**
 * Editor plugin to force template classification type choose on publish if doesn't exist
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */
(function (window, $, mw) {
		'use strict';

		var WE = window.WikiaEditor = window.WikiaEditor || (new window.Observable());

		WE.plugins.templateclassificationeditorplugin = $.createClass(WE.plugin, {

			init: function () {
				this.editor.on('save', this.proxy(this.forceType));
			},

			forceType: function () {
				/* existance of templateClassificationType field defines definition of type
				* TODO check also if type is not set as TemplateClassification::UNDEFINED */
				var typeDefined =
					$('#editform').find('[name=templateClassificationType]').length > 0 ||
					mw.config.get('wgArticleId') !== 0;

				if (!typeDefined) {
					require(['TemplateClassification'], function forceTemplateClassificationModal(tc) {
						tc.open();
					});
				}

				return typeDefined;
			}

		});

})(this, jQuery, mw);

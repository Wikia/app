require(['jquery', 'wikia.window'], function ($, window) {
	function registerPlugin() {
		window.CKEDITOR.plugins.add( 'rte-infobox', {
			init: onEditorInit
		});
	}

	function onEditorInit(editor) {
		editor.addCommand( 'addinfobox', {
			exec: openInfoboxModal
		});
	}

	function openInfoboxModal(editor) {
		$.get('/api.php?format=json&action=query&list=allinfoboxes&yselang=' + window.wgContentLanguage)
			.then(function (data) {
				window.CKEDITOR.dialog.add( 'infobox-dialog', function( editor ) {
					return {
						title: 'Select Infobox to Insert',
						minWidth: 400,
						minHeight: 200,
						contents: [
							{
								id: 'ckeditorInfoboxPickDialog',
								label: '',
								title: '',
								elements: [
									{
										type: 'html',
										html: getInfoboxListMarkup(data)
									}
								]
							}
						],
						onShow: function () {
							$('.infobox-templates-list').on('click', function (evt) {
								debugger;
								openInfoboxParametersEditDialog(
									$(event.currentTarget).data('infobox-name')
								)
							})
						}
					};
				});

				RTE.getInstance().openDialog('infobox-dialog');
			});
	}

	function getInfoboxListMarkup(data) {
		if (!data || !data.query || !data.query.allinfoboxes || !data.query.allinfoboxes.length) {
			return '';
		}

		var markup = '<ul class="infobox-templates-list">';

		data.query.allinfoboxes.forEach(function (infoboxData) {
			markup += '<li><a data-infobox-name="' + infoboxData.title + '">' + infoboxData.title + '</a></li>';
		});

		markup += '</ul>';

		return markup;
	}

	function openInfoboxParametersEditDialog(infoboxName) {
		// generate meta-data
		var data = {
			title: infoboxName,
			wikitext: '{{' + infoboxName + '}}'
		};

		// this.placeholder.setPlaceholderType('double-brackets');
		// this.placeholder.setData(data);

		//RTE.templateEditor.usePlaceholder(this.placeholder);
		//dialog.setLoading(true);

		// get template info
		var self = this;
		RTE.tools.resolveDoubleBrackets(data.wikitext, function(info) {
			//dialog.setLoading(false);

			// store template info
			//self.placeholder.data('info', info);

			// show step #2 - params editor
			if ( (typeof info.availableParams != 'undefined') && (info.availableParams.length > 0) ) {
				RTE.templateEditor.selectStep(2);
			}
			else {
				RTE.log('given template contains no params - inserting / updating...');
				//RTE.templateEditor.commitChanges();

				// close editor
				//dialog.hide();
				return;
			}
		});
	}

	registerPlugin();
});

$('button.add-wikiText-SDObj-from-article').click(function() {
	var $target = $(this),
		objectId = $target.data('object-id'),
		objectPropName = $target.data('prop-name'),
		modalTitle = $.msg('structureddata-add-trivia-header'),
		modalHtml = '<form class="WikiaForm"><div class="input-group"><label>' + $.msg('structureddata-add-trivia-label-name') + ':</label><input type="text" value="" name="schema:name"></div><div class="input-group"><label>' + $.msg('structureddata-add-trivia-label-wiki-text') + ':</label><textarea name="schema:text"></textarea></div></form>',
		modalId = 'AddWikiTextSDObject',
		modalWidth = 505;
	$.getResources([$.getSassCommonURL('extensions/wikia/StructuredData/css/StructuredDataInArticle.scss')]).done(function() {
		$.showCustomModal(
			modalTitle,
			modalHtml,
			{
				className: modalId,
				id: modalId,
				width: modalWidth,
				buttons: [
					{
						defaultButton: true,
						message: $.msg('structureddata-add-trivia-add-button'),
						id: 'addObject',
						handler:function() {
							$('#addObject').attr('disabled','disabled');

							var $modalSelector = $('#AddWikiTextSDObject');
							//console.log($modalSelector.find('input[name="schema:name"]').val());
							$.nirvana.sendRequest({
								controller: 'StructuredDataController',
								method: 'createReferencedObject',
								type: 'POST',
								format: 'json',
								data: {
									type: 'wikia:WikiText',
									'schema:name': $modalSelector.find('input[name="schema:name"]').val(),
									'schema:text': $modalSelector.find('textarea').val(),
									objectId: objectId,
									objectPropName: objectPropName
								},
								callback: function(data) {
									if(data.error) {
										alert(data.error);
										$('#addObject').attr('disabled','');
									}
									else {
										var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?action=purge';
										$('#AddWikiTextSDObject').closeModal();
										window.location = url;
									}
								}
							});
						}
					},
					{
						message: $.msg('structureddata-object-delete-confirm-cancel-button'),
						handler:function() {
							$('#AddWikiTextSDObject').closeModal();
						}
					}
				]
			}
		);
	});
});
$('button.add-wikiText-SDObj-from-article').click(function() {
	var modalTitle = 'Add new WikiText Object',
		modalHtml = '<form class="WikiaForm"><div class="input-group"><label>Name:</label><input type="text" value="" name="schema:name"></div><div class="input-group"><label>WikiText:</label><textarea name="schema:text"></textarea></div></form>',
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
						defaultButton:true,
						message:'Add',
						handler:function() {
							var $modalSelector = $('#AddWikiTextSDObject');
							console.log($modalSelector.find('input[name="schema:name"]').val());
							$.nirvana.sendRequest({
								controller: 'StructuredDataController',
								method: 'createWikiTextObjFromArticle',
								type: 'POST',
								format: 'json',
								data: {
									type: 'wikia:WikiText',
									name: $modalSelector.find('input[name="schema:name"]').val(),
									'schema:name': $modalSelector.find('textarea').val()
								},
								callback: function(data) {
									console.log(data);
								}
							});
						}
					},
					{
						message:'Cancel',
						handler:function() {
							$('#AddWikiTextSDObject').closeModal();
						}
					}
				]
			}
		);
	});
});
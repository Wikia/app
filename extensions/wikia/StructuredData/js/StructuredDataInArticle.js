$('button.add-wikiText-SDObj-from-article').click(function() {
	var objectId = $(this).data('object-id'),
		objectPropName = $(this).data('object-prop-name'),
		modalTitle = 'Add new WikiText Object',
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
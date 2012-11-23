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
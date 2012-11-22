$('button.add-wikiText-SDObj-from-article').click(function() {
	$.nirvana.sendRequest({
		controller: 'StructuredData',
		method: 'showObject',
		type: 'GET',
		format: 'html',
		data: {
			type: 'wikia:WikiText',
			action: 'create'
		},
		callback: function(data) {
			$.showCustomModal(
				'Add new WikiText Object',
				//data,
				'<form class="WikiaForm"><div class="input-group"><label>Name:</label><input type="text" value="" name="schema:name"></div><div class="input-group"><label>WikiText:</label><textarea name="schema:text"></textarea></div></form>',
				{
					id: "AddWikiTextSDObject",
					width: 300,
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
		}
	});
});
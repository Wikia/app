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
				data,
				{
					id: "AddWikiTextSDObject",
					width: 600,
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
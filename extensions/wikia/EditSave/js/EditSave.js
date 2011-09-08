EditSave = {

	settings: {
		interval: 10, // save interval in seconds
		key: 'EditSave/article-' + wgArticleId + '/revision-' + wgCurRevisionId
	},
	
	init: function() {
		// Wait for CK to load
		if ($("#cke_contents_wpTextbox1_sidebar").length == 0) {
			setTimeout(EditSave.init, 1000);
			return;
		}
		
		/* CK loaded */
		
		// check for existing key
		if (localStorage.getItem(EditSave.settings.key)) {
			$('<input type="button" class="editsave-recover-button" onclick="EditSave.recover()" value="Recover lost edit">').appendTo($("#cke_contents_wpTextbox1_sidebar"));
			EditSave.recoveredEdit = localStorage.getItem(EditSave.settings.key);
		}
		setInterval(EditSave.save, EditSave.settings.interval * 1000);
	},
		
	save: function() {
		$().log("EditSave: Saving");
		var value = $('#cke_contents_wpTextbox1').find('iframe').contents().find("body").html();

		try {
			localStorage.setItem(EditSave.settings.key, value);
		} catch (e) {
			if (e == QUOTA_EXCEEDED_ERR) {
				alert('Quota exceeded!');
			}
		}
	},
	
	recover: function() {
		$('#cke_contents_wpTextbox1').find('iframe').contents().find("body").html(EditSave.recoveredEdit);
		$('.editsave-recover-button').remove();
	}
	
};

$(function() {
	if (typeof(localStorage) != 'undefined' && wgArticleId && wgCityId && wgCurRevisionId) {
		EditSave.init();
		$(window).unload(EditSave.save);
	}
});
var computeDraftKey = window.wgPageName + '-draft';

function saveDraft(editorType) {
	try {
		var draftData = {
			editor: editorType,
			mode: RTE.getInstance().mode,
			draftText: RTE.getInstance().getData()
		};

		localStorage.setItem(
			computeDraftKey,
			JSON.stringify(draftData)
		);

	} catch (e) {
		console.log(e);
	}
}

CKEDITOR.on('instanceReady', function () {
	var draftDataJSON = localStorage.getItem(computeDraftKey);

	if (draftDataJSON) {
		var draftData = JSON.parse(draftDataJSON);

		RTE.getInstance().setMode(
			draftData.mode,
			RTE.getInstance().setData(draftData.draftText)
		);
	}

	setInterval(function () {
		saveDraft('CK');
	}, 5000);
});


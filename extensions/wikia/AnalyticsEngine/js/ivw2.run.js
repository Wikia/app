if (window.iam_data) {
	var scriptWriter = ScriptWriter(document, Wikia.log, window);
	scriptWriter.injectScriptByUrl('ivw2_placeholder', 'https://script.ioam.de/iam.js', function () {
		scriptWriter.injectScriptByText('ivw2_placeholder', 'iom.c(iam_data);');
	});
}

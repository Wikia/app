/** Call this to enable suggestions on input (id=inputId), on a form (name=formName) */
function translateImportInit(){
	os_initHandlers( 'mw-translate-up-wiki-input', 'mw-translate-import', document.getElementById('mw-translate-up-wiki-input') );

	jQuery(".mw-translate-import-inputs").each(function(i) {
		os_hookEvent(this, "focus", function(event) {
			var srcid = os_getTarget(event).id;
			var inputid = srcid.replace("-input", "");

			jQuery("#" + inputid).attr("checked", "checked");
		});
	});
}

hookEvent("load", translateImportInit);
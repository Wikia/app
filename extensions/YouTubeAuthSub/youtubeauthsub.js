function checkYTASForm() {
	var title = document.ytas_form.youtube_title.value;
	if (title == "") {
		alert(gYTAS_notitle);
		return false;
	}

	var desc = document.ytas_form.youtube_description.value;

	if (desc == "") {
		alert(gYTAS_nodesc);
		return false;
	}

	var keywords = document.ytas_form.youtube_keywords.value;

	if (keywords == "") {
		alert(gYTAS_nokeywords);
		return false;
	}
	return true;
}

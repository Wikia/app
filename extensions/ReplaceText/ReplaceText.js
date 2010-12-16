function invertSelections() {
	form = document.getElementById('choose_pages');
	num_elements = form.elements.length;
	for (i = 0; i < num_elements; i++) {
		cur_element = form.elements[i];
		if (cur_element.type == "checkbox" && cur_element.id != 'create-redirect' && cur_element.id != 'watch-pages') {
			if (form.elements[i].checked == true)
				form.elements[i].checked = false;
			else
				form.elements[i].checked = true;
		}
	}
}

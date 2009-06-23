var search_term_index = '';

function doSubmit() {
	alert('submitted');
}

function get_search_term() {
	if (!search_terms) {
		search_query = search_site = '';
		return;
	}
	if (!search_term_index) {
		search_term_index = Math.floor(search_terms.length * Math.random());
	} else if (search_term_index == search_terms.length - 1) {
		search_term_index = 0;
	} else {
		search_term_index++;
	}
	//alert(search_term_index + ', ' + search_terms.length);
	search_query = search_terms[search_term_index][0];
	search_site = search_terms[search_term_index][1];
}

function change_search_value() {
	get_search_term();
	searchField.value = search_query;
}

function perform_search() {
	for (i=0; i<search_terms.length; i++) {
		if ( (searchField.value+'').toLowerCase() == search_terms[i][0].toLowerCase()) {
			document.location = 'http://' + search_terms[i][1] + '.wikia.com';
			return false;
		}
	}
	for (i=0; i<search_terms_extra.length; i++) {
		if ( (searchField.value+'').toLowerCase() == search_terms_extra[i][0].toLowerCase()) {
			document.location = 'http://' + search_terms_extra[i][1] + '.wikia.com';
			return false;
		}
	}
	document.location = 'http://www.wikia.com/wiki/Special:Search?search=' + searchField.value;
	return false;
}

function search_field_focus() {
	clearInterval(search_timer);
	searchField.value = '';
}
function search_field_blur() {
	if (searchField.value == '') {
		change_search_value();
		search_timer = setInterval(change_search_value, 5000);
	}
}

YAHOO.util.Event.onDOMReady(function() {
	YAHOO.util.Event.addListener('search_button', "click", perform_search);
	YAHOO.util.Event.addListener('search_field', "focus", search_field_focus);
	YAHOO.util.Event.addListener('search_field', "blur", search_field_blur);
	searchField = YAHOO.util.Dom.get('search_field');
	change_search_value();
	search_timer = setInterval(change_search_value, 5000);
});

function wikia_search() {
	document.location = 'http://re.search.wikia.com/search.html#' + YAHOO.util.Dom.get('wikia_search_field').value;
}

//Add tracking for links
//Author: Maciej Błaszkowski <marooned at wikia-inc.com>
var initTracker = function() {
	var Tracker = YAHOO.Wikia.Tracker;
	var Event = YAHOO.util.Event;

	Event.addListener(['navigation','featured_box','featured_hubs','all_hubs','feature_footer'], 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'IMG') {
			el = el.parentNode;
		}
		if(el.nodeName == 'A') {
			var str  = 'main_page/' + el.id;
			Tracker.trackByStr(e, str);
		}
	});

	// macbre: track clicks on "Create a Wiki" and "Find a Wiki"
	Event.addListener('create-a-wiki', 'click', function() {
		Tracker.trackByStr(null, 'main_page/create_a_wiki');
	});	

	function trackFindWiki() {
		Tracker.trackByStr(null, 'main_page/find_a_wiki');
	}
	Event.addListener('search_button', 'click', trackFindWiki);
	Event.addListener('find_form', 'submit', trackFindWiki);
};

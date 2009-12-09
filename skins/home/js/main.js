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

function perform_search() {
	document.location = 'http://www.wikia.com/wiki/Special:Search?search=' + searchField.value;
	return false;
}

YAHOO.util.Event.onDOMReady(function() {
	YAHOO.util.Event.addListener('search_button', "click", perform_search);
	searchField = YAHOO.util.Dom.get('search_field');
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
		Tracker.trackByStr(null, 'main_page/find_a_wiki/' + searchField.value);
	}
	Event.addListener('search_button', 'click', trackFindWiki);
	Event.addListener('find_form', 'submit', trackFindWiki);
};

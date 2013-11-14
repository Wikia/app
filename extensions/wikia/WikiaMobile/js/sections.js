/*
 * @define sections
 * module used to handle sections on wikiamobile
 *
 * @author Jakub Olek
 */

define('sections', ['jquery', 'wikia.window'], function($, window){
	'use strict';

	var d = document,
		sections = $('h2[id],h3[id],h4[id]', document.getElementById('wkPage')).toArray(),
		l = sections.length,
		lastSection;

	function scrollTo(header){
		//() and . have to be escaped before passed to querySelector
		var h = document.getElementById(header.replace(/[()\.]/g, '\\$&') ),
			ret;

		if ( h ) {
			h.scrollIntoView();
			ret = true;
		}

		return ret;
	}

	function current(){
		var top = window.scrollY,
			i = 0;

		for(;i < l;i++) {
			if(sections[i].offsetTop - 5 > top) {
				break;
			}
		}

		return $(sections[i-1]);
	}

	lastSection = current();

	function onScroll(){
		var currentSection = current();

		window.removeEventListener('scroll', onScroll);

		if(currentSection && !currentSection.is(lastSection)) {
			$(d).trigger('section:changed', {
				section: currentSection,
				id: currentSection.length ? currentSection[0].id : undefined
			});

			lastSection = currentSection;
		}

		window.setTimeout(function(){
			window.addEventListener('scroll', onScroll);
		}, 200);
	}

	window.addEventListener('scroll', onScroll);

	return {
		list: sections,
		scrollTo: scrollTo,
		current: current
	};
});

/*global define */

//init toc
define('toc', ['track', 'sections', 'wikia.window', 'jquery', 'wikia.mustache'], function toc(track, sections, w, $, mustache){
	'use strict';

	//private
	var d = w.document,
		$body = $(d.body),
		table = [],
		conStyle,
		tocCache;

	$('#wkTOCHandle').on('click', function(){
		$body.toggleClass('TOCOpen hidden');
	})

	function open(){
		$body.addClass('TOCOpen hidden');
	}

	function close(){
		$body.removeClass('TOCOpen hidden ');
	}

	function init(){
		//init only if toc is on a page
		table = $body.find('#toc.toc');

		if(table.length){
			d.getElementById('toctitle').insertAdjacentHTML('afterbegin', '<span class=chev></span>');
			$body.addClass('hasToc');
			conStyle = d.getElementById('mw-content-text').style;

			table.on('click', function(event){
				event.preventDefault();

				var	target = event.target,
					a = (target.nodeName === 'A');

				//if anchor was clicked dont trigger tracking event of close
				(table.hasClass('open') ? close : open)(a);

				if(a){
					track.event('toc', track.CLICK, {label: 'element'});

					sections.open(target.getAttribute('href').substr(1), true);
				}
			});
		}
	}

	function get() {
		if(!tocCache){
			var headers = document.querySelectorAll('h2,h3,h4'),
				tmp = [],
				i = 0,
				l = headers.length,
				lastLevel = 0,
				header,
				level,
				section,
				childrenLevel,
				childrenUpLevel;

			for(;i < l;i++) {
				header = headers[i];
				level = parseInt(header.nodeName.slice(1), 10) - 2;

				if(!tmp[level]) {
					tmp[level] = [];
				}

				section = {
					id: header.id,
					name: header.textContent,
					level: level +1
				};

				while(level < lastLevel) {
					childrenLevel = tmp[lastLevel];
					childrenUpLevel = tmp[lastLevel-1];

					childrenUpLevel[childrenUpLevel.length-1].children = childrenLevel.slice();

					childrenLevel.length = 0;
					lastLevel--;
				}

				tmp[level].push(section);

				lastLevel = level;
			}

			tocCache = tmp[0];
		}

		return tocCache;
	}

	var tocc =  {
			level: 0,
			children: get()
		};

	var ol = "<ol class='toc-list level{{level}}'>{{#children}}{{> lis}}{{/children}}</ol>",
		lis = "{{#.}}<li {{#children.length}}class=has-children{{/children.length}}><a href='#{{id}}'>{{name}}</a>{{#children.length}}{{#level}}<span class='chevron right'></span>{{/level}}{{/children.length}}{{#children.length}}{{> ol}}{{/children.length}}</li>{{/.}}";

	$('#wkTOC')
		.append(mustache.render(ol, tocc, {
			ol: ol,
			lis: lis
		}))
		.on('click','li', function(event){
			var $li = $(this),
				$a = $li.find('a').first();

			event.stopPropagation();
			event.preventDefault();

			sections.open($a.attr('href').slice(1), true);

			if($li.is('.has-children')) {
				$li.toggleClass('open');
			}
		});

	return {
		init: init,
		open: open,
		close: close,
		get: get
	};
});
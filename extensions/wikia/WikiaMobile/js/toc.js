/*global define */

//init toc
define('toc', ['track', 'sections', 'wikia.window', 'jquery', 'wikia.mustache'], function toc(track, sections, w, $, mustache){
	'use strict';

	//private
	var d = w.document,
		$body = $(d.body),
		table = [],
		conStyle,
		tocCache,
		$anchors,
		timer,
		$openOl;

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
					level: level + 1,
					firstLevel: level + 1 === 1
				};

				while(level < lastLevel) {
					childrenLevel = tmp[lastLevel];
					childrenUpLevel = tmp[lastLevel-1];
					if (childrenUpLevel.length) {
						childrenUpLevel[childrenUpLevel.length-1].children = childrenLevel.slice();

						childrenLevel.length = 0;
					} else {
						//that means there is something like h2 > h4. Fix it by moving it one level up
						tmp[lastLevel-1] = childrenLevel.slice();
					}

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
		},
		ol = "<ol class='toc-list level{{level}}'>{{#children}}{{> lis}}{{/children}}</ol>",
		lis = "{{#.}}<li {{#children.length}}class=has-children{{/children.length}}><a href='#{{id}}'>{{name}}{{#firstLevel}}{{#children.length}}<span class='chevron right'></span>{{/children.length}}{{/firstLevel}}</a>{{#children.length}}{{> ol}}{{/children.length}}</li>{{/.}}",
		$ol;

	$ol = $('#wkTOC')
		.append(mustache.render(ol, tocc, {
			ol: ol,
			lis: lis
		}))
		.on('click', 'header', function(){
			window.scrollTo(0,0);
		})
		.on('click','li', function(event){
			var $li = $(this),
				$a = $li.find('a').first();

			event.stopPropagation();
			event.preventDefault();

			//() and . have to be escaped before passed to querySelector
			sections.scrollTo($($a.attr('href').replace(/[()\.]/g, '\\$&')));

			if($li.is('.has-children') && $li.parent().is('.level0')) {
				$li.toggleClass('fixed open').siblings().removeClass('fixed open');
				$ol.scrollTop(this.offsetTop - 45);

				if($li.hasClass('open')) {
					$openOl = $li.find('ol').first();
				}else {
					$openOl = null;
				}
			}
		})
		.find('.level0')
		.on('scroll', function(event){
			var self = this;
			if(!timer) {
				timer = setTimeout(function(){
					timer = null;

					var $active,
						scrollTop,
						offsetTop,
						$parent;

					if($openOl) {
						scrollTop = self.scrollTop + 90;
						offsetTop = $openOl[0].offsetTop;
						$parent = $openOl.parent();

						if(scrollTop < offsetTop) {
							$parent.removeClass('fixed');
						} else if (scrollTop >= offsetTop) {
							var x = 0;

							if($parent.hasClass('bottom')) {
								x = 45;
							}

							if(offsetTop + $openOl[0].offsetHeight - scrollTop+ x >= 0){
								$parent.removeClass('bottom').addClass('fixed');
							} else {
								$parent.removeClass('fixed').addClass('bottom');
							}
						}
					}
				}, 50);
			}

		});

	$anchors = $ol.find('li > a');

	$(d).on('section:changed', function(event, data) {
		if(data.id) {
			var $currentAchor = $anchors
				.removeClass('current')
				.filter('a[href="#' + data.id + '"]')
				.addClass('current');

			$currentAchor
				.parents('li')
				.last()
				.find('a')
				.first()
				.addClass('current');

			//$ol.scrollTop($currentAchor.offset().top - 45);

		}

	});

	$('#wkTOCHandle').on('click', function(){
		$body.toggleClass('TOCOpen hidden');
	});

	return {
		init: init,
		open: open,
		close: close,
		get: get
	};
});
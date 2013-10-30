//init toc
require(['sections', 'wikia.window', 'jquery', 'wikia.mustache', 'wikia.toc'],
    function (sections, window, $, mustache, toc){
	'use strict';

	//private
	var $document = $(window.document),
		$anchors,
		timer,
		$openOl,
		state,
		offsetTop = 0,
		$parent,
		ol = "<ol class='toc-list level{{level}}'>{{#sections}}{{> lis}}{{/sections}}</ol>",
		lis = "{{#.}}<li {{#sections.length}}class=has-children{{/sections.length}}><a href='#{{id}}'>{{name}}{{#firstLevel}}{{#sections.length}}<span class='chevron right'></span>{{/sections.length}}{{/firstLevel}}</a>{{#sections.length}}{{> ol}}{{/sections.length}}</li>{{/.}}",
		$toc,
		$ol,
		tocData = toc.getData(sections.list, function(header, level){
			return {
				id: header.id,
				name: header.textContent,
				level: level,
				firstLevel: level === 2,
				sections: []
			};
		});

	function toggleLi($li, force){
		if($li.is('.has-children') && $li.parent().is('.level')) {
			$li.siblings().removeClass('fixed bottom open');

			if($li.toggleClass('open', force).hasClass('open')) {
				$openOl = $li.find('ol').first();
				offsetTop = $openOl[0].offsetTop;
				$parent = $openOl.parent();

				handleFixingLiElement();
			}else {
				state = null;
				$li.removeClass('fixed bottom');

				$openOl = null;
			}

			$ol.scrollTop($li[0].offsetTop - 45);
		}
	}

	function handleFixingLiElement(){
		var scrollTop,
			self = $ol[0];

		if(!timer && $openOl) {
			timer = setTimeout(function(){
				timer = null;

				scrollTop = self.scrollTop + 90;

				if(state !== 'disabled' && scrollTop < offsetTop) {
					state = 'disabled';
					$parent.removeClass('fixed');
				} else if (scrollTop >= offsetTop) {
					if(offsetTop + $openOl[0].offsetHeight - scrollTop >= 0) {
						if(state !== 'fixed') {
							state = 'fixed';
							$parent.removeClass('bottom').addClass('fixed');
						}
					} else if (state !== 'bottom') {
						state = 'bottom';
						$parent.addClass('bottom');
					}
				}
			}, 10);
		}
	}

	$toc = $('#wkTOC')
		.append(mustache.render(ol, tocData, {
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

			toggleLi($li);
		});

	$ol = $toc.find('.level')
		.on('scroll', handleFixingLiElement);

	$anchors = $ol.find('li > a');

	function onSectionChange(event, data, scrollTo){
		$anchors.filter('.current').removeClass('current');

		if(data && data.id) {
			var $current = $anchors
					.filter('a[href="#' + data.id + '"]')
					.addClass('current'),
				$currentLi = $current
					.parents('li')
					.last();

			$currentLi
					.find('a')
					.first()
					.addClass('current');

			if(scrollTo){
				toggleLi($currentLi, true);
				$ol.scrollTop($current.parent()[0].offsetTop - 90);
			}
		}
	}

	$document.on('curtain:hide', function(){
		$toc.removeClass('active');
		$.event.trigger('ads:unfix');
		onClose();
	});

	function onOpen() {
		$document.on('section:changed', onSectionChange);

		onSectionChange(null, sections.current()[0], true);
	}

	function onClose() {
		$document.off('section:changed', onSectionChange);
	}

	$('#wkTOCHandle').on('click', function(){
		if($toc.toggleClass('active').hasClass('active')){
			onOpen();
		}else {
			onClose();
		}
		$.event.trigger('curtain:toggle');
	});
});

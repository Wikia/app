define('ext.wikia.curatedTour.grabElement',
	[
		'jquery',
	],
	function ($) {
		'use strict';
		var $hover = $('<div></div>')
				.css({
					position:'absolute',
					background:'#002e54',
					'z-index': '1059',
					opacity:0.75,
					'pointer-events':'none'
				})
				.attr('id', ('curatedTourHover')),
		inside = false,
		lock = false,
		$a,
		selectedElement = {},
		$body,
		$popover,
		$content,
		$title,
		$addBtn,
		$titleTextarea,
		$contentTextarea,
		addItemToListCallback;

		appendBody($hover);

		function init(callback) {
			addItemToListCallback = callback;
			console.log('grabElement loaded');

			$('#WikiaPage *').mouseenter($.throttle(50, handlerIn)).mouseleave($.throttle(50, handlerOut));

			setupPopover();
			$('html').click(
				function (a) {
					a.preventDefault();
					if (!selectedElement.path || lock) {
						return;
					}
					console.log('Path of clicked element: ' + selectedElement.path);
					freeze();
				}
			);
		}

		function freeze() {
			lock = true;
			$hover.hide();
			var $topCover = $('<div></div>'),
				$leftCover = $('<div></div>'),
				$rightCover = $('<div></div>'),
				$bottomCover = $('<div></div>');
			$topCover.css({
				position: 'absolute',
				top: 0,
				left: 0,
				'z-index': '1059',
				opacity: 0.75,
				background: '#002e54',
				height:selectedElement.posY,
				width: '100%'
			});
			$bottomCover.css({
				position: 'absolute',
				top: selectedElement.posY + selectedElement.height,
				left: 0,
				'z-index': '1059',
				opacity: 0.75,
				background: '#002e54',
				height: $('html').height() - selectedElement.posY - selectedElement.height,
				width: '100%'
			});
			$leftCover.css({
				position: 'absolute',
				top: selectedElement.posY,
				left: 0,
				'z-index': '1059',
				opacity: 0.75,
				background: '#002e54',
				height:selectedElement.height,
				width: selectedElement.posX
			});
			$rightCover.css({
				position: 'absolute',
				top: selectedElement.posY,
				left: selectedElement.posX + selectedElement.width,
				'z-index': '1059',
				opacity: 0.75,
				background: '#002e54',
				height: selectedElement.height,
				width: '100%'
			});
			$('body').append($topCover);
			$('body').append($bottomCover);
			$('body').append($leftCover);
			$('body').append($rightCover);

			addPopover();
		}

		function handlerIn(a) {
			if (lock) {
				return;
			}
			var offset;
			inside = true;
			$a = $(a.target);
			selectedElement.path = $a.getPath();
			offset = $a.offset();
			selectedElement.posY = offset.top;
			selectedElement.posX = offset.left;
			selectedElement.width = $a.outerWidth();
			selectedElement.height = $a.outerHeight();
			$hover.css({
				width:selectedElement.width,
				height:selectedElement.height,
				top: selectedElement.posY,
				left: selectedElement.posX
			});
			$hover.show();
		}

		function handlerOut() {
			$hover.hide();
		}

		function setupPopover() {
			var $arrow = $('<div></div>').addClass('arrow');
			$content = $('<div></div>').addClass('popover-content');
			$title = $('<div></div>').addClass('popover-title');
			$popover = $('<div></div>');
			$popover.css({
				background: '#fff',
				width: '400px'
			});
			$addBtn = $('<a class="ct-popover-add-btn wikia-button primary">Add</a>');
			$addBtn.click(addTripItem);
			$popover
				.addClass('popover bottom')
				.append($arrow, $title, $content)
				.hide();
			appendBody($popover);
		}

		function addPopover() {
			$titleTextarea = $('<textarea placeholder="Title (optional)"></textarea>');
			$contentTextarea = $('<textarea placeholder="Provide your words for a user" rows="4"></textarea>');
			$title.html($titleTextarea);
			$content.html($contentTextarea);
			$content.append($addBtn);
			$popover.css({
				top: selectedElement.posY + selectedElement.height,
				left: selectedElement.posX + 0.5 * selectedElement.width - $popover.width() * 0.5,
			});
			$popover.show();
		}

		function addTripItem(e) {
			var itemData = {
				Selector: selectedElement.path,
				PageName: wgPageName,
				Notes: $contentTextarea.html()
			};
			addItemToListCallback(itemData);
		}

		function appendBody(element) {
			if (typeof $body === 'undefined') {
				$body = $('body');
			}
			$body.append(element);
		}

		$.fn.extend({
			getPath: function () {
				var path, node = this, allSiblings;
				while (node.length) {
					var realNode = node[0], name = realNode.localName;
					if (!name) break;
					name = name.toLowerCase();

					var parent = node.parent();

					var sameTagSiblings = parent.children(name);
					if (sameTagSiblings.length > 1) {
						allSiblings = parent.children();
						var index = allSiblings.index(realNode) + 1;
						if (index > 1) {
							name += ':nth-child(' + index + ')';
						}
					}

					path = name + (path ? '>' + path : '');
					node = parent;
				}

				return path;
			}
		});

		return {
			init: init
		};
	}
)

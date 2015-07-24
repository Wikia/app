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
					'z-index': '999999999',
					opacity:0.75,
					'pointer-events':'none'
				})
				.attr('id', ('curatedTourHover')),
		inside = false,
		lock = false,
		$a,
		selectedElement = {};
		$('body').append($hover);

		function init() {
			console.log('grabElement loaded');

			$('#WikiaPage *').mouseenter($.throttle(50, handlerIn)).mouseleave($.throttle(50, handlerOut));

			$('html').click(
				function (a, b, c) {
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
				'z-index': '999999999',
				opacity: 0.75,
				background: '#002e54',
				height:selectedElement.posY,
				width: '100%'
			});
			$bottomCover.css({
				position: 'absolute',
				top: selectedElement.posY + selectedElement.height,
				left: 0,
				'z-index': '999999999',
				opacity: 0.75,
				background: '#002e54',
				height: $('html').height() - selectedElement.posY - selectedElement.height,
				width: '100%'
			});
			$leftCover.css({
				position: 'absolute',
				top: selectedElement.posY,
				left: 0,
				'z-index': '999999999',
				opacity: 0.75,
				background: '#002e54',
				height:selectedElement.height,
				width: selectedElement.posX
			});
			$rightCover.css({
				position: 'absolute',
				top: selectedElement.posY,
				left: selectedElement.posX + selectedElement.width,
				'z-index': '999999999',
				opacity: 0.75,
				background: '#002e54',
				height: selectedElement.height,
				width: '100%'
			});
			$('body').append($topCover);
			$('body').append($bottomCover);
			$('body').append($leftCover);
			$('body').append($rightCover);


			//$a.popover('show');
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

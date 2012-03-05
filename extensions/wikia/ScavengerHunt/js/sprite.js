/*
 * Object helper for managing and displaying sprites, parts of big image
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-06-06
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
var Sprite = {
	//URL to sprite image
	URL: null,

	//array of sprites
	sprites: [],

	//default z-index
	zIndex: 1,

	//console logging
	log: function(msg) {
		$().log(msg, 'Sprite');
	},

	//clear state in object
	clearState: function() {
		this.URL = null;
		this.sprites = [];
		this.zIndex = 1;
	},

	//set global URL to sprite image
	setURL: function(URL) {
		this.log('setting URL sprite to: ' + URL);
		this.URL = URL;
	},

	//data is object:
	//{
	// pos: {x, y}     - required                      - position relative to parent
	// TL: {x, y}      - required                      - top-left position on sprite
	// BR: {x, y}      - required                      - bottom-right position on sprite
	// parent:         - optional, default `document`  - DOM node, or jQuery object, or jQuery selector
	// zIndex:         - optional, default `1`         - z-index absolute number
	// cssClass:       - optional                      - string with CSS classes
	// data:           - optional                      - object set with element [using jQuery .data()]
	// events:         - optional                      - object with handlers to attach to element [using jQuery .bind()]
	//}
	addSprite: function(spriteData) {
		this.log('adding sprite');
		this.log(spriteData);

		if (!spriteData.pos || !spriteData.TL || !spriteData.BR ||
			!spriteData.pos.hasOwnProperty('x') ||
			!spriteData.pos.hasOwnProperty('y') ||
			!spriteData.TL.hasOwnProperty('x') ||
			!spriteData.TL.hasOwnProperty('y') ||
			!spriteData.BR.hasOwnProperty('x') ||
			!spriteData.BR.hasOwnProperty('y')) {
			this.log('no required data - exiting...');
			return false;
		}

		var parent;
		if (spriteData.parent) {
			if (typeof spriteData.parent == 'string') {
				//selector
				parent = $(spriteData.parent);
			} else if (typeof spriteData.parent.jquery == 'string') {
				//jQuery object
				parent = spriteData.parent;
			} else if (spriteData.parent.nodeType == Node.ELEMENT_NODE) {
				//DOM node
				parent = $(spriteData.parent);
			}
		} else {
			//default
			parent = document;
		}

		return this.sprites.push({
			BR: spriteData.BR,
			TL: spriteData.TL,
			cssClass: spriteData.cssClass || '',
			data: spriteData.data || {},
			events: spriteData.events || {},
			id: spriteData.id,
			parent: parent,
			pos: spriteData.pos,
			zIndex: spriteData.zIndex || this.zIndex
		});
	},

	preload: function() {
		if (this.URL) {
			this.log('preloading sprite...');
			var tmpImg = new Image();
			tmpImg.src = this.URL;
		}
	},

	display: function(index) {
		this.log('displaying sprites');

		if (!Sprite.URL) {
			this.log('error: no URL to sprite');
			return false;
		}

		if (index) {
			Sprite.log('displaying one sprite no. ' + (index-1));
			Sprite.log(Sprite.sprites[index-1]);
			this.displayOneSprite(Sprite.sprites[index-1]);
		} else {
			$.each(this.sprites, function(k, v) {
				Sprite.log('displaying sprite no. ' + k);
				Sprite.log(v);
				Sprite.log(v.data);
				Sprite.displayOneSprite(v);
			});
		}
	},

	displayOneSprite: function(spriteData) {
		var el = $('<div>');
		if (spriteData.id) {
			el.attr('id', spriteData.id);
		}
		if (spriteData.data) {
			el.data(spriteData.data);
		}
		if (spriteData.cssClass) {
			el.addClass(spriteData.cssClass);
		}
		if (spriteData.events) {
			el.bind(spriteData.events);
		}
		el.css({
			backgroundImage: 'url("' + Sprite.URL + '")',
			backgroundPosition: '-' + spriteData.TL.x + 'px -' + spriteData.TL.y + 'px',
			left: spriteData.pos.x + 'px',
			top: spriteData.pos.y + 'px',
			height: (spriteData.BR.y - spriteData.TL.y) + 'px',
			width: (spriteData.BR.x - spriteData.TL.x) + 'px',
			zIndex: spriteData.zIndex
		})
		.appendTo(spriteData.parent);
	},

	//adds sprite to existing collection and displays it
	insertSprite: function(spriteData) {
		var index = this.addSprite(spriteData);
		if (index) {
			this.display(index);
		}
	},

	changeSprite: function(element, spriteData) {
		this.log('changing sprite');
		if (!element.exists() || !spriteData) {
			return false;
		}
		if (spriteData.data) {
			element.data(spriteData.data);
		}
		if (spriteData.cssClass) {
			element.removeClass().addClass(spriteData.cssClass);
		}
		if (spriteData.events) {
			element.unbind().bind(spriteData.events);
		}
		element.css({
			backgroundImage: 'url("' + Sprite.URL + '")',
			backgroundPosition: '-' + spriteData.TL.x + 'px -' + spriteData.TL.y + 'px',
			left: spriteData.pos.x + 'px',
			top: spriteData.pos.y + 'px',
			height: (spriteData.BR.y - spriteData.TL.y) + 'px',
			width: (spriteData.BR.x - spriteData.TL.x) + 'px',
			zIndex: spriteData.zIndex
		});
	}
};
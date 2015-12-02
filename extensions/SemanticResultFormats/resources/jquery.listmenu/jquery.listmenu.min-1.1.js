/*
*
* jQuery listmenu plugin
* Copyright (c) 2009 iHwy, Inc.
* Author: Jack Killpatrick
*
* Version 1.1 (08/09/2009)
* Requires jQuery 1.3.2 or jquery 1.2.6
*
* Visit http://www.ihwy.com/labs/jquery-listmenu-plugin.aspx for more information.
*
* Dual licensed under the MIT and GPL licenses:
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*
*/

(function($) {
	$.fn.listmenu = function(options) {
		var opts = $.extend({}, $.fn.listmenu.defaults, options); var alph = ['_', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '-']; return this.each(function() {
			var $wrapper, list, $list, $letters, letters = {}, $letterCount, id, $menu, colOpts = $.extend({}, $.fn.listmenu.defaults.cols, opts.cols), onNav = false, onMenu = false, currentLetter = ''; id = this.id; $list = $(this); function init() { $list.css('visibility', 'hidden'); setTimeout(function() { $list.before(createWrapperHtml()); $wrapper = $('#' + id + '-menu'); $wrapper.append(createLettersHtml()); $letters = $('.lm-letters', $wrapper).slice(0, 1); if (opts.showCounts) $letterCount = $('.lm-letter-count', $wrapper).slice(0, 1); $wrapper.append(createMenuHtml()); $menu = $('.lm-menu', $wrapper); populateMenu(); if (opts.flagDisabled) addDisabledClass(); bindHandlers(); if (!opts.includeNums) $('._', $letters).remove(); if (!opts.includeOther) $('.-', $letters).remove(); $(':last', $letters).addClass('lm-last'); $wrapper.show(); }, 50); }
			function setLetterCountTop() { $letterCount.css({ top: $('.a', $letters).slice(0, 1).offset({ margin: false, border: true }).top - $letterCount.outerHeight({ margin: true }) }); }
			function addDisabledClass() { for (var i = 0; i < alph.length; i++) { if (letters[alph[i]] == undefined) $('.' + alph[i], $letters).addClass('lm-disabled'); } }
			function populateMenu() {
				var gutter = colOpts.gutter, cols = colOpts.count, menuWidth, colWidth; if (opts.menuWidth) menuWidth = opts.menuWidth; else menuWidth = $('.lm-letters', $wrapper).width() - ($menu.outerWidth() - $menu.width()); colWidth = (cols == 1) ? menuWidth : Math.floor((menuWidth - (gutter * (cols - 1))) / cols); $menu.width(menuWidth); $list.width(colWidth); var letter, outerHeight; $list.children().each(function() {
					str = $(this).text().replace(/\s+/g, ''); if (str != '') { firstChar = str.slice(0, 1).toLowerCase(); if (/\W/.test(firstChar)) firstChar = '-'; if (!isNaN(firstChar)) firstChar = '_'; }
					outerHeight = $(this).outerHeight(); if (letters[firstChar] == undefined) letters[firstChar] = { totHeight: 0, count: 0, colHeight: 0, hasMenu: false }; letter = letters[firstChar]; letter.totHeight += outerHeight; letter.count++; $.data($(this)[0], id, { firstChar: firstChar, height: outerHeight });
				}); $.each(letters, function() { this.colHeight = (this.count > 1) ? Math.ceil(this.totHeight / cols) : this.totHeight; }); var $this, data, iHeight, iLetter, cols = {}, c; var tagName = $list[0].tagName.toLowerCase(); $list.children().each(function() {
					$this = $(this); data = $.data($this.get(0), id); iLetter = data.firstChar; iHeight = data.height; if (!letters[l = iLetter].hasMenu) { $menu.append('<div class="lm-submenu ' + iLetter + '" style="display:none;"></div>'); letters[iLetter].hasMenu = true; }
					if (cols[iLetter] == undefined) cols[iLetter] = { height: 0, colNum: 0, itemCount: 0, $colRoot: null }; c = cols[iLetter]; c.itemCount++; if (c.height == 0) { c.colNum++; $('.lm-submenu.' + iLetter, $menu).append('<div class="lm-col c' + c.colNum + '"><' + tagName + ((tagName == 'ol') ? ' start="' + c.itemCount + '"' : '') + ' id="lm-' + id + '-' + iLetter + '-' + c.colNum + '" class="lm-col-root"></' + tagName + '></div>'); }
					$('#lm-' + id + '-' + iLetter + '-' + c.colNum).append($(this)); c.height += iHeight; if (c.height >= letters[iLetter].colHeight) c.height = 0;
				}); $.each(letters, function(idx) { if (this.hasMenu) { $('.lm-submenu.' + idx + ' .lm-col', $menu).css({ 'width': colWidth, 'float': 'left' }); $('.lm-submenu.' + idx + ' .lm-col:not(:last)', $menu).css({ 'marginRight': gutter }); } }); $menu.append('<div class="lm-no-match" style="display:none">' + opts.noMatchText + '</div>'); $list.remove();
			}
			function getLetterCount(el) { var letter = letters[$(el).attr('class').split(' ')[0]]; return (letter != undefined) ? letter.count : 0; }
			function hideCurrentSubmenu() { if (currentLetter != '') $('.lm-submenu.' + currentLetter, $menu).hide(); $('.lm-no-match', $menu).hide(); }
			function bindHandlers() {
				if (opts.showCounts) { $wrapper.mouseover(function() { setLetterCountTop(); }); }
				$('a', $letters).click(function() { $(this).blur(); return false; }); $letters.hover(function() { onNav = true; }, function() { onNav = false; setTimeout(function() { if (!onMenu) { $('a.lm-selected', $letters).removeClass('lm-selected'); $('.lm-menu', $wrapper).hide(); hideCurrentSubmenu(); currentLetter = ''; } }, 10); }); $('a', $letters).mouseover(function() {
					var count = getLetterCount(this); var $this = $(this); if (opts.showCounts) { var left = $this.position().left; var width = $this.outerWidth({ margin: true }); if (opts.showCounts) $letterCount.css({ left: left, width: width + 'px' }).text(count).show(); }
					var newLetter = $this.attr('class').split(' ')[0]; if (newLetter != currentLetter) {
						if (currentLetter != '') { hideCurrentSubmenu(); $('a.lm-selected', $letters).removeClass('lm-selected'); }
						$this.addClass('lm-selected'); if (count > 0) $('.lm-submenu.' + newLetter, $wrapper).show(); else $('.lm-no-match', $wrapper).show(); if (currentLetter == '') $('.lm-menu', $wrapper).show(); currentLetter = newLetter;
					} 
				}); $('a', $letters).mouseout(function() { if (opts.showCounts) $letterCount.hide(); }); $menu.hover(function() { onMenu = true; }, function() { onMenu = false; setTimeout(function() { if (!onNav) { $('a.lm-selected', $letters).removeClass('lm-selected'); $('.lm-menu', $wrapper).hide(); hideCurrentSubmenu(); currentLetter = ''; } }, 10); }); if (opts.onClick != null) { $menu.click(function(e) { var $target = $(e.target); opts.onClick($target); return false; }); } 
			}
			function createLettersHtml() {
				var html = []; for (var i = 1; i < alph.length; i++) { if (html.length == 0) html.push('<a class="_" href="#">0-9</a>'); html.push('<a class="' + alph[i] + '" href="#">' + ((alph[i] == '-') ? '...' : alph[i].toUpperCase()) + '</a>'); }
				return '<div class="lm-letters">' + html.join('') + '</div>' + ((opts.showCounts) ? '<div class="lm-letter-count" style="display:none; position:absolute; top:0; left:0; width:20px;">0</div>' : '');
			}
			function createMenuHtml() { return '<div class="lm-menu"></div>'; }
			function createWrapperHtml() { return '<div id="' + id + '-menu" class="lm-wrapper"></div>'; }
			init();
		});
	}; $.fn.listmenu.defaults = { includeNums: true, includeOther: false, flagDisabled: true, noMatchText: 'No matching entries', showCounts: true, menuWidth: null, cols: { count: 4, gutter: 40 }, onClick: null };
})(jQuery);

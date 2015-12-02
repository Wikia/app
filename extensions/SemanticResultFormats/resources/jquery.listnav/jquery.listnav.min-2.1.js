/*
*
* jQuery listnav plugin
* Copyright (c) 2009 iHwy, Inc.
* Author: Jack Killpatrick
*
* Version 2.1 (08/09/2009)
* Requires jQuery 1.3.2, jquery 1.2.6 or jquery 1.2.x plus the jquery dimensions plugin
*
* Visit http://www.ihwy.com/labs/jquery-listnav-plugin.aspx for more information.
*
* Dual licensed under the MIT and GPL licenses:
*   http://www.opensource.org/licenses/mit-license.php
*   http://www.gnu.org/licenses/gpl.html
*
*/

(function($) {
	$.fn.listnav = function(options) {
		var opts = $.extend({}, $.fn.listnav.defaults, options); var letters = ['_', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '-']; var firstClick = false; opts.prefixes = $.map(opts.prefixes, function(n) { return n.toLowerCase(); }); return this.each(function() {
			var $wrapper, list, $list, $letters, $letterCount, id; id = this.id; $wrapper = $('#' + id + '-nav'); $list = $(this); var counts = {}, allCount = 0, isAll = true, numCount = 0, prevLetter = ''; function init() {
				$wrapper.append(createLettersHtml()); $letters = $('.ln-letters', $wrapper).slice(0, 1); if (opts.showCounts) $letterCount = $('.ln-letter-count', $wrapper).slice(0, 1); addClasses(); addNoMatchLI(); if (opts.flagDisabled) addDisabledClass(); bindHandlers(); if (!opts.includeAll) $list.show(); if (!opts.includeAll) $('.all', $letters).remove(); if (!opts.includeNums) $('._', $letters).remove(); if (!opts.includeOther) $('.-', $letters).remove(); $(':last', $letters).addClass('ln-last'); if ($.cookie && (opts.cookieName != null)) { var cookieLetter = $.cookie(opts.cookieName); if (cookieLetter != null) opts.initLetter = cookieLetter; }
				if (opts.initLetter != '') { firstClick = true; $('.' + opts.initLetter.toLowerCase(), $letters).slice(0, 1).click(); }
				else { if (opts.includeAll) $('.all', $letters).addClass('ln-selected'); else { for (var i = ((opts.includeNums) ? 0 : 1); i < letters.length; i++) { if (counts[letters[i]] > 0) { firstClick = true; $('.' + letters[i], $letters).slice(0, 1).click(); break; } } } } 
			}
			function setLetterCountTop() { $letterCount.css({ top: $('.a', $letters).slice(0, 1).offset({ margin: false, border: true }).top - $letterCount.outerHeight({ margin: true }) }); }
			function addClasses() {
				var str, firstChar, firstWord, spl, $this, hasPrefixes = (opts.prefixes.length > 0); $($list).children().each(function() {
					$this = $(this), firstChar = '', str = $.trim($this.text()).toLowerCase(); if (str != '') {
						if (hasPrefixes) { spl = str.split(' '); if ((spl.length > 1) && ($.inArray(spl[0], opts.prefixes) > -1)) { firstChar = spl[1].charAt(0); addLetterClass(firstChar, $this, true); } }
						firstChar = str.charAt(0); addLetterClass(firstChar, $this);
					} 
				});
			}
			function addLetterClass(firstChar, $el, isPrefix) { if (/\W/.test(firstChar)) firstChar = '-'; if (!isNaN(firstChar)) firstChar = '_'; $el.addClass('ln-' + firstChar); if (counts[firstChar] == undefined) counts[firstChar] = 0; counts[firstChar]++; if (!isPrefix) allCount++; }
			function addDisabledClass() { for (var i = 0; i < letters.length; i++) { if (counts[letters[i]] == undefined) $('.' + letters[i], $letters).addClass('ln-disabled'); } }
			function addNoMatchLI() { $list.append('<li class="ln-no-match" style="display:none">' + opts.noMatchText + '</li>'); }
			function getLetterCount(el) { if ($(el).hasClass('all')) return allCount; else { var count = counts[$(el).attr('class').split(' ')[0]]; return (count != undefined) ? count : 0; } }
			function bindHandlers() {
				if (opts.showCounts) { $wrapper.mouseover(function() { setLetterCountTop(); }); }
				if (opts.showCounts) { $('a', $letters).mouseover(function() { var left = $(this).position().left; var width = ($(this).outerWidth({ margin: true }) - 1) + 'px'; var count = getLetterCount(this); $letterCount.css({ left: left, width: width }).text(count).show(); }); $('a', $letters).mouseout(function() { $letterCount.hide(); }); }
				$('a', $letters).click(function() {
					$('a.ln-selected', $letters).removeClass('ln-selected'); var letter = $(this).attr('class').split(' ')[0]; if (letter == 'all') { $list.children().show(); $list.children('.ln-no-match').hide(); isAll = true; } else {
						if (isAll) { $list.children().hide(); isAll = false; } else if (prevLetter != '') $list.children('.ln-' + prevLetter).hide(); var count = getLetterCount(this); if (count > 0) { $list.children('.ln-no-match').hide(); $list.children('.ln-' + letter).show(); }
						else $list.children('.ln-no-match').show(); prevLetter = letter;
					}
					if ($.cookie && (opts.cookieName != null)) $.cookie(opts.cookieName, letter); $(this).addClass('ln-selected'); $(this).blur(); if (!firstClick && (opts.onClick != null)) opts.onClick(letter); else firstClick = false; return false;
				});
			}
			function createLettersHtml() {
				var html = []; for (var i = 1; i < letters.length; i++) { if (html.length == 0) html.push('<a class="all" href="#">ALL</a><a class="_" href="#">0-9</a>'); html.push('<a class="' + letters[i] + '" href="#">' + ((letters[i] == '-') ? '...' : letters[i].toUpperCase()) + '</a>'); }
				return '<div class="ln-letters">' + html.join('') + '</div>' + ((opts.showCounts) ? '<div class="ln-letter-count" style="display:none; position:absolute; top:0; left:0; width:20px;">0</div>' : '');
			}
			init();
		});
	}; $.fn.listnav.defaults = { initLetter: '', includeAll: true, incudeOther: false, includeNums: true, flagDisabled: true, noMatchText: 'No matching entries', showCounts: true, cookieName: null, onClick: null, prefixes: [] };
})(jQuery);

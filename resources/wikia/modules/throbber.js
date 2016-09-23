/**
 * throbber module:
 *  * jQuery
 */
define('wikia.throbber', ['jquery'], function ($) {
	'use strict';
	var $body;
	return {
		show: function (elm) {
			elm.append('<div class="wikiaThrobber"></div>');
		},
		hide: function (elm) {
			elm.find('.wikiaThrobber').remove();
		},
		remove: function (elm) {
			elm.find('.wikiaThrobber').remove();
		},
		cover: function () {
			if (!$body) {
				$body = $('body');
			}
			if (!!$body) {
				$body.append('<div class="wikiaThrobber cover"></div>');
			}
		},
		uncover: function () {
			if (!!$body) {
				$body.children('.wikiaThrobber').remove();
			}
		}
	};
});

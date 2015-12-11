/**
 * throbber module:
 *  * jQuery
 */
define('wikia.throbber', ['jquery'], function($) {
	'use strict';
	return {
		show: function(elm) {
			elm.append('<div class="wikiaThrobber"></div>');
		},
		hide: function(elm) {
			elm.find('.wikiaThrobber').remove();
		},
		remove: function(elm) {
			elm.find('.wikiaThrobber').remove();
		},
		cover: function (elm) {
			elm.append('<div class="wikiaThrobber cover"></div>');
		}
	};
});

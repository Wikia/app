/**
 * throbber module:
 *  * jQuery
 */
define('wikia.throbber', ['jquery'], function($) {
	return {
		show: function(elm) {
			elm.append('<div class="wikiaThrobber"></div>');
		},
		hide: function(elm) {
			elm.find('.wikiaThrobber').remove();
		},
		remove: function(elm) {
			elm.find('.wikiaThrobber').remove();
		}
	};
});

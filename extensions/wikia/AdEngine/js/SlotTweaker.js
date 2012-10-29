var SlotTweaker = function(log, document) {
	'use strict';

	var logGroup = 'SlotTweaker'
		, removeClass, removeDefaultHeight, hide, removeTopButtonIfNeeded
		, defaultHeightClass = 'default-height'
		, rclass = /[\t\r\n]/g
	;

	removeClass = function(element, cls) {
		var elClasses = ' ' + element.className.replace(rclass, ' ') + ' '
			, newClasses = elClasses.replace(' ' + cls + ' ', ' ');

		log(['removeClass ' + cls, element], 8, logGroup);
		element.className = newClasses;
	};

	removeDefaultHeight = function(slotname) {
		var slot = document.getElementById(slotname);

		log('removeDefaultHeight ' + slotname, 6, logGroup);

		if (slot) {
			removeClass(slot, defaultHeightClass);
		}
	};

	// TODO: fix it, it's a hack!
	removeTopButtonIfNeeded = function(slotname) {
		var slot = document.getElementById(slotname)
			, topAds = document.getElementById('WikiaTopAds')
			, isLeaderboard = slot && slotname.indexOf('LEADERBOARD') !== -1
			, isStandardSize = slot && slot.offsetHeight >= 90 && slot.offsetHeight <= 95
		;

		if (isLeaderboard && !isStandardSize) {
			log('#' + slotname + ' height: ' + slot.offsetHeight + ' not standard, removing TOP_BUTTON', 3, logGroup);
			hide('TOP_BUTTON');
			removeClass(topAds, 'WikiaTopButtonLeft');
			removeClass(topAds, 'WikiaTopButtonRight');
		}
	};

	hide = function(slotname) {
		var slot = document.getElementById(slotname);

		log('hide ' + slotname, 6, logGroup);

		if (slot) {
			slot.style.display = 'none';
		}
	};

	return {
		removeDefaultHeight: removeDefaultHeight,
		removeTopButtonIfNeeded: removeTopButtonIfNeeded,
		hide: hide
	};
};

var SlotTweaker = function(log, document, undef) {
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
		;

		if (slot && slotname.indexOf('LEADERBOARD') !== -1
			&& slot.offsetHeight
			&& (slot.offsetHeight < 90 || slot.offsetHeight >= 95)
		) {
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

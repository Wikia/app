var SlotTweaker = function(log, document, window) {
	'use strict';

	var logGroup = 'SlotTweaker'
		, removeClass, removeDefaultHeight, hide, removeTopButtonIfNeeded
		, defaultHeightClass = 'default-height'
		, rclass = /[\t\r\n]/g
		, isLeaderboard, isStandardLeaderboardSize, adjustLeaderboardSize
		, standardLeaderboardSizeClass = 'standard-leaderboard'
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

	isLeaderboard = function (slotname) {
		return slotname.indexOf('LEADERBOARD') !== -1;
	};

	isStandardLeaderboardSize = function (slotname) {
		var slot = document.getElementById(slotname),
			isStandardSize;

		if (slot) {
			isStandardSize = slot.offsetHeight >= 90
				&& slot.offsetHeight <= 95
				&& slot.offsetWidth <= 728;

			log(
				['isStandardLeaderboardSize', slotname, slot.offsetWidth + 'x' + slot.offsetHeight, isStandardSize],
				3,
				logGroup
			);

			return isStandardSize;
		}
		log('isStandardLeaderboardSize: ' + slotname + ' missing', 3, logGroup);
	};

	// TODO: fix it, it's a hack!
	adjustLeaderboardSize = function(slotname) {
		var slot = document.getElementById(slotname);

		if (isLeaderboard(slotname) && isStandardLeaderboardSize(slotname)) {
			slot.className += ' ' + standardLeaderboardSizeClass;
		}
	};

	// TODO: fix it, it's a hack!
	removeTopButtonIfNeeded = function(slotname) {
		if (isLeaderboard(slotname) && !isStandardLeaderboardSize(slotname)) {
			log('removing TOP_BUTTON(_WIDE)', 3, logGroup);
			hide('TOP_BUTTON');
			hide('TOP_BUTTON_WIDE');
		}
		if (isLeaderboard(slotname) && isStandardLeaderboardSize(slotname)) {
			log('pushing TOP_BUTTON(_WIDE).force to Liftium2 queue', 2, logGroup);
			window.adslots2.push(['TOP_BUTTON.force', null, 'Liftium2']);
			window.adslots2.push(['TOP_BUTTON_WIDE.force', null, 'Liftium2']);
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
		adjustLeaderboardSize: adjustLeaderboardSize,
		hide: hide
	};
};

var SlotTweaker = function(log, document, window) {
	'use strict';

	var logGroup = 'SlotTweaker'
		, addDefaultHeight, removeClass, removeDefaultHeight, hide, show, removeTopButtonIfNeeded
		, defaultHeightClass = 'default-height'
		, rclass = /[\t\r\n]/g
		, isMedrec, hideSelfServeUrl
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

	isMedrec = function (slotname) {
		return slotname.match(/TOP_RIGHT_BOXAD/);
	};

	hideSelfServeUrl = function (slotname) {
		var selfServeUrl = document.getElementsByClassName('SelfServeUrl');
		if (isMedrec(slotname)) {
			if (selfServeUrl.length > 0) {
				selfServeUrl[0].className += ' hidden';
			}
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

	addDefaultHeight = function(slotname) {
		var slot = document.getElementById(slotname);

		log('addDefaultHeight ' + slotname, 6, logGroup);

		if (slot) {
			slot.className += ' ' + defaultHeightClass;
		}
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
			log('removing TOP_BUTTON_WIDE', 3, logGroup);
			hide('TOP_BUTTON_WIDE');
		}
		if (isLeaderboard(slotname) && isStandardLeaderboardSize(slotname)) {
			log('pushing TOP_BUTTON_WIDE.force to Liftium2 queue', 2, logGroup);
			window.adslots2.push(['TOP_BUTTON_WIDE.force', null, 'Liftium2']);
		}
	};

	hide = function(slotname, usingClass) {
		log('hide ' + slotname + (usingClass ? ' using class hidden' : ' using display: none'), 6, logGroup);

		var slot = document.getElementById(slotname);

		if (slot) {
			if (usingClass) {
				slot.className += ' hidden';
			} else {
				slot.style.display = 'none';
			}
		}
	};

	show = function(slotname, usingClass) {
		log('hide ' + slotname + (usingClass ? ' using class hidden' : ' using display: none'), 6, logGroup);

		var slot = document.getElementById(slotname);

		if (slot) {
			if (usingClass) {
				removeClass(slot, 'hidden');
			} else {
				throw 'Showing slot not based on hidden class unsupported';
			}
		}
	};

	return {
		addDefaultHeight: addDefaultHeight,
		removeDefaultHeight: removeDefaultHeight,
		removeTopButtonIfNeeded: removeTopButtonIfNeeded,
		adjustLeaderboardSize: adjustLeaderboardSize,
		hide: hide,
		hideSelfServeUrl : hideSelfServeUrl,
		show: show
	};
};

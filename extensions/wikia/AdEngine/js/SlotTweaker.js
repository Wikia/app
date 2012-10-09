var SlotTweaker = function(log, document, undef) {
	'use strict';

	var logGroup = 'SlotTweaker'
		, removeClass, removeDefaultHeight, hide
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

	hide = function(slotname) {
		var slot = document.getElementById(slotname);

		log('hide ' + slotname, 6, logGroup);

		if (slot) {
			slot.style.display = 'none';
		}
	};

	return {
		removeDefaultHeight: removeDefaultHeight,
		hide: hide
	};
};

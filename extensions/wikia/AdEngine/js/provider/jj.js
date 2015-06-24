/*global define*/
define('ext.wikia.adEngine.provider.jj', [
	'wikia.log',
	'wikia.document',
	'jquery'

], function (log, doc) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.jj',
		slotMap,
		canHandleSlot,
		fillInSlot,
		putContentIntoSlot;

	slotMap = {
		'PREFOOTER_LEFT_BOXAD': true,
		'PREFOOTER_RIGHT_BOXAD': true,
	};

	canHandleSlot = function (slotname) {
		log(['canHandleSlot', slotname], 'debug', logGroup);

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	};

	putContentIntoSlot = function (slotName) {
		var container = doc.getElementById(slotName);

		var catApiCode = '<a href="http://thecatapi.com">' +
			'               <img src="http://thecatapi.com/api/images/get?format=src&size=small">' +
			'</a>';
		if (container) {
			container.innerHtml = catApiCode;
			$(container).append(catApiCode);
		}
	};

	fillInSlot = function (slotname, slotElement, success, hop) {
		var doRandomHop = Math.random() < 0.2;

		if (doRandomHop) {
			log(['doing hop', slotname], 'debug', logGroup);
			hop();
		} else {
			putContentIntoSlot(slotname);
			success();
		}
	};

	return {
		name: 'jj',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};

});


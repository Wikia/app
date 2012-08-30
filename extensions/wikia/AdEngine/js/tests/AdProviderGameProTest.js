/*
@test-framework QUnit
@test-require-asset resources/wikia/libraries/my.class/my.class.js
@test-require-asset extensions/wikia/AdEngine/AdProviderAdEngine2.js
@test-require-asset extensions/wikia/AdEngine/AdProviderGamePro.js
*/
module('AdProviderGamePro');

test('rebuildKV', function() {
	var ap = new AdProviderGamePro;

    equal(ap.rebuildKV('egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv'), 'egnre=action,adventure,drama,scifi;media=tv', 'egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv');
});
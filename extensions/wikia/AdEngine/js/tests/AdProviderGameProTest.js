/*
@test-framework QUnit
 @test-require-asset resources/wikia/modules/querystring.js
 @test-require-asset resources/wikia/modules/cookies.js
 @test-require-asset resources/wikia/modules/log.js
 @test-require-asset extensions/wikia/WikiaTracker/js/WikiaTracker.js
 @test-require-asset extensions/wikia/AdEngine/ghost/gw-11.6.7/lib/gw.js
@test-require-asset extensions/wikia/AdEngine/AdProviderGamePro.js
*/
module('AdProviderGamePro');

test('rebuildKV', function() {
    equal(AdProviderGamePro.rebuildKV('egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv'), 'egnre=action,adventure,drama,scifi;media=tv', 'egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv');
});
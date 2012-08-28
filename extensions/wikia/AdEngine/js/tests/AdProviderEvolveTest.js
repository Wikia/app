/*
@test-framework QUnit
@test-require-asset resources/wikia/libraries/my.class/my.class.js
@test-require-asset extensions/wikia/AdEngine/AdProviderAdEngine2.js
@test-require-asset extensions/wikia/AdEngine/AdProviderEvolve.js
*/
module('AdProviderEvolve');

test('sanitizeSlotname', function() {
	var ap = new AdProviderEvolve;

    equal(ap.sanitizeSlotname('foo'), '', 'foo');
    equal(ap.sanitizeSlotname('TOP_LEADERBOARD'), 'TOP_LEADERBOARD', 'TOP_LEADERBOARD');
    equal(ap.sanitizeSlotname('=TOP_LEADERBOARD;ord=1'), 'TOP_LEADERBOARD', '=TOP_LEADERBOARD;ord=1');
});
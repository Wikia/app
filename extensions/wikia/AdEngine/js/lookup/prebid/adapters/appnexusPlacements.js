/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.adContext',
	'wikia.log'
], function (adContext, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
		placementsMap = {
			mercury: {
				ent: '9412992',
				gaming: '9412993',
				life: '9412994',
				other: '9412994'
			},
			oasis: {
				recovery: {
					atf: '11823778',
					btf: '11823724',
					hivi: '11823799'
				},
				pal: {
					atf: '11977073',
					btf: '11977096',
					hivi: '11977016',
					other: '11969927'
				}
			}
		};

	function getPlacement(skin, position, isRecovering) {
		var context = adContext.getContext(),
			vertical = skin === 'oasis' ? 'pal' : context.targeting.mappedVerticalName,
			skinVertical;

		if (isRecovering) {
			vertical = 'recovery';
		}

		if (placementsMap && placementsMap[skin] && placementsMap[skin][vertical]) {
			skinVertical = placementsMap[skin][vertical];

			return position && skinVertical[position] ?
				skinVertical[position] :
				skinVertical;
		}

		log([
				'getPlacement', skin, vertical, position,
				'placement not found'
			], 'error', logGroup
		);
	}

	return {
		getPlacement: getPlacement
	};
});

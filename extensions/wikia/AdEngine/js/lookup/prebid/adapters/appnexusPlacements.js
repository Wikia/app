/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', [
	'ext.wikia.adEngine.adContext',
	'wikia.log'
], function (adContext, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements',
		placementsMap = {
			'mercury': {
				'ent': '9412992',
				'gaming': '9412993',
				'life': '9412994',
				'other': '9412994'
			},
			'oasis': {
				'ent': {
					'atf': '9412983',
					'btf': '9412986',
					'hivi': '9412989'
				},
				'gaming': {
					'atf': '9412984',
					'btf': '9412987',
					'hivi': '9412990'
				},
				'life': {
					'atf': '9412985',
					'btf': '9412988',
					'hivi': '9412991'
				},
				'other': {
					'atf': '9412985',
					'btf': '9412988',
					'hivi': '9412991'
				},
				'recovery': {
					'atf': '11823778',
					'btf': '11823724',
					'hivi': '11823799'
				}
			}
		},
		palPlacementsMap = {
			oasis: {
				atf: '3143028',
				btf: '3143029',
				hivi: '3142398',
				other: '3140173'
			},
			recovery: {
				'atf': '11823778',
				'btf': '11823724',
				'hivi': '11823799'
			}
		};

	function getPlacement(skin, position, isRecovering) {
		var context = adContext.getContext(),
			vertical = isRecovering ? 'recovery' : context.targeting.mappedVerticalName,
			skinVertical;

		if (context.premiumAdLayoutEnabled) {
			skin = isRecovering ? 'recovery' : skin;

			return palPlacementsMap[skin] && palPlacementsMap[skin][position];
		} else if (placementsMap && placementsMap[skin] && placementsMap[skin][vertical]) {
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

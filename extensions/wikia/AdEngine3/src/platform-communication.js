import { eventService, jwpReady, utils, universalAdPackage } from '@wikia/ad-engine';
import { take } from 'rxjs/operators';
import { ofType as ofActionType } from 'ts-action-operators';
import { ofType } from '@wikia/post-quecast';

export function listenSetupJWPlayer(callback) {
	eventService.communicator.actions$
		.pipe(
			ofType('[Ad Engine] Setup JWPlayer'),
			take(1)
		)
		.subscribe(callback);
}

export function dispatchRailReady() {
	eventService.communicator.dispatch({ type: '[Rail] Ready' });
}

export function dispatchPlayerReady(options, targeting, playerKey) {
	eventService.communicator.dispatch(jwpReady({options, targeting, playerKey}));
}

/**
 * Returns a Promise which resolves when templates for first call slot have been initiated.
 *
 * @return {Promise<boolean>} true if UAP was loaded otherwise false
 */
export function isUapLoaded() {
	return new Promise((res) => {
		eventService.communicator.actions$
		.pipe(
			ofActionType(universalAdPackage.uapLoadStatus),
			take(1)
		)
		.subscribe(action => {
			utils.logger('UAP Loaded', [action.isLoaded]);
			res(action.isLoaded);
		});
	});
}

// Ref: ADEN-9759 MAIN-19818 CAKE Affiliate units
// Once `isUapLoaded is used in affiliate slots, remove this execution.`
isUapLoaded();

import { utils } from '@wikia/ad-engine';
import { take } from 'rxjs/operators';
import { communicationService } from "./communication/communication-service";
import { ofType } from "./communication/of-type";

export function listenSetupJWPlayer(callback) {
	communicationService.action$
		.pipe(
			ofType('[Ad Engine] Setup JWPlayer'),
			take(1)
		)
		.subscribe(callback);
}

export function dispatchRailReady() {
	communicationService.dispatch({ type: '[Rail] Ready' });
}

export function dispatchPlayerReady(options, targeting, playerKey) {
	communicationService.dispatch({ type: '[JWPlayer] Player Ready', options, targeting, playerKey });
}

/**
 * Returns a Promise which resolves when templates for first call slot have been initiated.
 *
 * @return {Promise<boolean>} true if UAP was loaded otherwise false
 */
export function isUapLoaded() {
	return new Promise((res) => {
		communicationService.action$
		.pipe(
			ofType('[AdEngine] UAP Load status'),
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

import { jwpReady, utils, universalAdPackage } from "@wikia/ad-engine";
import { take } from "rxjs/operators";
import { ofType } from "ts-action-operators";
import { communicator } from "./communicator";

export function listenSetupJWPlayer(callback) {
	communicator.actions$
		.pipe(
			ofType('[Ad Engine] Setup JWPlayer'),
			take(1)
		)
		.subscribe(callback);
}

export function dispatchRailReady() {
	communicator.dispatch({ type: '[Rail] Ready' });
}

export function dispatchPlayerReady(options, targeting, playerKey) {
	communicator.dispatch(jwpReady({options, targeting, playerKey}));
}

export function isUapLoaded() {
	return new Promise((res) => {
		communicator.actions$
		.pipe(
			ofType(universalAdPackage.uapLoadStatus),
			take(1)
		)
		.subscribe(isLoaded => {
			utils.logger('UAP Loaded', [isLoaded]);
			res(isLoaded);
		});
	});
}

// Ref: ADEN-9759 MAIN-19818 CAKE Affiliate units
// Once `isUapLoaded is used in affiliate slots, remove this execution.`
isUapLoaded();

import { communicator } from "./communicator";
import { ofType } from "@wikia/post-quecast";
import { take } from "rxjs/operators";
import { jwpReady } from "@wikia/ad-engine";

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
			ofType('[Ad Engine] UAP Load Status'),
			take(1)
		)
		.subscribe(isLoaded => res(isLoaded));
	});
}

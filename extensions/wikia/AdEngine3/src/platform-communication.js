import { communicator } from "./communicator";
import { ofType } from "@wikia/post-quecast";
import { take } from "rxjs/operators";
import { jwpReady } from "@wikia/ad-engine";

export function listenSetupJWPlayer(callback) {
	communicator.actions$
		.pipe(
			ofType('[Ad Engine] setup jw player'),
			take(1)
		)
		.subscribe(callback);
}

export function dispatchRailReady() {
	communicator.dispatch({ type: '[Rail] Ready' });
}

export function dispatchPlayerReady(options, targeting, playerKey) {
	jwpReady({options, targeting, playerKey});
}

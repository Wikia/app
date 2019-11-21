import { jwplayerAdsFactory } from '@wikia/ad-engine';
import { ofType } from "@wikia/post-quecast";
import { take } from 'rxjs/operators';
import { communicator } from "./communicator";
import { registerEditorSavedEvents, setupAdEngine } from "./startup";

export function run() {
	window.Wikia.consentQueue = window.Wikia.consentQueue || [];
	window.Wikia.consentQueue.push(setupAdEngine);
	registerEditorSavedEvents();
}

export function dispatchRailReady() {
	communicator.dispatch({type: '[Rail] Ready'});
}

export function listenSetupJwPlayer(callback) {
	communicator.actions$
		.pipe(
			ofType('[Ad Engine] setup jw player'),
			take(1)
		)
		.subscribe(callback);
}

export {
	jwplayerAdsFactory,
}

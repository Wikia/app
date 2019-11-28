import { jwplayerAdsFactory } from '@wikia/ad-engine';
import { registerEditorSavedEvents, setupAdEngine } from "./startup";

export function run() {
	window.Wikia.consentQueue = window.Wikia.consentQueue || [];
	window.Wikia.consentQueue.push(setupAdEngine);
	registerEditorSavedEvents();
}

export {
	jwplayerAdsFactory,
}

// Those will stay
export * from './platform-communication';

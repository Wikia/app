import { setupAdEngine } from './startup';

export function run() {
	window.Wikia.consentQueue = window.Wikia.consentQueue || [];
	window.Wikia.consentQueue.push(setupAdEngine);
}

// Those will stay
export * from './platform-communication';

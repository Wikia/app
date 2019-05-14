import { context } from '@wikia/ad-engine';
import { bidders } from '@wikia/ad-engine/dist/ad-bidders';

const logGroup = 'bidders-delay';

let delayPromise = null;
let resolvePromise;

export const biddersDelay = {
	isEnabled() {
		return context.get('bidders.enabled');
	},

	getName() {
		return logGroup;
	},

	getPromise() {
		if (delayPromise === null) {
			delayPromise = new Promise((resolve) => {
				resolvePromise = resolve;
			});
		}

		return delayPromise;
	},

	markAsReady() {
		if (bidders.hasAllResponses()) {
			if (resolvePromise) {
				resolvePromise();
				resolvePromise = null;
			}
		}
	},
};

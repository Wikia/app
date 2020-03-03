import  { babDetection, btRec } from '@wikia/ad-engine';
import { track } from '../tracking/tracker';
import { waitForContentAndJS } from '../utils';

function trackDetection(isBabDetected) {
	track({
		category: 'ads-babdetector-detection',
		action: 'impression',
		label: isBabDetected ? 'Yes' : 'No',
		value: 0,
		trackingMethod: 'internal',
	});
}

export const wadRunner = {
	async call() {
		if (!babDetection.isEnabled()) {
			return Promise.resolve();
		}

		await waitForContentAndJS();

		const isBabDetected = await babDetection.run();

		trackDetection(isBabDetected);

		if (isBabDetected) {
			btRec.run();
		}
	},
};

import { context, utils } from '@wikia/ad-engine/dist/ad-engine';
import { babDetection } from './bab-detection';
import { btLoader } from './bt-loader';
import { hmdLoader } from './hmd-loader';

const logGroup = 'rec-runner';

let recEnabled = {
	display: '',
	video: '',
};
let recParams = {
	bt: {
		type: 'display',
		context: 'options.wad.btRec.enabled',
		loader: btLoader
	},
	hmd: {
		type: 'video',
		context: 'options.wad.hmdRec.enabled',
		loader: hmdLoader,
	},
};

/**
 * Starts rec service and inits available adapters
 */
export const recRunner = {
	/**
	 * Checks availability of rec services, Instant Globals settings and initialises enabled ones
	 * @returns {void}
	 */
	init() {
		utils.logger(logGroup, 'WAD rec module initialized');

		Object.keys(recParams).forEach((rec) => {
			const config = recParams[rec];

			if (!recEnabled[config.type] && context.get(config.context)) {
				recEnabled[config.type] = rec;

				if (babDetection.isBlocking()) {
					config.loader.run();
				} else {
					document.addEventListener('bab.blocking', config.loader.run);
				}
			}
		});
	},

	/**
	 * Checks whether rec service is available
	 * @param {string} name
	 * @returns {boolean}
	 */
	isEnabled(name) {
		return recEnabled.display === name || recEnabled.video === name;
	},
};

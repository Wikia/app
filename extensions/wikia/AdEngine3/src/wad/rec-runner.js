import { context, utils } from '@wikia/ad-engine';
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
		context: 'opts.wadBT',
		loader: btLoader
	},
	hmd: {
		type: 'video',
		context: 'opts.wadHMD',
		loader: hmdLoader,
	},
};

export const recRunner = {
	init() {
		utils.logger(logGroup, 'WAD rec module initialized');

		Object.keys(recParams).forEach((rec) => {
			const config = recParams[rec];

			if (!recEnabled[config.type] && context.get(config.context)) {
				recEnabled[config.type] = rec;

				config.loader.init();
			}
		});
	},

	isEnabled(name) {
		return recEnabled.display === name || recEnabled.video === name;
	},
};

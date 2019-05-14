import { context } from '@wikia/ad-engine/dist/ad-engine';

export function getConfig() {
	return {
		slotsToEnable: [
			'top_boxad',
			'invisible_skin',
		],
		slotsToDisable: [
			'incontent_player'
		],
		onInit: () => {
			context.push('state.adStack', { id: 'invisible_skin' });
		}
	};
}

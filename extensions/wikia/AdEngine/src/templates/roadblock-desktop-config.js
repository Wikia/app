export function getConfig() {
	return {
		slotsToEnable: [
			'TOP_RIGHT_BOXAD',
			'INVISIBLE_SKIN'
		],
		onInit() {
			window.adslots2.push('INVISIBLE_SKIN');
		}
	};
}

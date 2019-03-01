export function getConfig() {
	return {
		slotsToEnable: [
			'top_boxad',
			'invisible_skin',
		],
		onInit: () => {
			window.adslots2.push('invisible_skin');
		}
	};
}

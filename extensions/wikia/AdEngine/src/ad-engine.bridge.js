import Context from 'ad-engine/src/services/context-service';
import SlotService from 'ad-engine/src/services/slot-service';
import TemplateService from 'ad-engine/src/services/template-service';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import config from './context';

let bfabSlot = {
	getSlotName: () => 'BOTTOM_LEADERBOARD',
	getId: () => 'BOTTOM_LEADERBOARD'
};

Context.extend(config);
TemplateService.register(BigFancyAdBelow);
SlotService.add(bfabSlot);

function loadCustomAd(callback) {
	return (params) => {
		try {
			const slot = SlotService.getBySlotName(params.slotName);
			TemplateService.init(params.type, slot, params);
		} catch (e) {
			callback(params);
		}
	};
}

export {
	loadCustomAd
};
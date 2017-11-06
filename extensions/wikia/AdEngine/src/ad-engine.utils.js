import AdEngine from 'ad-engine/src/ad-engine';
import AdSlot from 'ad-engine/src/models/ad-slot';
import Context from 'ad-engine/src/services/context-service';
import TemplateService from 'ad-engine/src/services/template-service';
import { build } from 'ad-engine/src/video/vast-url-builder';
import BigFancyAdBelow from 'ad-products/src/modules/templates/uap/big-fancy-ad-below';
import config from './context';

Context.extend(config);

TemplateService.register(BigFancyAdBelow);

let adEngine = new AdEngine(config);
adEngine.init();

function initializeSlot(params) {
	const adSlot = new AdSlot({id: 'gpt-bottom-leaderboard-desktop'}, 'BOTTOM_LEADERBOARD');
	return new BigFancyAdBelow(adSlot).init(params);
}

export {
	build,
	Context,
	initializeSlot
};
import {
    billTheLizard,
    context,
} from '@wikia/ad-engine';
import targeting from './targeting';

let config = null; //config will be used later

function serializeBids(slotName) {
    return targeting.getBiddersPrices(slotName, false).then(bidderPrices => [
        bidderPrices.bidder_0 || 0, // wikia adapter
        bidderPrices.bidder_1 || 0,
        bidderPrices.bidder_2 || 0,
        bidderPrices.bidder_4 || 0,
        bidderPrices.bidder_5 || 0,
        bidderPrices.bidder_6 || 0,
        bidderPrices.bidder_7 || 0,
        bidderPrices.bidder_8 || 0,
        bidderPrices.bidder_9 || 0,
        bidderPrices.bidder_10 || 0,
        bidderPrices.bidder_11 || 0,
        bidderPrices.bidder_12 || 0,
        bidderPrices.bidder_13 || 0,
        bidderPrices.bidder_14 || 0,
        bidderPrices.bidder_15 || 0,
        bidderPrices.bidder_16 || 0,
        bidderPrices.bidder_17 || 0,
        bidderPrices.bidder_18 || 0,
    ].join(','));
}

export const billTheLizardWrapper = {
    configureBillTheLizard(billTheLizardConfig) { //config will be used later

        config = billTheLizardConfig;

        const enableGarfield = context.get('options.billTheLizard.garfield');

        if (enableGarfield === true) {
            billTheLizard.projectsHandler.enable('garfield');
        }

        billTheLizard.executor.register('catlapseIncontentBoxad', () => {
            console.log('catlapsed!');
        });
    },

    callGarfield(callId) {
        serializeBids(callId).then((bids) => {
            context.set('services.billTheLizard.parameters.garfield', {
                bids,
            });
            billTheLizard.call(['garfield'], callId);
        });
    },
}

export default billTheLizardWrapper;

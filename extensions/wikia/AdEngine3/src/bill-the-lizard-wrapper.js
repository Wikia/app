import {
    BillTheLizard,
    billTheLizard,
    billTheLizardEvents,
    context,
    events,
    eventService
} from '@wikia/ad-engine';
import targeting from './targeting';
import pageTracker from './tracking/page-tracker';

let garfieldCalled = false;
let nextSlot = null;
const baseSlotName = 'INCONTENT_BOXAD_1';
const fmrPrefix = 'incontent_boxad_';

class BillTheLizardWrapper {
    configureBillTheLizard(billTheLizardConfig) { //config will be used later
        const config = billTheLizardConfig;

        const enableGarfield = context.get('options.billTheLizard.garfield');

        if (enableGarfield === true) {
            billTheLizard.projectsHandler.enable('garfield');
        }

        billTheLizard.executor.register('catlapseIncontentBoxad', () => {
            console.log('catlapsed!');
        });

        context.push('listeners.slot', {
            onRenderEnded: (adSlot) => {
                const slotName = adSlot.config.adProduct
                if (slotName.includes('incontent_boxad')) {
                    nextSlot = fmrPrefix + (adSlot.getConfigProperty('repeat.index') + 1);
                }
            },
        });

        context.set(
            'bidders.prebid.bidsRefreshing.bidsBackHandler',
            () => {
                    this.callGarfield(nextSlot);
            },
        );

        // eventService.on(events.AD_SLOT_CREATED, (adSlot) => {
        //     if (adSlot.getConfigProperty('garfieldCat')) {
        //         const callId = adSlot.config.adProduct;
        //         adSlot.setConfigProperty('btlStatus', this.getBtlSlotStatus(
        //             billTheLizard.getResponseStatus(callId),
        //             callId,
        //             defaultStatus,
        //         ));
        //     }
        // });

        eventService.on(billTheLizardEvents.BILL_THE_LIZARD_REQUEST, (event) => {
            const { query, callId } = event;
            let propName = 'btl_request';
            if (callId) {
                propName = `${propName}_${callId}`;
            }

            pageTracker.trackProp(propName, query);
        });

        eventService.on(billTheLizardEvents.BILL_THE_LIZARD_RESPONSE, (event) => {
            const { response, callId } = event;
            let propName = 'btl_response';
            if (callId) {
                propName = `${propName}_${callId}`;
                defaultStatus = BillTheLizard.REUSED;
            }
            pageTracker.trackProp(propName, response);
        });
    }

    callGarfield(callId) {
        this.serializeBids(baseSlotName).then((bids) => {
            context.set('services.billTheLizard.parameters.garfield', {
                bids,
            });
            billTheLizard.call(['garfield'], callId);
        });
    }

    /**
     * @private
     * @param btlStatus, callId, fallbackStatus
     */
    getBtlSlotStatus(btlStatus, callId, fallbackStatus) {
        console.log(btlStatus);
        let slotStatus;

        switch (btlStatus) {
            case BillTheLizard.TIMEOUT:
            case BillTheLizard.FAILURE: {
                console.log('btl_failure');
                slotStatus = 'FAILURE';
                break;
            }
            case BillTheLizard.ON_TIME: {
                console.log('btl_on_time');
                slotStatus = 'ONTAJM';
                break;
            }
            default: {
                console.log('default');
                slotStatus = '????';
            }
        }
    }

    /**
     * @private
     * @param slotName
     * @returns {Promise<string | never>}
     */
    serializeBids(slotName) {
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
}
export const billTheLizardWrapper = new BillTheLizardWrapper();

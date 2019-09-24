import {
    billTheLizard,
    BillTheLizard,
    billTheLizardEvents,
    context,
    events,
    eventService,
} from '@wikia/ad-engine';
import targeting from './targeting';
import pageTracker from './tracking/page-tracker';

const NOT_USED_STATUS = 'not_used';

const bidPosKeyVal = 'INCONTENT_BOXAD_1';
let config = null;
let garfieldCalled = false;
let initialValueOfIncontentsCounter = 1;
let incontentsCounter = initialValueOfIncontentsCounter;
let defaultStatus = NOT_USED_STATUS;

function getCallId(counter = null) {
    if (context.get('options.useTopBoxad') && (counter || incontentsCounter) === 0) {
        return 'top_boxad';
    }

    return `incontent_boxad_${counter || incontentsCounter}`; //??
}

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

function getBtlSlotStatus(btlStatus, callId, fallbackStatus) {
    let slotStatus;

    switch (btlStatus) {
        case BillTheLizard.ON_TIME: {
            const prediction = billTheLizard.getPrediction('garfield', callId);
            const result = prediction ? prediction.result : undefined;
            slotStatus = `${BillTheLizard.ON_TIME};res=${result};${callId}`;
            break;
        }
        default: {
            if (fallbackStatus === NOT_USED_STATUS) {                                                                // 2.
                // we don't use a slot until we got response from Bill
                return NOT_USED_STATUS;
            }

            const prevPrediction = billTheLizard.getPreviousPrediction(incontentsCounter, getCallId, 'garfield');

            if (prevPrediction === undefined) {
                // probably impossible but set in debugging purposes
                return 'weird_cat';
            }

            slotStatus = `${BillTheLizard.REUSED};res=${prevPrediction.result};${prevPrediction.callId}`;
        }
    }

    return slotStatus;
}

export const billTheLizardWrapper = {
    configureBillTheLizard(billTheLizardConfig) {

        defaultStatus = NOT_USED_STATUS;

        config = billTheLizardConfig;

        const enableGarfield = context.get('options.billTheLizard.garfield');

        if (enableGarfield === true) {
            billTheLizard.projectsHandler.enable('garfield');
        }

        // billTheLizard.executor.register('catlapseIncontentBoxad', () => {
        //     console.log('catlapsed!');
        // });

        eventService.on(events.AD_SLOT_CREATED, (adSlot) => {
            if (adSlot.getConfigProperty('cheshireCatSlot')) {
                const callId = getCallId();
                // to je tez wazne 1.
                adSlot.setConfigProperty('btlStatus', getBtlSlotStatus(
                    billTheLizard.getResponseStatus(callId),
                    callId,
                    defaultStatus,
                ));
            }
        });

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
    },

    callGarfield(callId) {
        serializeBids(callId).then((bids) => {
            console.log(bids)
            context.set('services.billTheLizard.parameters.garfield', {
                bids,
            });
            garfieldCalled = true;
            billTheLizard.call(['garfield'], callId);
        });
    },
}

export default billTheLizardWrapper;

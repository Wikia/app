import {
    BillTheLizard,
    billTheLizard,
    billTheLizardEvents,
    context,
    events,
    eventService,
    utils
} from '@wikia/ad-engine';
import targeting from './targeting';
import pageTracker from './tracking/page-tracker';

const garfieldSlotsBidderAlias = 'INCONTENT_BOXAD_1';
const fmrPrefix = 'incontent_boxad_';
const NOT_USED_STATUS = 'not_used';

let garfieldCalled = false;
let nextSlot = null;

class BillTheLizardWrapper {
    configureBillTheLizard(billTheLizardConfig) {
        const config = billTheLizardConfig;

        if (!this.hasAvailableModels(config, 'garfield')) {
            return;
        }

        const baseSlotName = fmrPrefix + 1;
        const enableGarfield = context.get('options.billTheLizard.garfield');

        defaultStatus = NOT_USED_STATUS;

        if (enableGarfield === true) {
            billTheLizard.projectsHandler.enable('garfield');
        }

        context.set('services.billTheLizard.projects', config.projects);
        context.set('services.billTheLizard.timeout', config.timeout || 0);

        billTheLizard.executor.register('catlapseIncontentBoxad', () => {
            console.log('catlapsed!');
        });

        context.push('listeners.slot', {
            onRenderEnded: (adSlot) => {
                const slotName = adSlot.getConfigProperty('slotName');

                if (slotName.includes(fmrPrefix)) {
                    nextSlot = fmrPrefix + (adSlot.getConfigProperty('repeat.index') + 1);
                }

                if (slotName === baseSlotName && !garfieldCalled) {
                    this.callGarfield(nextSlot);
                }
            },
        });

        context.set(
            'bidders.prebid.bidsRefreshing.bidsBackHandler',
            () => {
                this.callGarfield(nextSlot);
            },
        );

        eventService.on(events.AD_SLOT_CREATED, (adSlot) => {
            if (adSlot.getConfigProperty('garfieldCat')) {
                const callId = adSlot.getConfigProperty('slotName');
                adSlot.setConfigProperty('btlStatus', this.getBtlSlotStatus(
                    billTheLizard.getResponseStatus(callId),
                    callId,
                    defaultStatus,
                ));
            }
        });

        eventService.on(events.BIDS_REFRESH, () => {
            garfieldCalled = true;
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
    }

    callGarfield(callId) {
        this.serializeBids(garfieldSlotsBidderAlias).then((bids) => {
            context.set('services.billTheLizard.parameters.garfield', {
                bids,
            });
            garfieldCalled = true;
            billTheLizard.call(['garfield'], callId);
        });
    }

    getBtlSlotStatus(btlStatus, callId, fallbackStatus) {
        let slotStatus;

        switch (btlStatus) {
            case BillTheLizard.TIMEOUT:
            case BillTheLizard.FAILURE: {
                const prevPrediction = billTheLizard.getLastReusablePrediction('garfield');

                slotStatus = btlStatus;

                if (prevPrediction !== undefined) {
                    slotStatus += `;res=${prevPrediction.result};${prevPrediction.callId}`;
                }
                break;
            }
            case BillTheLizard.ON_TIME: {
                const prediction = billTheLizard.getPrediction('garfield', callId);
                const result = prediction ? prediction.result : undefined;
                slotStatus = `${BillTheLizard.ON_TIME};res=${result};${callId}`;
                break;
            }
            default: {
                if (fallbackStatus === NOT_USED_STATUS) {
                    // we don't use a slot until we got response from Bill
                    return NOT_USED_STATUS;
                }

                const prevPrediction = billTheLizard.getLastReusablePrediction('garfield');

                if (prevPrediction === undefined) {
                    // shouldnt see a lot of that
                    return 'weird_cat';
                }

                slotStatus = `${BillTheLizard.REUSED};res=${prevPrediction.result};${prevPrediction.callId}`;
            }
        }
        return slotStatus;
    }

    getCallId(counter = null) {
        return `incontent_boxad_${counter}`;
    }

    hasAvailableModels(btlConfig, projectName) {
        const projects = btlConfig.projects;

        return projects && projects[projectName]
            && projects[projectName].some(
                model => utils.geoService.isProperGeo(model.countries, model.name),
            );
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

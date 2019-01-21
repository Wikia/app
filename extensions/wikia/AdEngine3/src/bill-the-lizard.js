// import targeting from './targeting';
// import pageTracker from './tracking/page-tracker';
//
// let config = null;
// let cheshirecatCalled = false;
// let incontentsCounter = 1;
//
// function getNextIncontentId() {
//   return `incontent_boxad_${incontentsCounter}`;
// }
//
// function serializeBids(slotName) {
//   const bidderPrices = targeting.getBiddersPrices(slotName, false);
//
//   return [
//     bidderPrices.bidder_1 || 0,
//     bidderPrices.bidder_2 || 0,
//     bidderPrices.bidder_3 || 0,
//     bidderPrices.bidder_4 || 0,
//     bidderPrices.bidder_5 || 0,
//     bidderPrices.bidder_6 || 0,
//     bidderPrices.bidder_7 || 0,
//     bidderPrices.bidder_8 || 0,
//     bidderPrices.bidder_9 || 0,
//     bidderPrices.bidder_10 || 0,
//     bidderPrices.bidder_11 || 0,
//     bidderPrices.bidder_12 || 0,
//     bidderPrices.bidder_13 || 0,
//     bidderPrices.bidder_14 || 0,
//     bidderPrices.bidder_15 || 0,
//     bidderPrices.bidder_16 || 0,
//     bidderPrices.bidder_17 || 0,
//   ].join(',');
// }
//
export const billTheLizardConfigurator = {
  configure() {
//     const { context, events, slotService } = window.Wikia.adEngine;
//     const { billTheLizard, BillTheLizard } = window.Wikia.adServices;
//     let refreshedSlotNumber;
//
//     if (context.get('bidders.prebid.bidsRefreshing.enabled')) {
//       config = instantGlobals.wgAdDriverBillTheLizardConfig || {};
//
//       context.set('services.billTheLizard.projects', config.projects);
//       context.set('services.billTheLizard.timeout', config.timeout || 0);
//
//       billTheLizard.projectsHandler.enable('cheshirecat');
//       billTheLizard.executor.register('catlapseIncontentBoxad', () => {
//         slotService.disable(getNextIncontentId(), 'catlapsed');
//       });
//
//       context.set(
//         'bidders.prebid.bidsRefreshing.bidsBackHandler',
//         () => {
//           if (refreshedSlotNumber && refreshedSlotNumber > 1) {
//             this.callCheshireCat(`incontent_boxad_${refreshedSlotNumber}`);
//           }
//         },
//       );
//
//       context.push('listeners.slot', {
//         onRenderEnded: (adSlot) => {
//           if (adSlot.getSlotName() === 'incontent_boxad_1' && !cheshirecatCalled) {
//             this.callCheshireCat('incontent_boxad_1');
//           }
//         },
//       });
//
//       events.on(events.AD_SLOT_CREATED, (adSlot) => {
//         if (adSlot.getSlotName().indexOf('incontent_boxad_') === 0) {
//           let slotStatus;
//           const callId = `incontent_boxad_${incontentsCounter}`;
//           const btlStatus = billTheLizard.getResponseStatus(callId);
//
//           switch (btlStatus) {
//             case BillTheLizard.TOO_LATE:
//             case BillTheLizard.TIMEOUT:
//             case BillTheLizard.FAILURE: {
//               const prevPrediction = billTheLizard.getPreviousPrediction(
//                 incontentsCounter,
//                 counter => `incontent_boxad_${counter}`,
//                 'cheshirecat',
//               );
//
//               slotStatus = btlStatus;
//               if (prevPrediction !== undefined) {
//                 slotStatus += `;res=${prevPrediction.result};${callId}`;
//               }
//               break;
//             }
//             case BillTheLizard.ON_TIME: {
//               const prediction = billTheLizard.getPrediction('cheshirecat', callId);
//               const result = prediction ? prediction.result : undefined;
//               slotStatus = `${BillTheLizard.ON_TIME};res=${result};${callId}`;
//               break;
//             }
//             default: {
//               const prevPrediction = billTheLizard.getPreviousPrediction(
//                 incontentsCounter,
//                 counter => `incontent_boxad_${counter}`,
//                 'cheshirecat',
//               );
//
//               if (prevPrediction === undefined) {
//                 slotStatus = BillTheLizard.NOT_USED;
//               } else {
//                 slotStatus = `${BillTheLizard.REUSED};res=${prevPrediction.result};${callId}`;
//               }
//             }
//           }
//           adSlot.btlStatus = slotStatus;
//           incontentsCounter += 1;
//         }
//       });
//
//       events.on(events.BIDS_REFRESH, () => {
//         cheshirecatCalled = true;
//         refreshedSlotNumber = incontentsCounter;
//       });
//
//       events.on(events.BILL_THE_LIZARD_REQUEST, (event) => {
//         const { query, callId } = event;
//         let propName = 'btl_request';
//         if (callId) {
//           propName = `${propName}_${callId}`;
//         }
//
//         pageTracker.trackProp(propName, query);
//       });
//
//       events.on(events.BILL_THE_LIZARD_RESPONSE, (event) => {
//         const { response, callId } = event;
//         let propName = 'btl_response';
//         if (callId) {
//           propName = `${propName}_${callId}`;
//         }
//         pageTracker.trackProp(propName, response);
//       });
//     }
  },
//
//   /**
//    * Call BTL for Cheshire Cat predictions
//    *
//    * @param {number|string} callId
//    */
//   callCheshireCat(callId) {
//     const { context } = window.Wikia.adEngine;
//     const { billTheLizard } = window.Wikia.adServices;
//
//     context.set('services.billTheLizard.parameters.cheshirecat', {
//       bids: serializeBids('mobile_in_content'),
//     });
//     cheshirecatCalled = true;
//
//     billTheLizard.call(['cheshirecat'], callId);
//   },
//
//   hasAvailableModels(btlConfig, projectName) {
//     const { utils } = window.Wikia.adEngine;
//     const projects = btlConfig.projects || config.projects;
//
//     return projects && projects[projectName]
//       && projects[projectName].some(model => utils.isProperGeo(model.countries));
//   },
//
//   reset() {
//     const { billTheLizard } = window.Wikia.adServices;
//
//     cheshirecatCalled = false;
//     incontentsCounter = 1;
//
//     // Reset predictions from previous page views
//     billTheLizard.reset();
//   },
};

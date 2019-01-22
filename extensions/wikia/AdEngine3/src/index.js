import { biddersDelay } from './bidders-delay';
import { billTheLizardConfigurator } from './bill-the-lizard';
import { context, events, utils } from '@wikia/ad-engine';
import { bidders } from '@wikia/ad-engine/dist/ad-bidders';
import ads from './setup';
import slots from './slots';

import './styles.scss';

const GPT_LIBRARY_URL = '//www.googletagservices.com/tag/js/gpt.js';

function setupAdEngine(isOptedIn) {
  const wikiContext = window.ads.context;

  ads.configure(wikiContext, isOptedIn);
  // videoTracker.register();

  context.push('delayModules', biddersDelay);

  events.on(events.AD_SLOT_CREATED, (slot) => {
    console.info(`Created ad slot ${slot.getSlotName()}`);
    bidders.updateSlotTargeting(slot.getSlotName());
  });
  // events.on(events.MOAT_YI_READY, (data) => {
  //  pageTracker.trackProp('moat_yi', data);
  // });

  billTheLizardConfigurator.configure();

  callExternals();
  if (context.get('state.showAds')) {
    startAdEngine();
  }

  trackLabradorValues();
}

function startAdEngine() {
  if (context.get('wiki.opts.showAds')) {
    utils.scriptLoader.loadScript(GPT_LIBRARY_URL);

    ads.init();

    window.wgAfterContentAndJS.push(() => {
      slots.injectBottomLeaderboard();
    });
  }
}

function trackLabradorValues() {
  const labradorPropValue = utils.getSamplingResults().join(';');

  if (labradorPropValue) {
    // pageTracker.trackProp('labrador', labradorPropValue);
  }
}

function callExternals() {
    bidders.requestBids({
      responseListener: biddersDelay.markAsReady,
    });

//     krux.call();
//     moatYi.call();
}

function run() {
  window.Wikia.consentQueue = window.Wikia.consentQueue || [];

  window.Wikia.consentQueue.push(setupAdEngine);
}

function waitForBiddersResolve() {
  if (!context.get('state.showAds')) {
    return Promise.resolve();
  }

  const timeout = new Promise((resolve) => {
    setTimeout(resolve, context.get('options.maxDelayTimeout'));
  });

  return Promise.race([ timeout, biddersDelay.getPromise() ]);
}

function waitForAdStackResolve() {
  return Promise.all([
    waitForBiddersResolve()
  ]);
}

export {
  run,
  waitForAdStackResolve
}

import { biddersDelay } from './bidders/bidders-delay';
import { billTheLizardConfigurator } from './ml/configuration';
import { isAutoPlayDisabled } from './ml/executor';
import { context, events, utils } from '@wikia/ad-engine';
import { bidders } from '@wikia/ad-engine/dist/ad-bidders';
import { billTheLizard, krux, moatYi } from '@wikia/ad-engine/dist/ad-services';
import ads from './setup';
import slots from './slots';
import pageTracker from './tracking/page-tracker';

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
  events.on(events.MOAT_YI_READY, (data) => {
   pageTracker.trackProp('moat_yi', data);
  });

  billTheLizardConfigurator.configure();

  if (context.get('state.showAds')) {
    callExternals();
    startAdEngine();
  } else {
    window.wgAfterContentAndJS.push(hideAllAdSlots);
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
    pageTracker.trackProp('labrador', labradorPropValue);
  }
}

function callExternals() {
    bidders.requestBids({
      responseListener: biddersDelay.markAsReady,
    });

    krux.call();
    moatYi.call();
    billTheLizard.call(['queen_of_hearts', 'vcr']);
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

function hideAllAdSlots() {
  Object.keys(context.get('slots')).forEach((slotName) => {
    const element = document.getElementById(slotName);

    if (element) {
      element.classList.add('hidden');
    }
  });
}

export {
  isAutoPlayDisabled,
  run,
  waitForAdStackResolve
}

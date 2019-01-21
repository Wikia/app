import { track } from '../../../utils/track';
import targeting from '../targeting';

const onRenderEndedStatusToTrack = [
  'collapse',
  'success',
];
const onChangeStatusToTrack = [
  'blocked',
  'catlapsed',
  'error',
  'viewport-conflict',
];

function getPosParameter({ pos = '' }) {
  return (Array.isArray(pos) ? pos : pos.split(','))[0].toLowerCase();
}

function checkOptIn() {
  let geoRequires = true;

  if (window.M === 'undefined') {
    geoRequires = true;
  } else if (typeof window.M.geoRequiresConsent !== 'undefined') {
    geoRequires = window.M.geoRequiresConsent;
  } else if (typeof window.M.continent !== 'undefined') {
    geoRequires = window.M.continent === 'EU';
  }

  if (geoRequires) {
    const { context } = window.Wikia.adEngine;

    return context.get('options.trackingOptIn') ? 'yes' : 'no';
  }

  return '';
}

/**
  * Prepare data for render ended tracking
  * @param {Object} slot
  * @param {Object} data
  * @returns {Object}
  */
function prepareData(slot, data) {
  // Global imports:
  const { context, utils } = window.Wikia.adEngine;
  // End of imports

  const now = new Date();
  const slotName = slot.getSlotName();

  return Object.assign({
    pv: window.pvNumber,
    browser: data.browser,
    country: utils.getCountryCode(),
    time_bucket: data.time_bucket,
    timestamp: data.timestamp,
    tz_offset: now.getTimezoneOffset(),
    device: context.get('state.deviceType'),
    ad_load_time: data.timestamp - window.performance.timing.connectStart,
    product_lineitem_id: data.line_item_id || '',
    creative_id: data.creative_id || '',
    creative_size: data.creative_size || '',
    slot_size: data.creative_size || '',
    ad_status: data.status,
    page_width: data.page_width,
    viewport_height: data.viewport_height,
    kv_skin: context.get('targeting.skin'),
    kv_pos: getPosParameter(slot.getTargeting()),
    kv_wsi: slot.getTargeting().wsi || '',
    kv_rv: slot.getTargeting().rv || '',
    kv_lang: context.get('targeting.lang') || '',
    kv_s0: context.get('targeting.s0'),
    kv_s1: context.get('targeting.s1'),
    kv_s2: context.get('targeting.s2'),
    kv_s0v: context.get('targeting.s0v') || '',
    kv_ah: window.document.body.scrollHeight,
    kv_esrb: context.get('targeting.esrb'),
    kv_ref: context.get('targeting.ref'),
    kv_top: context.get('targeting.top'),
    labrador: utils.getSamplingResults().join(';'),
    btl: slot.btlStatus,
    opt_in: checkOptIn(),
    document_visibility: utils.getDocumentVisibilityStatus(),
    // Missing:
    // bidder_won, bidder_won_price, page_layout, rabbit, scroll_y, product_chosen
  }, targeting.getBiddersPrices(slotName));
}

/**
  * Wrapper for player data warehouse tracking
  */
export default {
  /**
  * Checks whether tracker is enabled via instant global
  * @returns {boolean}
  */
  isEnabled() {
    // Global imports:
    const { context } = window.Wikia.adEngine;
    // End of imports

    return context.get('options.tracking.kikimora.slot');
  },

  /**
   * Track custom slot event to data warehouse
   * @param {Object} adSlot
   * @param {Object} data
   * @returns {void}
   */
  onCustomEvent(adSlot, data) {
    track(Object.assign(
      {
        eventName: 'adengadinfo',
        trackingMethod: 'internal',
      },
      prepareData(adSlot, data),
    ));
  },

  /**
  * Track render ended event to data warehouse
  * @param {Object} adSlot
  * @param {Object} data
  * @returns {void}
  */
  onRenderEnded(adSlot, data) {
    const status = adSlot.getStatus();

    if (onRenderEndedStatusToTrack.indexOf(status) !== -1) {
      track(Object.assign(
        {
          eventName: 'adengadinfo',
          trackingMethod: 'internal',
        },
        prepareData(adSlot, data),
      ));
    } else if (status === 'manual') {
      adSlot.trackOnStatusChanged = true;
    }
  },

  /**
  * Track status changed event (other than success and collapse) to data warehouse
  * @param {Object} adSlot
  * @param {Object} data
  * @returns {void}
  */
  onStatusChanged(adSlot, data) {
    const status = adSlot.getStatus();

    if (onChangeStatusToTrack.indexOf(status) !== -1 || adSlot.trackOnStatusChanged) {
      track(Object.assign(
        {
          eventName: 'adengadinfo',
          trackingMethod: 'internal',
        },
        prepareData(adSlot, data),
      ));
      delete adSlot.trackOnStatusChanged;
    }
  },
};

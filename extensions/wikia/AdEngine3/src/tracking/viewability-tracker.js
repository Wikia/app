import { track } from '../../../utils/track';

/**
  * Prepare data for render ended tracking
  * @param {Object} slot
  * @param {Object} data
  * @returns {Object}
  */
function prepareData(slot, data) {
  const now = new Date();
  return {
    wsi: slot.getTargeting().wsi || '',
    line_item_id: data.line_item_id,
    creative_id: data.creative_id,
    rv: slot.getTargeting().rv || 1,
    timestamp: data.timestamp,
    tz_offset: now.getTimezoneOffset(),
  };
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

    return context.get('options.tracking.kikimora.viewability');
  },

  /**
  * Track viewabiltiy impression to data warehouse
  * @param {Object} adSlot
  * @param {Object} data
  * @returns {void}
  */
  onImpressionViewable(adSlot, data) {
    track(Object.assign(
      {
        eventName: 'adengviewability',
        trackingMethod: 'internal',
      },
      prepareData(adSlot, data),
    ));
  },
};

const googleAnalyticsSettings = {
  name: 'babdetector',
  dimension: 6,
};

let status = false;
let detectionCompleted = false;

function trackBlocking(isAdBlockDetected) {
  const value = isAdBlockDetected ? 'Yes' : 'No';

  status = isAdBlockDetected;
  detectionCompleted = true;

  M.tracker.UniversalAnalytics.setDimension(googleAnalyticsSettings.dimension, value);
  M.tracker.UniversalAnalytics.track(`ads-${googleAnalyticsSettings.name}-detection`, 'impression', value, 0, true);
}

function track() {
  // Global imports:
  const { utils } = window.Wikia.adEngine;
  // End of imports

  if (!detectionCompleted) {
    utils.client.checkBlocking(
      () => trackBlocking(true),
      () => trackBlocking(false),
    );
  } else {
    trackBlocking(status);
  }
}

export default {
  track,
};

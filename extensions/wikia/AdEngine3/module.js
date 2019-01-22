// Initialize ads module
require(['ext.wikia.adEngine3.ads'], function (ads) {
  ads.run();
});

// AdEngine3 JS API that can be used outside extensions/Wikia/AdEngine3 directory
define('ext.wikia.adEngine3.api', [
  'ext.wikia.adEngine3',
  'ext.wikia.adEngine3.ads',
  'ext.wikia.adEngine3.products'
], function (adEngine, ads, products) {
  function shouldShowAds() {
    return adEngine.context.get('state.showAds');
  }

  return {
    shouldShowAds: shouldShowAds,
    jwplayerAdsFactory: products.jwplayerAdsFactory,
    waitForAdStackResolve: ads.waitForAdStackResolve
  }
});

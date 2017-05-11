jest.dontMock('../../js/components/utils');
var Utils = require('../../js/components/utils');

describe('Utils', function () {
  it('tests the utility functions', function () {
    var text = 'This is text. Really really long text that needs to be truncated to smaller text the fits on X amount of lines.';
    var div = document.createElement('div');
    div.clientWidth = 20;
    var truncateText = Utils.truncateTextToWidth(div, text);
    expect(truncateText).toContain(text);

    var cloned = Utils.clone({player: 'v4'});
    expect(cloned.player).toEqual('v4');

    var extended = Utils.extend({player: 'v4'}, {player: 'v3'});
    expect(extended.player).toEqual('v3');

    var formatedSeconds = Utils.formatSeconds(888.031);
    expect(formatedSeconds).toEqual('14:48');
    formatedSeconds = Utils.formatSeconds(80088.031);
    expect(formatedSeconds).toEqual('22:14:48');

    var browserSupportsTouch = Utils.browserSupportsTouch();
    expect(browserSupportsTouch).toBeFalsy();
  });

  it('tests isSafari', function () {
    window.navigator.userAgent = 'AppleWebKit';
    var isSafari = Utils.isSafari();
    expect(isSafari).toBeTruthy();
    window.navigator.userAgent = 'jsdom';
    isSafari = Utils.isSafari();
    expect(isSafari).toBeFalsy();
  });

  it('tests isEdge', function () {
    window.navigator.userAgent = 'Edge';
    var isEdge = Utils.isEdge();
    expect(isEdge).toBeTruthy();
    window.navigator.userAgent = 'jsdom';
    isEdge = Utils.isEdge();
    expect(isEdge).toBeFalsy();
  });

  it('tests isIE', function () {
    window.navigator.userAgent = 'MSIE';
    var isIE = Utils.isIE();
    expect(isIE).toBeTruthy();
    window.navigator.userAgent = 'jsdom';
    isIE = Utils.isIE();
    expect(isIE).toBeFalsy();
  });

  it('tests isAndroid', function () {
    window.navigator.appVersion = 'Android';
    var isAndroid = Utils.isAndroid();
    expect(isAndroid).toBeTruthy();
    window.navigator.appVersion = 'jsdom';
    isAndroid = Utils.isAndroid();
    expect(isAndroid).toBeFalsy();
  });

  it('tests isIos', function () {
    window.navigator.platform = 'iPhone';
    var isIos = Utils.isIos();
    expect(isIos).toBeTruthy();
    window.navigator.platform = 'jsdom';
    isIos = Utils.isIos();
    expect(isIos).toBeFalsy();
  });

  it('tests isIPhone', function () {
    window.navigator.platform = 'iPod';
    var isIPhone = Utils.isIPhone();
    expect(isIPhone).toBeTruthy();
    window.navigator.platform = 'jsdom';
    isIPhone = Utils.isIPhone();
    expect(isIPhone).toBeFalsy();
  });

  it('tests isMobile', function () {
    window.navigator.platform = 'iPod';
    var isMobile = Utils.isMobile();
    expect(isMobile).toBeTruthy();
    window.navigator.platform = 'jsdom';
    isMobile = Utils.isMobile();
    expect(isMobile).toBeFalsy();
  });

  it('tests isIE10', function () {
    window.navigator.userAgent = 'MSIE 10';
    var isIE10 = Utils.isIE10();
    expect(isIE10).toBeTruthy();
    window.navigator.userAgent = 'jsdom';
    isIE10 = Utils.isIE10();
    expect(isIE10).toBeFalsy();
  });

  it('tests getLanguageToUse', function () {
    var skinConfig = {
      localization: {
        defaultLanguage: 'zh'
      }
    };
    var skinConfig2 = {
      localization: {
        defaultLanguage: '',
        availableLanguageFile: [
          {
            "language": "en",
            "languageFile": "//player.ooyala.com/static/v4/candidate/latest/skin-plugin/en.json",
            "androidResource": "skin-config/en.json",
            "iosResource": "en"
          },
          {
            "language": "es",
            "languageFile": "//player.ooyala.com/static/v4/candidate/latest/skin-plugin/es.json",
            "androidResource": "skin-config/es.json",
            "iosResource": "es"
          },
          {
            "language": "zh",
            "languageFile": "//player.ooyala.com/static/v4/candidate/latest/skin-plugin/zh.json",
            "androidResource": "skin-config/zh.json",
            "iosResource": "zh"
          }
        ]
      }
    };
    var getLanguageToUse = Utils.getLanguageToUse(skinConfig);
    expect(getLanguageToUse).toEqual('zh');
    window.navigator.browserLanguage = 'es-US';
    getLanguageToUse = Utils.getLanguageToUse(skinConfig2);
    expect(getLanguageToUse).toEqual('es');
  });

  it('tests getLocalizedString', function () {
    var text = 'This is the share page';
    var localizedString = Utils.getLocalizedString('en', 'shareText', {en: {shareText: text}});
    expect(localizedString).toBe(text);

    localizedString = Utils.getLocalizedString(null, null, null);
    expect(localizedString).toBe("");
  });

  it('tests getPropertyValue', function () {
    var defaultVal = Utils.getPropertyValue({}, 'property.nestedProp', 'default');
    expect(defaultVal).toEqual('default');

    var undefinedVal = Utils.getPropertyValue({}, 'property.nestedProp');
    expect(undefinedVal).toBeUndefined();

    var existingVal = Utils.getPropertyValue({ property: { nestedProp: 'value' } }, 'property.nestedProp');
    expect(existingVal).toEqual('value');
  });

  it('tests highlight', function () {
    var div = document.createElement('div');
    var opacity = '0.6';
    var color = '#0000FF';
    Utils.highlight(div, opacity, color);
    expect(div.style.opacity).toBe(opacity);
    expect(div.style.color).toBe('rgb(0, 0, 255)');

    Utils.removeHighlight(div, '1', 'white');
    expect(div.style.opacity).toBe('1');
    expect(div.style.color).toBe('white');
    expect(div.style.filter).toBe('');
  });

  it('tests collapse', function () {
    var controlBarItems = [{"name":"playPause","location":"controlBar","whenDoesNotFit":"keep","minWidth":45},{"name":"volume","location":"controlBar","whenDoesNotFit":"keep","minWidth":240},{"name":"timeDuration","location":"controlBar","whenDoesNotFit":"drop","minWidth":145},{"name":"flexibleSpace","location":"controlBar","whenDoesNotFit":"keep","minWidth":1},{"name":"share","location":"controlBar","whenDoesNotFit":"moveToMoreOptions","minWidth":45},{"name":"discovery","location":"controlBar","whenDoesNotFit":"moveToMoreOptions","minWidth":45},{"name":"closedCaption","location":"controlBar","whenDoesNotFit":"moveToMoreOptions","minWidth":45},{"name":"quality","location":"controlBar","whenDoesNotFit":"moveToMoreOptions","minWidth":45},{"name":"logo","location":"controlBar","whenDoesNotFit":"keep","minWidth":125},{"name":"fullscreen","location":"controlBar","whenDoesNotFit":"keep","minWidth":45},{"name":"moreOptions","location":"controlBar","whenDoesNotFit":"keep","minWidth":45}];
    var items = Utils.collapse(600, controlBarItems, 1);
    expect(items.fit.length).toBe(6); expect(items.overflow.length).toBe(5);

    items = Utils.collapse(1200, controlBarItems, 1);
    expect(items.fit.length).toBe(11); expect(items.overflow.length).toBe(0);

    items = Utils.collapse(820, controlBarItems, 1);
    expect(items.fit.length).toBe(10); expect(items.overflow.length).toBe(1);

    items = Utils.collapse(320, controlBarItems, 0.7);
    expect(items.fit.length).toBe(6); expect(items.overflow.length).toBe(5);

    items = Utils.collapse(1280, controlBarItems, 1.2);
    expect(items.fit.length).toBe(11); expect(items.overflow.length).toBe(0);

    items = Utils.collapse('a', controlBarItems, 1);
    expect(items).toBe(controlBarItems);

    items = Utils.collapse(500, null, 1);
    expect(items).toEqual([]);
  });

  it('tests findThumbnail', function () {
    var thumbData = {"data":{"available_time_slices":[0,15,30,45,60,75,90],"available_widths":[96,426,1280],"thumbnails":{"0":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/Ut_HKthATH4eww8X4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/Ut_HKthATH4eww8X4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/Ut_HKthATH4eww8X4xMDoxOjA4MTsiGN"}},"15":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/3Gduepif0T1UGY8H4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/3Gduepif0T1UGY8H4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/3Gduepif0T1UGY8H4xMDoxOjA4MTsiGN"}},"30":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/QCdjB5HwFOTaWQ8X4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/QCdjB5HwFOTaWQ8X4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/QCdjB5HwFOTaWQ8X4xMDoxOjA4MTsiGN"}},"45":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/DLOokYc8UKM-fB9H4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/DLOokYc8UKM-fB9H4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/DLOokYc8UKM-fB9H4xMDoxOjA4MTsiGN"}},"60":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/PE3O6Z9ojHeNSk7H4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/PE3O6Z9ojHeNSk7H4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/PE3O6Z9ojHeNSk7H4xMDoxOjA4MTsiGN"}},"75":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/AZ2ZgMjz0LFGHCPn4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/AZ2ZgMjz0LFGHCPn4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/AZ2ZgMjz0LFGHCPn4xMDoxOjA4MTsiGN"}},"90":{"96":{"width":96,"height":40,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/MGngRNnbuHoiqTJH4xMDoxOjAzO6fyGr"},"426":{"width":426,"height":181,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/MGngRNnbuHoiqTJH4xMDoxOmFkOxyVqc"},"1280":{"width":1280,"height":544,"url":"http://cf.c.ooyala.com/RmZW4zcDo6KqkTIhn1LnowEZyUYn5Tb2/MGngRNnbuHoiqTJH4xMDoxOjA4MTsiGN"}}}}};
    var thumbs = Utils.findThumbnail(thumbData, 44, 888);
    expect(thumbs.pos).toBe(2);

    thumbs = Utils.findThumbnail(thumbData, 800, 888);
    expect(thumbs.pos).toBe(6);

    thumbs = Utils.findThumbnail(thumbData, 0, 888);
    thumbs = Utils.findThumbnail(thumbData, 15, 888);
    expect(thumbs.pos).toBe(1);

    thumbs = Utils.findThumbnail(thumbData, 33, 100);
    expect(thumbs.pos).toBe(2);
  });

  it('tests createMarkup', function () {
    var markup = 'This is &quot;markup&quot;';
    var html = Utils.createMarkup(markup);
    expect(html.__html).toBe(markup);
  });
});

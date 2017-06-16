jest.dontMock('../../js/components/videoQualityPanel')
    .dontMock('../../js/components/utils')
    .dontMock('../../js/components/icon')
    .dontMock('../../js/constants/constants')
    .dontMock('classnames');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var CONSTANTS = require('../../js/constants/constants');
var VideoQualityPanel = require('../../js/components/videoQualityPanel');
var skinConfig = require('../../config/skin.json');
var Utils = require('../../js/components/utils');

// start unit test
describe('VideoQualityPanel', function () {
  var selectedBitrate = null;

  var mockController = {
    state: {
      isMobile: false,
      "videoQualityOptions": {
        "showVideoQualityPopover":true
      },
      volumeState: {
        volume: 1
      },
      closedCaptionOptions: {availableLanguages: true}
    },
    sendVideoQualityChangeEvent: function(selectedData){
      selectedBitrate = selectedData;
    }
  };

  var mockSkinConfig = Utils.clone(skinConfig);

  var availableBitrates = [{"id":"auto", "bitrate":0}, {"id":"1", "bitrate":1000}, {"id":"2", "bitrate":2000}, {"id":"3", "bitrate":3000}, {"id":"4", "bitrate":4000}, {"id":"5", "bitrate":5000}];
  var bitrateLabels = ['1 kbps', '2 kbps','3 kbps','4 kbps','5 kbps'];

  var mockProps = {
    controller: mockController,
    videoQualityOptions: {
      availableBitrates: availableBitrates,
      selectedBitrate: null
    },
    skinConfig: mockSkinConfig
  };

  it('creates video quality panel', function () {
    var DOM = TestUtils.renderIntoDocument(
      <VideoQualityPanel {...mockProps} />
    );
    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn');
    expect(bitrateItems.length).toBe(availableBitrates.length-1);

    for (i=0; i<bitrateItems.length; i++){
      var itemText = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn')[i].textContent;
      expect(itemText).toEqual(bitrateLabels[i]);
    }
  });

  it('selects item from video quality panel', function () {
    var DOM = TestUtils.renderIntoDocument(
      <VideoQualityPanel {...mockProps} />
    );
    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-selected');
    expect(bitrateItems.length).toBe(1);
    expect(bitrateItems[0].querySelector("[class*=label]").textContent).toBe('Auto');

    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn');
    expect(bitrateItems.length).toBe(availableBitrates.length-1);

    for (i=0; i<bitrateItems.length; i++){
      var newBitrate = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn')[i];
      TestUtils.Simulate.click(newBitrate);
      expect(selectedBitrate.id).toBe(availableBitrates[i+1].id);
    }
  });

  it('selects item from video quality panel with accent color', function () {
    mockSkinConfig.general.accentColor = "blue";
    mockSkinConfig.controlBar.iconStyle.active.color = "";

    var DOM = TestUtils.renderIntoDocument(
      <VideoQualityPanel {...mockProps} />
    );
    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-selected');
    expect(bitrateItems.length).toBe(1);
    expect(bitrateItems[0].querySelector("[class*=label]").textContent).toBe('Auto');
    var autoBitrate = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-quality-auto-label');

    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn');
    expect(bitrateItems.length).toBe(availableBitrates.length-1);
    expect(autoBitrate.style.color).toBe("blue");
    expect(bitrateItems[0].style.color).not.toBe("blue");

    for (i=0; i<bitrateItems.length; i++){
      var newBitrate = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn')[i];
      TestUtils.Simulate.click(newBitrate);
      expect(selectedBitrate.id).toBe(availableBitrates[i+1].id);
      expect(autoBitrate.style.color).not.toBe("blue");
      expect(newBitrate.style.color).toBe("blue");
    }
  });

  it('selects item from video quality panel with controlbar iconStyle color', function () {
    mockSkinConfig.general.accentColor = "red";

    var DOM = TestUtils.renderIntoDocument(
      <VideoQualityPanel {...mockProps} />
    );
    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-selected');
    expect(bitrateItems.length).toBe(1);
    expect(bitrateItems[0].querySelector("[class*=label]").textContent).toBe('Auto');
    var autoBitrate = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-quality-auto-label');

    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn');
    expect(bitrateItems.length).toBe(availableBitrates.length-1);
    expect(autoBitrate.style.color).toBe("red");
    expect(bitrateItems[0].style.color).not.toBe("red");

    for (i=0; i<bitrateItems.length; i++){
      var newBitrate = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality-btn')[i];
      TestUtils.Simulate.click(newBitrate);
      expect(selectedBitrate.id).toBe(availableBitrates[i+1].id);
      expect(autoBitrate.style.color).not.toBe("red");
      expect(newBitrate.style.color).toBe("red");
    }
  });

  it('checks selected item is still there', function () {
    var mockProps = {
      controller: mockController,
      videoQualityOptions: {
        availableBitrates: availableBitrates,
        selectedBitrate: availableBitrates[1]
      },
      skinConfig: skinConfig
    };
    var DOM = TestUtils.renderIntoDocument(
      <VideoQualityPanel {...mockProps} />
    );
    var bitrateItems = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-selected');
    expect(bitrateItems.length).toBe(1);
    expect(bitrateItems[0].textContent).toBe(bitrateLabels[0]);
  });
});

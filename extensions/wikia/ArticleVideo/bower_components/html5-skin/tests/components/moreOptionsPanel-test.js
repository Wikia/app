jest.dontMock('../../js/components/moreOptionsPanel')
    .dontMock('../../js/components/utils')
    .dontMock('../../js/components/icon')
    .dontMock('../../js/constants/constants')
    .dontMock('../../js/mixins/animateMixin')
    .dontMock('classnames');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var CONSTANTS = require('../../js/constants/constants');
var MoreOptionsPanel = require('../../js/components/moreOptionsPanel');
var skinConfig = require('../../config/skin.json');
var Utils = require('../../js/components/utils');

// start unit test
describe('MoreOptionsPanel', function () {
  it('creates more options panel', function () {

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"share", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":200 },
      {"name":"discovery", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":200 },
      {"name":"closedCaption", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":200 },
      {"name":"quality", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":200 }
    ];

    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {availableLanguages: true},
        videoQualityOptions: {
          availableBitrates: true
        },
        discoveryData: true,
        moreOptionsItems: oneButtonSkinConfig.buttons.desktopContent
      },
      toggleDiscoveryScreen: function() {
        discoveryScreenToggled = true;
      },
      toggleShareScreen: function() {
        shareScreenToggled = true;
      },
      toggleScreen: function() {
        toggleScreenClicked = true;
      }
    };

    var mockProps = {
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <MoreOptionsPanel {...mockProps}
        playerState={CONSTANTS.STATE.PLAYING}
        controlBarVisible={true}
        controlBarWidth={100} />
    );

    //test mouseover highlight
    var span = TestUtils.scryRenderedDOMComponentsWithTag(DOM, 'span');
    for(var i=0; i<span.length; i++){
      TestUtils.Simulate.mouseOver(span[i]);
      TestUtils.Simulate.mouseOut(span[i]);
    }

    //test btn clicks
    var button = TestUtils.scryRenderedDOMComponentsWithTag(DOM, 'a');
    for(var j=0; j<button.length; j++){
      TestUtils.Simulate.click(button[j]);
    }
    expect(toggleScreenClicked).toBe(true);
    expect(shareScreenToggled).toBe(true);
    expect(discoveryScreenToggled).toBe(true);
  });
});

//bitrate selection, closed captions, discovery buttons not available
describe('MoreOptionsPanel', function () {
  it('checks cc button not available', function () {

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [];

    mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {availableLanguages: null},
        videoQualityOptions: {
          availableBitrates: null
        },
        discoveryData: null,
        moreOptionsItems: oneButtonSkinConfig.buttons.desktopContent
      }
    };
    var mockProps = {
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <MoreOptionsPanel {...mockProps}
        playerState={CONSTANTS.STATE.PLAYING}
        controlBarVisible={true}
        controlBarWidth={100} />
    );

    var ccButtons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-closed-caption');
    expect(ccButtons.length).toBe(0);

    var qualityButtons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality');
    expect(qualityButtons.length).toBe(0);

    var discoveryButtons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-discovery');
    expect(discoveryButtons.length).toBe(0);
  });
});
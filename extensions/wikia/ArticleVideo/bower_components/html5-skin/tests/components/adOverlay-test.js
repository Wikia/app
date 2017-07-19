jest.dontMock('../../js/components/adOverlay');
jest.dontMock('../../js/constants/constants');
jest.dontMock('../../js/components/closeButton');
jest.dontMock('classnames');

var React = require('react');
var ReactDOM = require('react-dom');
var TestUtils = require('react-addons-test-utils');
var AdOverlay = require('../../js/components/adOverlay');
var CONSTANTS = require('../../js/constants/constants');

describe('AdOverlay', function () {
  it('creates an AdOverlay', function () {
    var loaded = false;
    var mockController = {
      state: {
        isMobile: false
      },
      onAdOverlayLoaded: function() {
        loaded = true;
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      icons: {
        dismiss: {
          fontStyleClass: "dismiss"
        }
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdOverlay
        controller={mockController}
        skinConfig={mockSkinConfig}
        overlay={true}
        showOverlay={true}
      />);

    var adOverlayImage = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-ad-overlay-image');
    TestUtils.Simulate.load(adOverlayImage);
    expect(loaded).toBe(true);
  });

  it('handles a click', function () {
    var clickSource = "";
    var mockController = {
      state: {
        isMobile: false
      },
      onAdsClicked: function(source) {
        clickSource = source;
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      icons: {
        dismiss: {
          fontStyleClass: "dismiss"
        }
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdOverlay
        controller={mockController}
        skinConfig={mockSkinConfig}
      />);

    var ad = TestUtils.findRenderedDOMComponentWithTag(DOM, 'a');
    TestUtils.Simulate.click(ad);
    expect(clickSource).toBe(CONSTANTS.AD_CLICK_SOURCE.OVERLAY);
  });

  it('closes', function () {
    var nonLinearHidden = false;
    var adSkipped = false;
    var mockController = {
      state: {
        isMobile: false
      },
      onSkipAdClicked: function() {
        adSkipped = true;
      },
      onAdsClicked: function(source) {
      },
      closeNonlinearAd: function() {
        nonLinearHidden = true;
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      icons: {
        dismiss: {
          fontStyleClass: "dismiss"
        }
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdOverlay
        controller={mockController}
        skinConfig={mockSkinConfig}
      />);

    var closeBtn = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-ad-overlay-close-button');
    TestUtils.Simulate.click(closeBtn);
    expect(nonLinearHidden).toBe(true);
    expect(adSkipped).toBe(true);
  });

  it('hides and shows the close button', function () {
    var nonLinearHidden = false;
    var adSkipped = false;
    var mockController = {
      state: {
        isMobile: false
      },
      onSkipAdClicked: function() {
        adSkipped = true;
      },
      onAdsClicked: function(source) {
      },
      closeNonlinearAd: function() {
        nonLinearHidden = true;
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      icons: {
        dismiss: {
          fontStyleClass: "dismiss"
        }
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdOverlay
        controller={mockController}
        skinConfig={mockSkinConfig}
        showOverlayCloseButton={false}
      />);

    var closeBtn = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-ad-overlay-close-button');
    expect(closeBtn.className).toMatch("hidden");

    DOM = TestUtils.renderIntoDocument(
      <AdOverlay
        controller={mockController}
        skinConfig={mockSkinConfig}
        showOverlayCloseButton={true}
      />);

    closeBtn = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-ad-overlay-close-button');
    expect(closeBtn.className).not.toMatch("hidden");
  });
});
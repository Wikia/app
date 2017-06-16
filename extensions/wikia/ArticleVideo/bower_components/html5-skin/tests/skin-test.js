jest.dontMock('../js/skin');
jest.dontMock('../js/constants/constants');
jest.dontMock('../js/components/utils');
jest.dontMock('../js/mixins/responsiveManagerMixin');
jest.dontMock('screenfull');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var Skin = require('../js/skin');
var CONSTANTS = require('../js/constants/constants');

describe('Skin', function () {
  it('tests methods', function () {
    var skinComponent = TestUtils.renderIntoDocument(<Skin />);
    skinComponent.handleClickOutsidePlayer();
    skinComponent.updatePlayhead(4,6,8);
    skinComponent.componentWillUnmount();
  });
});

describe('Skin screenToShow state', function () {
  beforeEach(function() {
    // Render skin into DOM
    this.skin = TestUtils.renderIntoDocument(<Skin />);
  });

  it('tests LOADING SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.LOADING_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests START SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.START_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests PLAYING SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.PLAYING_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests SHARE SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.SHARE_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests PAUSE SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.PAUSE_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests END SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.END_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests AD SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.AD_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests DISCOVERY SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.DISCOVERY_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests MORE OPTIONS SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.MORE_OPTIONS_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests CLOSED CAPTION SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.CLOSEDCAPTION_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests VIDEO QUALITY SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.VIDEO_QUALITY_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests ERROR SCREEN', function () {
    this.skin.switchComponent({
      screenToShow: CONSTANTS.SCREEN.ERROR_SCREEN,
      responsiveId: "md"
    });
  });

  it('tests DEFAULT SCREEN', function () {
    this.skin.switchComponent({
      responsiveId: "md"
    });
  });

  it('tests w/o args', function () {
    this.skin.switchComponent();
  });
});

describe('Skin', function () {
  it('tests IE10', function () {
    // set user agent to IE 10
    window.navigator.userAgent = "MSIE 10";

    // render skin into DOM
    var skinComponent = TestUtils.renderIntoDocument(<Skin />);
  });

  it('tests IE10 START SCREEN', function () {
    // set user agent to IE 10
    window.navigator.userAgent = "MSIE 10";

    // render skin into DOM
    var skinComponent = TestUtils.renderIntoDocument(<Skin />);
    skinComponent.switchComponent({
      screenToShow: CONSTANTS.SCREEN.START_SCREEN,
      responsiveId: "md"
    });
  });
});
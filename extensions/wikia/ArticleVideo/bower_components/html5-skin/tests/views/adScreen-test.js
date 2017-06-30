jest.dontMock('../../js/views/adScreen')
    .dontMock('../../js/components/icon')
    .dontMock('../../js/mixins/resizeMixin');

var React = require('react');
var ReactDOM = require('react-dom');
var TestUtils = require('react-addons-test-utils');
var AdScreen = require('../../js/views/adScreen');

describe('AdScreen', function () {
  it('creates an ad screen', function () {

    // Render ad screen into DOM
    var mockController = {
      state: {
        isMobile: false
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      pauseScreen: {
        showPauseIcon: true,
        pauseIconPosition: "center",
        PauseIconStyle: {
          color: "white",
          opacity: 1
        }
      },
      icons: {
        pause: {"fontStyleClass": "oo-icon oo-icon-pause"}
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
      />);

  });

  it('handles mouseover and mouseout', function () {

    // Render ad screen into DOM
    var controlBarVisible = true;
    var mockController = {
      state: {
        isMobile: false
      },
      hideControlBar: function() {
        controlBarVisible = false;
      },
      showControlBar: function() {
        controlBarVisible = true;
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      pauseScreen: {
        showPauseIcon: true,
        pauseIconPosition: "center",
        PauseIconStyle: {
          color: "white",
          opacity: 1
        }
      },
      icons: {
        pause: {"fontStyleClass": "oo-icon oo-icon-pause"}
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
        controlBarAutoHide={true}
      />);

    expect(DOM.state.controlBarVisible).toBe(true);
    TestUtils.Simulate.mouseOut(ReactDOM.findDOMNode(DOM));
    expect(DOM.state.controlBarVisible).toBe(false);
    expect(controlBarVisible).toBe(false);

    TestUtils.Simulate.mouseOver(ReactDOM.findDOMNode(DOM));
    expect(DOM.state.controlBarVisible).toBe(true);
    expect(controlBarVisible).toBe(true);
  });

it('checks that ad marquee is shown/not shown when appropriate', function () {

    // Render ad screen into DOM
    var mockController = {
      state: {
        isMobile: false,
        showAdMarquee: true
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      pauseScreen: {
        showPauseIcon: true,
        pauseIconPosition: "center",
        PauseIconStyle: {
          color: "white",
          opacity: 1
        }
      },
      icons: {
        pause: {"fontStyleClass": "oo-icon oo-icon-pause"}
      }
    };

    //showing ad marquee
    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
        controlBarAutoHide={true}
      />);

    var adPanel = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-ad-panel');
    expect(adPanel[0]._childNodes.length).not.toBe(0);

    //not showing ad marquee
    mockController.state.showAdMarquee = true;
    mockSkinConfig.adScreen.showAdMarquee = false;

    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
        controlBarAutoHide={true}
      />);

    var adPanel1 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-ad-panel');
    expect(adPanel1[0]._childNodes.length).toBe(0);

    //not showing ad marquee
    mockController.state.showAdMarquee = false;
    mockSkinConfig.adScreen.showAdMarquee = true;

    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
        controlBarAutoHide={true}
      />);

    var adPanel2 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-ad-panel');
    expect(adPanel2[0]._childNodes.length).toBe(0);

  });

  it('handles mousemove', function () {

    // Render ad screen into DOM
    var controlBarVisible = true;
    var mockController = {
      state: {
        isMobile: false,
        controlBarVisible: false
      },
      hideControlBar: function() {
        controlBarVisible = false;
      },
      showControlBar: function() {
        controlBarVisible = true;
      },
      startHideControlBarTimer: function() {}
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      pauseScreen: {
        showPauseIcon: true,
        pauseIconPosition: "center",
        PauseIconStyle: {
          color: "white",
          opacity: 1
        }
      },
      icons: {
        pause: {"fontStyleClass": "icon icon-pause"}
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        playerState={"playing"}
        controller={mockController}
        skinConfig={mockSkinConfig}
        controlBarAutoHide={true}
        fullscreen={true}
      />);

    expect(DOM.state.controlBarVisible).toBe(true);
    TestUtils.Simulate.mouseMove(ReactDOM.findDOMNode(DOM));
    expect(DOM.state.controlBarVisible).toBe(false);

  });

  it('test player clicks', function () {

    // Render ad screen into DOM
    var adsClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        accessibilityControlsEnabled: false
      },
      onAdsClicked: function() {
        adsClicked = true;
      }
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      pauseScreen: {
        showPauseIcon: true,
        pauseIconPosition: "center",
        PauseIconStyle: {
          color: "white",
          opacity: 1
        }
      },
      icons: {
        pause: {"fontStyleClass": "icon icon-pause"}
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
      />);

    TestUtils.Simulate.mouseUp(DOM.refs.adScreen);
    expect(mockController.state.accessibilityControlsEnabled).toBe(true);

    TestUtils.Simulate.click(DOM.refs.adPanel);
    expect(adsClicked).toBe(true);
  });

  it('tests ad componentWill*', function () {
    var adsClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        accessibilityControlsEnabled: false,
        controlBarVisible: false
      },
      onAdsClicked: function() {
        adsClicked = true;
      },
      cancelTimer: function() {},
      startHideControlBarTimer: function() {}
    };
    var mockController2 = {
      state: {
        isMobile: true,
        accessibilityControlsEnabled: false,
        controlBarVisible: true
      },
      onAdsClicked: function() {
        adsClicked = true;
      },
      cancelTimer: function() {},
      startHideControlBarTimer: function() {}
    };
    var mockSkinConfig = {
      adScreen: {
        showControlBar: true,
        showAdMarquee: true
      },
      pauseScreen: {
        showPauseIcon: true,
        pauseIconPosition: "center",
        PauseIconStyle: {
          color: "white",
          opacity: 1
        }
      },
      icons: {
        pause: {"fontStyleClass": "icon icon-pause"}
      }
    };

    var node = document.createElement('div');
    var adScreen = ReactDOM.render(
      <AdScreen
        controller={mockController}
        skinConfig={mockSkinConfig}
        componentWidth={400}
        fullscreen={true} />, node
    );

    ReactDOM.render(
      <AdScreen
        controller={mockController2}
        skinConfig={mockSkinConfig}
        componentWidth={800}
        fullscreen={false} />, node
    );

    var event = {
      stopPropagation: function() {},
      cancelBubble: function() {},
      type: 'touchend'
    };

    adScreen.handleTouchEnd(event);
    ReactDOM.unmountComponentAtNode(node);
  });

});
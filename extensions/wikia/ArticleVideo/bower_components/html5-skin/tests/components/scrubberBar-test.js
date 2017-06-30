jest.dontMock('../../js/components/scrubberBar')
    .dontMock('../../js/components/utils')
    .dontMock('../../js/components/thumbnail')
    .dontMock('../../js/components/thumbnailCarousel')
    .dontMock('../../js/constants/constants')
    .dontMock('../../config/skin.json');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var CONSTANTS = require('../../js/constants/constants');
var skinConfig = require('../../config/skin.json');
var ReactDOM = require('react-dom');
var ScrubberBar = require('../../js/components/scrubberBar');
var Utils = require('../../js/components/utils');

var thumbnails = { "data":{ "available_time_slices":[ 0, 10 ], "available_widths":[ 120 ], "thumbnails":{ "0":{ "120":{ "url":"http://media.video-cdn.espn.com/motion/2016/0504/Hu_160504_Deportes_Pura_Quimica_MiltonCenter_Miercoles/chaptertn/Hu_160504_Deportes_Pura_Quimica_MiltonCenter_Miercoles_1.jpg", "width":120, "height":80 } }, "10":{ "120":{ "url":"http://media.video-cdn.espn.com/motion/2016/0504/Hu_160504_Deportes_Pura_Quimica_MiltonCenter_Miercoles/chaptertn/Hu_160504_Deportes_Pura_Quimica_MiltonCenter_Miercoles_2.jpg", "width":120, "height":80 } }, "errors":[ { "status":404, "code":"Not Found", "title":"unable to find thumbnail images", "detail":"embed code not found" } ] } }};

// start unit test
describe('ScrubberBar', function () {
  it('creates a scrubber bar', function () {

    var mockController = {
      state: {
        isMobile: false
      }
    };

    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        skinConfig={skinConfig}
        />
    );
  });

  it('creates a scrubber bar played bar and play head with accent color', function () {
    var mockController = {
      state: {
        isMobile: false
      }
    };
    var mockSkinConfig = Utils.clone(skinConfig);
    mockSkinConfig.general.accentColor = "blue";
    mockSkinConfig.controlBar.scrubberBar.playedColor = "";

    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        skinConfig={mockSkinConfig}
        />
    );
    var playheadBar = TestUtils.findRenderedDOMComponentWithClass(DOM, "oo-playhead");
    expect(playheadBar.style.backgroundColor).toBe("blue");
    expect(ReactDOM.findDOMNode(DOM.refs.playhead).style.backgroundColor).toBe("blue");
  });

  it('creates a scrubber bar played bar and play head with scrubberbar played color setting', function () {
    var mockController = {
      state: {
        isMobile: false
      }
    };
    var mockSkinConfig = Utils.clone(skinConfig);
    mockSkinConfig.general.accentColor = "blue";
    mockSkinConfig.controlBar.scrubberBar.playedColor = "green";
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        skinConfig={mockSkinConfig}
        />
    );
    var playheadBar = TestUtils.findRenderedDOMComponentWithClass(DOM, "oo-playhead");
    expect(playheadBar.style.backgroundColor).toBe("green");
    expect(ReactDOM.findDOMNode(DOM.refs.playhead).style.backgroundColor).toBe("green");
  });

  it('handles a mousedown', function() {
    var scrubberBarClicked = false;
    var mockController = {
      state: {
        isMobile: false
      },
      updateSeekingPlayhead: function() {
        scrubberBarClicked = true;
      },
      startHideControlBarTimer: function() {},
      beginSeeking: function() {},
      renderSkin: function() {}
    };
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        skinConfig={skinConfig}
        />
    );

    var scrubberBar = TestUtils.findRenderedDOMComponentWithClass(DOM, "oo-scrubber-bar-padding");
    TestUtils.Simulate.mouseDown(scrubberBar);
    expect(scrubberBarClicked).toBe(true);
  });

  it('handles a mouseup', function() {
    var scrubberBarClicked = false;
    var seekTriggered = false;
    var mockController = {
      state: {
        isMobile: false
      },
      updateSeekingPlayhead: function() {
        scrubberBarClicked = true;
      },
      startHideControlBarTimer: function() {},
      beginSeeking: function() {},
      renderSkin: function() {},
      seek: function() {
        seekTriggered = true;
      },
      endSeeking: function() {}
    };
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        skinConfig={skinConfig}
        />
    );

    var scrubberBar = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-scrubber-bar-padding');
    TestUtils.Simulate.mouseDown(scrubberBar);
    DOM.handlePlayheadMouseUp({
      preventDefault: function() {},
      stopPropagation: function() {}
    });
    expect(scrubberBarClicked).toBe(true);
    expect(seekTriggered).toBe(true);
  });

  it('represents current time with playhead position', function() {
    var scrubberBarClicked = false;
    var mockController = {
      state: {
        isMobile: false
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        currentPlayhead={30}
        duration={60}
        skinConfig={skinConfig}
        />
    );

    DOM.state.scrubberBarWidth = 470;
    DOM.state.playheadWidth = 10;
    DOM.forceUpdate();

    var playhead = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-playhead-padding');
    var leftPos = parseInt(playhead.style.left);
    expect(leftPos).toBeGreaterThan(200);
    expect(leftPos).toBeLessThan(300);
  });

  it('enters ad mode', function() {
    var scrubberBarClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        screenToShow: CONSTANTS.SCREEN.AD_SCREEN
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={false}
        controller={mockController}
        currentPlayhead={30}
        duration={60}
        skinConfig={skinConfig} />
    );

    var playhead = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-playhead');
    expect(playhead.className).toMatch('oo-ad-playhead');
  });

  it('display thumbnail on hover', function() {
    var mockController = {
      state: {
        isMobile: false,
        thumbnails: thumbnails
      }
    };
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={true}
        controller={mockController}
        currentPlayhead={30}
        duration={60}
        skinConfig={skinConfig}/>
    );

    var evt = {nativeEvent: {offsetX: 10}};
    TestUtils.Simulate.mouseOver(ReactDOM.findDOMNode(DOM.refs.scrubberBarContainer), evt);
    var thumbnail = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-scrubber-thumbnail-container');
    expect(thumbnail.length).toBe(1);
  });

  it('display thumbnailCarousel on scrubber bar mouse down', function() {
    var mockController = {
      state: {
        isMobile: false,
        thumbnails: thumbnails
      },
      updateSeekingPlayhead: function () {},
      startHideControlBarTimer: function () {},
      beginSeeking: function () {},
      renderSkin: function () {}
    };
    var DOM = TestUtils.renderIntoDocument(
      <ScrubberBar
        controlBarVisible={true}
        seeking={true}
        controller={mockController}
        currentPlayhead={30}
        duration={60}
        padding={0}
        skinConfig={skinConfig}/>
    );

    var evt = {nativeEvent: {offsetX: 10}};
    TestUtils.Simulate.mouseDown(ReactDOM.findDOMNode(DOM.refs.scrubberBarPadding), evt);
    var thumbnailCarousel = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-scrubber-carousel-container');
    expect(thumbnailCarousel.length).toBe(1);
  });

  it('tests a scrubber bar componentWillReceiveProps', function () {
    var mockController = {
      state: {
        isMobile: false
      }
    };

    var node = document.createElement('div');
    var scrubber = ReactDOM.render(
      <ScrubberBar
      controlBarVisible={true}
      seeking={true}
      controller={mockController}
      skinConfig={skinConfig} />, node
    );

    ReactDOM.render(
      <ScrubberBar
        controlBarVisible={false}
        seeking={false}
        controller={mockController}
        skinConfig={skinConfig} />, node
    );

    ReactDOM.unmountComponentAtNode(node);
  });

  it('tests a scrubber bar functions', function () {
    var mockController = {
      state: {
        isMobile: true
      },
      startHideControlBarTimer: function() {},
      updateSeekingPlayhead: function() {},
      beginSeeking: function() {},
      endSeeking: function() {},
      seek: function() {},
      renderSkin: function() {}
    };

    var node = document.createElement('div');
    var scrubber = ReactDOM.render(
      <ScrubberBar
        controlBarVisible={true}
        seeking={true}
        duration={8}
        controller={mockController}
        skinConfig={skinConfig} />, node
    );

    scrubber.getResponsiveUIMultiple('md');

    var event2 = {
      preventDefault: function() {},
      stopPropagation: function() {},
      touches: ['a', 'b'],
      targetTouches: [{pageX:2}, {}],
      clientX: 45,
      target: {
        className: 'padding',
        getBoundingClientRect: function() {
          return {left: 33}
        }
      },
      type: 'mousedown',
      nativeEvent: {}
    };
    scrubber.handleScrubberBarMouseDown(event2);

    var event1 = {
      preventDefault: function() {},
      touches: ['a', 'b'],
      targetTouches: [{pageX:2}, {}],
      clientX: 45,
      target: {
        className: 'oo-playhead',
        getBoundingClientRect: function() {
          return {left: 33}
        }
      },
      type: 'mouseup',
      nativeEvent: {}
    };
    scrubber.handlePlayheadMouseDown(event1);
    scrubber.handlePlayheadMouseDown(event2);
    scrubber.handlePlayheadMouseUp(event2);

    var event3 = {
      preventDefault: function() {},
      touches: ['a', 'b'],
      targetTouches: [{pageX:2}, {}],
      clientX: 45,
      target: {
        className: 'playhead',
        getBoundingClientRect: function() {
          return {left: 33}
        }
      },
      type: 'touchstart'
    };
    scrubber.handleScrubberBarMouseDown(event3);

    var event4 = {
      preventDefault: function() {},
      touches: ['a', 'b'],
      clientX: 45
    };
    scrubber.handlePlayheadMouseMove(event4);
    scrubber.handleScrubberBarMouseMove(event4);
    scrubber.handleScrubberBarMouseOut(event4);
  });

  it('tests a scrubber bar componentWillUnmount', function () {
    var mockController = {
      state: {
        isMobile: true
      }
    };

    var node = document.createElement('div');
    var scrubber = ReactDOM.render(
      <ScrubberBar
        controlBarVisible={true}
        seeking={true}
        duration={8}
        controller={mockController}
        skinConfig={skinConfig} />, node
    );

    ReactDOM.render(
      <ScrubberBar
        controlBarVisible={false}
        seeking={false}
        controller={mockController}
        skinConfig={skinConfig} />, node
    );

    ReactDOM.unmountComponentAtNode(node);
    scrubber.handlePlayheadMouseUp({});
  });

});

jest.dontMock('../../js/views/endScreen')
    .dontMock('../../js/components/icon')
    .dontMock('../../js/components/utils')
    .dontMock('classnames');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var EndScreen = require('../../js/views/endScreen');
var ClassNames = require('classnames');
var ResizeMixin = require('../../js/mixins/resizeMixin');

describe('EndScreen', function () {
  it('creates an EndScreen with replay button', function () {

    var clicked = false;
    var mockContentTree = {'description': 'description'};
    var mockController = {
      state: {
        accessibilityControlsEnabled: false
      },
      togglePlayPause: function(){clicked = true}
    };
    var mockSkinConfig = {
      startScreen: {
        titleFont: {
          color: "red"
        },
        descriptionFont: {
          color: "green"
        }
      },
      endScreen: {
        replayIconStyle: {
          color: "white",
          opacity: "1"
        },
        showReplayButton: true,
        showTitle: true,
        showDescription: true,
        infoPanelPosition: "topLeft"
      },
      icons: {
        replay: {
          fontStyleClass: "replay"
        }
      }
    };

    // Render end screen into DOM
    var DOM = TestUtils.renderIntoDocument(<EndScreen skinConfig={mockSkinConfig} controller = {mockController} contentTree = {mockContentTree}/>);

    var replayButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-action-icon');
    TestUtils.Simulate.click(replayButton);
    expect(clicked).toBe(true);
  });

  //replay without button, click on screen
  it('creates an EndScreen without replay button', function () {
    var clicked = false;
    var mockContentTree = {'description': 'description'};
    var mockController = {
      state: {
        accessibilityControlsEnabled: false
      },
      togglePlayPause: function(){clicked = true}
    };
    var mockSkinConfig = {
      startScreen: {
        titleFont: {
          color: "red"
        },
        descriptionFont: {
          color: "green"
        }
      },
      endScreen: {
        replayIconStyle: {
          color: "white",
          opacity: "1"
        },
        showReplayButton: false,
        showTitle: false,
        showDescription: false,
        infoPanelPosition: "topLeft"
      },
      icons: {
        replay: {
          fontStyleClass: "replay"
        }
      }
    };

    // Render end screen into DOM
    var DOM = TestUtils.renderIntoDocument(<EndScreen skinConfig={mockSkinConfig} controller = {mockController} contentTree = {mockContentTree}/>);

    //replay button hidden
    var replayButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-action-icon');
    expect(replayButton.className).toMatch("hidden");

    //test replay clicking on screen
    var replayScreen = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-state-screen-selectable');
    TestUtils.Simulate.click(replayScreen);

    expect(clicked).toBe(true);
  });

it('creates an EndScreen with description and title', function () {
    var mockContentTree = {'description': 'mock description', 'title': 'mock title'};
    var mockController = {
      state: {
        accessibilityControlsEnabled: false
      },
      togglePlayPause: function(){clicked = true}
    };
    var mockSkinConfig = {
      startScreen: {
        titleFont: {
          color: "red"
        },
        descriptionFont: {
          color: "green"
        }
      },
      endScreen: {
        replayIconStyle: {
          color: "white",
          opacity: "1"
        },
        showReplayButton: false,
        showTitle: true,
        showDescription: true,
        infoPanelPosition: "topLeft"
      },
      icons: {
        replay: {
          fontStyleClass: "replay"
        }
      }
    };

    // Render end screen into DOM
    var DOM = TestUtils.renderIntoDocument(<EndScreen skinConfig={mockSkinConfig} controller = {mockController} contentTree = {mockContentTree}/>);

    //description and title are shown
    var title = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-state-screen-title');
    expect(title.className).not.toMatch("hidden");
  });

it('creates an EndScreen without description and title', function () {
    var mockContentTree = {'description': 'mock description', 'title': 'mock title'};
    var mockController = {
      state: {
        accessibilityControlsEnabled: false
      },
      togglePlayPause: function(){clicked = true}
    };
    var mockSkinConfig = {
      startScreen: {
        titleFont: {
          color: "red"
        },
        descriptionFont: {
          color: "green"
        }
      },
      endScreen: {
        replayIconStyle: {
          color: "white",
          opacity: "1"
        },
        showReplayButton: false,
        showTitle: false,
        showDescription: false,
        infoPanelPosition: "topLeft"
      },
      icons: {
        replay: {
          fontStyleClass: "replay"
        }
      }
    };

    // Render end screen into DOM
    var DOM = TestUtils.renderIntoDocument(<EndScreen skinConfig={mockSkinConfig} controller = {mockController} contentTree = {mockContentTree}/>);

    //description and title are hidden
    var title = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-state-screen-title');
    expect(title.className).toMatch("hidden");
  });
});
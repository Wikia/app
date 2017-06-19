jest.dontMock('../../js/components/controlBar')
    .dontMock('../../js/components/utils')
    .dontMock('../../js/components/icon')
    .dontMock('../../js/components/logo')
    .dontMock('../../js/constants/constants')
    .dontMock('classnames');

var React = require('react');
var ReactDOM = require('react-dom');
var TestUtils = require('react-addons-test-utils');
var CONSTANTS = require('../../js/constants/constants');
var ControlBar = require('../../js/components/controlBar');
var skinConfig = require('../../config/skin.json');
var Utils = require('../../js/components/utils');

// start unit test
describe('ControlBar', function () {
  it('creates a control bar', function () {

    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        videoQualityOptions: {},
        closedCaptionOptions: {}
      }
    };

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: skinConfig,
      duration: 30
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );
  });

  it('enters fullscreen', function() {
    var fullscreenToggled = false;

    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      toggleFullscreen: function() {
        fullscreenToggled = true;
      }
    };

    var fullscreenSkinConfig = Utils.clone(skinConfig);
    fullscreenSkinConfig.buttons.desktopContent = [{"name":"fullscreen", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: fullscreenSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    expect(fullscreenToggled).toBe(false);
    var fullscreenButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-fullscreen');
    TestUtils.Simulate.click(fullscreenButton);
    expect(fullscreenToggled).toBe(true);
  });

  it('renders one button', function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [{"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-control-bar-item');
    expect(buttons.length).toBe(1);
  });

  it('renders multiple buttons', function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        },
        discoveryData: true
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 },
      {"name":"share", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"discovery", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"fullscreen", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={1200}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-control-bar-item');
    expect(buttons.length).toBe(4);
  });

  it('should mute on click and change volume', function() {
    var muteClicked = false;
    var newVolume = -1;
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      handleMuteClick: function() {muteClicked = true;},
      setVolume: function(volume) {newVolume = volume;}
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"volume", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":105 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var volumeButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-volume').firstChild;
    TestUtils.Simulate.click(volumeButton);
    expect(muteClicked).toBe(true);
    var volumeBars = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-volume-bar');
    //JEST doesn't support dataset at the time of writing
    TestUtils.Simulate.click(volumeBars[5], {target: {dataset: {volume: 5}}});
    expect(newVolume).toBeGreaterThan(-1);
  });

  it('to play on play click', function() {
    var playClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      togglePlayPause: function() {playClicked = true;}
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":105 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var playButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-play-pause').firstChild;
    TestUtils.Simulate.click(playButton);
    expect(playClicked).toBe(true);
  });

  it('to toggle share screen', function() {
    var shareClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      toggleShareScreen: function() {shareClicked = true;}
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"share", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var shareButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-share').firstChild;
    TestUtils.Simulate.click(shareButton);
    expect(shareClicked).toBe(true);
  });

  it('to toggle discovery screen', function() {
    var discoveryClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        },
        discoveryData: true
      },
      toggleDiscoveryScreen: function() {discoveryClicked = true;}
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"discovery", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.END}
        isLiveStream={mockProps.isLiveStream} />
    );

    var discoveryButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-discovery').firstChild;
    TestUtils.Simulate.click(discoveryButton);
    expect(discoveryClicked).toBe(true);
  });

  it('shows/hides closed caption button if captions available', function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"closedCaption", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var ccButtons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-closed-caption');
    expect(ccButtons.length).toBe(0);

    var toggleScreenClicked = false;
    var captionClicked = false;
    mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {availableLanguages: true},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      toggleScreen: function() {toggleScreenClicked = true;},
      toggleClosedCaptionPopOver: function(){captionClicked = true;}
    };

    // md, test cc popover
    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var ccButtons2 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-closed-caption');
    expect(ccButtons2.length).toBe(1);

    var ccButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-closed-caption').firstChild;
    TestUtils.Simulate.click(ccButton);
    expect(captionClicked).toBe(true);

    // xs, test full window view
    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig,
      responsiveView: skinConfig.responsive.breakpoints.xs.id
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
       componentWidth={350}
       playerState={CONSTANTS.STATE.PLAYING}
       isLiveStream={mockProps.isLiveStream} />
    );

    ccButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-closed-caption').firstChild;
    TestUtils.Simulate.click(ccButton);
    expect(toggleScreenClicked).toBe(true);
  });

  it('shows/hides discovery button if discovery available', function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        },
        discoveryData: false
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"discovery", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var discoveryButtons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-discovery');
    expect(discoveryButtons.length).toBe(0);

    var discoveryClicked = false;
    mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        },
        discoveryData: true
      },
      toggleDiscoveryScreen: function() {discoveryClicked = true;}
    };

    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var discoveryButtons2 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-discovery');
    expect(discoveryButtons2.length).toBe(1);

    var discoveryButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-discovery').firstChild;
    TestUtils.Simulate.click(discoveryButton);
    expect(discoveryClicked).toBe(true);
  });

  it("shows/hides the more options button appropriately", function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 },
      {"name":"moreOptions", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var optionsButton = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-more-options');
    expect(optionsButton.length).toBe(0);
    var buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-control-bar-item');
    expect(buttons.length).toBe(1);

    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"moreOptions", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }
    ];

    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={100}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    optionsButton = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-more-options');
    expect(optionsButton.length).toBe(1);
    buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-play-pause');
    expect(buttons.length).toBeLessThan(5);
  });

  it("handles more options click", function() {
    var moreOptionsClicked = false;
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      toggleMoreOptionsScreen: function() {
        moreOptionsClicked = true;
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 },
      {"name":"moreOptions", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }
    ];
    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={100}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var optionsButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-more-options');
    expect(optionsButton).not.toBe(null);
    TestUtils.Simulate.click(optionsButton);
    expect(moreOptionsClicked).toBe(true);
  });

  it("handles bad button input", function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"playPause", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 },
      {"name":"doesNotExist", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-control-bar-item');
    expect(buttons.length).toBe(1);
  });

  it("shows/hides the live indicator appropriately", function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"live", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: true,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-live');
    expect(buttons.length).toBe(1);

    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"live", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":35 }
    ];

    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={100}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    buttons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-live');
    expect(buttons.length).toBe(0);
  });

  it('highlights volume on mouseover', function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [{"name":"volume", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":100 }];
    oneButtonSkinConfig.controlBar.iconStyle.inactive.opacity = 0;
    oneButtonSkinConfig.controlBar.iconStyle.active.opacity = 1;
    oneButtonSkinConfig.controlBar.iconStyle.active.color = "red";
    oneButtonSkinConfig.controlBar.iconStyle.inactive.color = "blue";

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PAUSED}
        isLiveStream={mockProps.isLiveStream} />
    );

    expect(ReactDOM.findDOMNode(DOM.refs.volumeIcon).style.opacity).toBe("0");
    expect(ReactDOM.findDOMNode(DOM.refs.volumeIcon).style.color).toBe("blue");
    TestUtils.Simulate.mouseOver(ReactDOM.findDOMNode(DOM.refs.volumeIcon));
    expect(ReactDOM.findDOMNode(DOM.refs.volumeIcon).style.opacity).toBe("1");
    expect(ReactDOM.findDOMNode(DOM.refs.volumeIcon).style.color).toBe("red");
    TestUtils.Simulate.mouseOut(ReactDOM.findDOMNode(DOM.refs.volumeIcon));
    expect(ReactDOM.findDOMNode(DOM.refs.volumeIcon).style.opacity).toBe("0");
    expect(ReactDOM.findDOMNode(DOM.refs.volumeIcon).style.color).toBe("blue");
  });

  it('uses the volume slider on mobile', function() {
    var mockController = {
      state: {
        isMobile: true,
        volumeState: {
          volume: 1,
          volumeSliderVisible: true
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [{"name":"volume", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":100 }];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PAUSED}
        isLiveStream={mockProps.isLiveStream} />
    );
    var slider = TestUtils.findRenderedDOMComponentWithClass(DOM, "oo-volume-slider");
    expect(slider).not.toBe(null);
  });

  it('hides the volume on iOS', function() {
    window.navigator.platform = "iPhone";
    var mockController = {
      state: {
        isMobile: true,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [{"name":"volume", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":100 }];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PAUSED}
        isLiveStream={mockProps.isLiveStream} />
    );

    expect(DOM.refs.volumeIcon).toBe(undefined);

  });

  it('shows/hides quality button if bitrates available/not available', function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"quality", "location":"controlBar", "whenDoesNotFit":"moveToMoreOptions", "minWidth":35 }
    ];

    var mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var qualityButtons = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality');
    expect(qualityButtons.length).toBe(0);

    var qualityClicked = false;
    mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {availableLanguages: true},
        videoQualityOptions: {
          availableBitrates: true
        }
      },
      toggleScreen: function() {qualityClicked = true;},
      toggleVideoQualityPopOver: function(){qualityClicked = true;}
    };

    //xsmall
    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig,
      responsiveView: skinConfig.responsive.breakpoints.xs.id
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var qualityButtons2 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality');
    expect(qualityButtons2.length).toBe(1);

    qualityButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-quality').firstChild;
    TestUtils.Simulate.click(qualityButton);
    expect(qualityClicked).toBe(true);

    //medium
    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig,
      responsiveView: skinConfig.responsive.breakpoints.md.id
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var qualityButtons3 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality');
    expect(qualityButtons3.length).toBe(1);

    var qualityButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-quality').firstChild;
    TestUtils.Simulate.click(qualityButton);
    expect(qualityClicked).toBe(true);

    //large
    mockProps = {
      isLiveStream: false,
      controller: mockController,
      skinConfig: oneButtonSkinConfig,
      responsiveView: skinConfig.responsive.breakpoints.lg.id
    };

    DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={500}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var qualityButtons4 = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-quality');
    expect(qualityButtons4.length).toBe(1);

    qualityButton = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-quality').firstChild;
    TestUtils.Simulate.click(qualityButton);
    expect(qualityClicked).toBe(true);
  });

  it("renders nonclickable logo", function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"logo", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":130 }
    ];
    oneButtonSkinConfig.controlBar.logo.clickUrl = "";

    var mockProps = {
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={100}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var nonClickableLogo = TestUtils.scryRenderedDOMComponentsWithTag(DOM, 'a');
    expect(nonClickableLogo.length).toBe(0);
  });

  it("renders clickable logo", function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"logo", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":130 }
    ];
    oneButtonSkinConfig.controlBar.logo.imageResource.url = "//player.ooyala.com/static/v4/candidate/latest/skin-plugin/assets/images/ooyala-logo.svg";
    oneButtonSkinConfig.controlBar.logo.clickUrl = "http://www.ooyala.com";

    var mockProps = {
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
        componentWidth={100}
        playerState={CONSTANTS.STATE.PLAYING}
        isLiveStream={mockProps.isLiveStream} />
    );

    var logo = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-logo');
    var clickableLogo = TestUtils.scryRenderedDOMComponentsWithTag(DOM, 'a');
    expect(clickableLogo.length).toBe(1);
    TestUtils.Simulate.click(logo);
  });

  it('tests controlbar componentWill*', function () {
    var mockController = {
      state: {
        isMobile: true,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      },
      cancelTimer:function() {},
      hideVolumeSliderBar:function() {},
      startHideControlBarTimer:function() {},
      onLiveClick:function() {},
      seek: function() {},
      handleMuteClick: function() {},
      showVolumeSliderBar: function() {}
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"logo", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":130 }
    ];
    oneButtonSkinConfig.controlBar.logo.clickUrl = "http://www.ooyala.com";
    var mockProps = {
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var node = document.createElement('div');
    var controlBar = ReactDOM.render(
      <ControlBar
        {...mockProps}
        controlBarVisible={true}
        componentWidth={100}
        responsiveView="sm" />, node
    );

    ReactDOM.render(
      <ControlBar
        {...mockProps}
        controlBarVisible={true}
        componentWidth={300}
        responsiveView="md" />, node
    );

    var event = {
      stopPropagation: function() {},
      cancelBubble: function() {},
      preventDefault: function() {},
      type: 'touchend'
    };
    controlBar.handleControlBarMouseUp(event);
    controlBar.handleLiveClick(event);

    window.navigator.appVersion = 'Android';
    controlBar.handleVolumeIconClick(event);
    ReactDOM.unmountComponentAtNode(node);
  });

  it("tests logo without image resource url", function() {
    var mockController = {
      state: {
        isMobile: false,
        volumeState: {
          volume: 1
        },
        closedCaptionOptions: {},
        videoQualityOptions: {
          availableBitrates: null
        }
      }
    };

    var oneButtonSkinConfig = Utils.clone(skinConfig);
    oneButtonSkinConfig.buttons.desktopContent = [
      {"name":"logo", "location":"controlBar", "whenDoesNotFit":"keep", "minWidth":130 }
    ];
    oneButtonSkinConfig.controlBar.logo.imageResource.url = "";
    oneButtonSkinConfig.controlBar.logo.clickUrl = "http://www.ooyala.com";

    var mockProps = {
      controller: mockController,
      skinConfig: oneButtonSkinConfig
    };

    var DOM = TestUtils.renderIntoDocument(
      <ControlBar {...mockProps} controlBarVisible={true}
                  componentWidth={100}
                  playerState={CONSTANTS.STATE.PLAYING}
                  isLiveStream={mockProps.isLiveStream} />
    );

    var logo = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-logo');
    expect(logo.length).toBe(0);
  });
});

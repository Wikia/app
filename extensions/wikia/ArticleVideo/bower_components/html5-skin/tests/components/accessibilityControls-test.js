jest.dontMock('../../js/components/accessibilityControls');
jest.dontMock('../../js/constants/constants');

var CONSTANTS = require('../../js/constants/constants');
var AccessibilityControls = require('../../js/components/accessibilityControls');

describe('AccessibilityControls', function () {
  it('test space key', function () {
    var controllerMock = {
      state: {
        accessibilityControlsEnabled: true
      },
      togglePlayPause: function() {}
    };

    var mockEvent = {
      keyCode: CONSTANTS.KEYCODES.SPACE_KEY,
      preventDefault: function() {}
    };

    var accessibilityControls = new AccessibilityControls(controllerMock);
    accessibilityControls.handleKey(mockEvent)
  });

  it('tests down arrow key', function () {
    var controllerMock = {
      state: {
        accessibilityControlsEnabled: true,
        volumeState: {
          volume: 2
        }
      },
      togglePlayPause: function() {},
      setVolume: function() {}
    };

    var mockEvent = {
      keyCode: CONSTANTS.KEYCODES.DOWN_ARROW_KEY,
      preventDefault: function() {}
    };

    var accessibilityControls = new AccessibilityControls(controllerMock);
    accessibilityControls.handleKey(mockEvent)
  });

  it('tests up arrow key', function () {
    var controllerMock = {
      state: {
        accessibilityControlsEnabled: true,
        volumeState: {
          volume: 0.5
        }
      },
      togglePlayPause: function() {},
      setVolume: function() {}
    };

    var mockEvent = {
      keyCode: CONSTANTS.KEYCODES.UP_ARROW_KEY,
      preventDefault: function() {}
    };

    var accessibilityControls = new AccessibilityControls(controllerMock);
    accessibilityControls.handleKey(mockEvent)
  });

  it('tests right arrow key', function () {
    var controllerMock = {
      state: {
        accessibilityControlsEnabled: true,
        volumeState: {
          volume: 0.5
        }
      },
      skin: {
        state: {
          currentPlayhead: 4
        }
      },
      togglePlayPause: function() {},
      setVolume: function() {},
      seek: function() {}
    };

    var mockEvent = {
      keyCode: CONSTANTS.KEYCODES.RIGHT_ARROW_KEY,
      preventDefault: function() {}
    };

    var accessibilityControls = new AccessibilityControls(controllerMock);
    accessibilityControls.handleKey(mockEvent)
  });

  it('tests left arrow key', function () {
    var controllerMock = {
      state: {
        accessibilityControlsEnabled: true,
        volumeState: {
          volume: 0.5
        }
      },
      skin: {
        state: {
          currentPlayhead: 4
        }
      },
      togglePlayPause: function() {},
      setVolume: function() {},
      seek: function() {}
    };

    var mockEvent = {
      keyCode: CONSTANTS.KEYCODES.LEFT_ARROW_KEY,
      preventDefault: function() {}
    };

    var accessibilityControls = new AccessibilityControls(controllerMock);
    accessibilityControls.handleKey(mockEvent);
    accessibilityControls.handleKey(mockEvent);
  });

  it('tests disabled accessibility controls', function () {
    var controllerMock = {
      state: {
        accessibilityControlsEnabled: false
      }
    };
    var mockEvent = {};

    var accessibilityControls = new AccessibilityControls(controllerMock);
    accessibilityControls.handleKey(mockEvent)
  });



});
jest.dontMock('../../js/views/errorScreen');
jest.dontMock('../../js/mixins/accessibilityMixin');
jest.dontMock('../../js/components/utils');
jest.dontMock('../../js/constants/constants');
jest.dontMock('../../js/mixins/accessibilityMixin');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var ErrorScreen = require('../../js/views/errorScreen');

describe('ErrorScreen', function () {
  it('test error screen with valid error code', function () {
    var errorCode = {
      code: "network"
    };
    // Render error screen into DOM
    var DOM = TestUtils.renderIntoDocument(<ErrorScreen errorCode={errorCode} />);
  });

  it('test error screen with invalid error code', function () {
    var errorCode = {
      code: "404"
    };
    // Render error screen into DOM
    var DOM = TestUtils.renderIntoDocument(<ErrorScreen errorCode={errorCode} />);
  });
});
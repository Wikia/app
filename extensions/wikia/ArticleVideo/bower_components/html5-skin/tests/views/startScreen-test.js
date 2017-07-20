jest.dontMock('../../js/views/startScreen')
  .dontMock('../../js/components/icon');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var StartScreen = require('../../js/views/startScreen');

describe('StartScreen', function () {
  it('test start screen', function () {

    // Render start screen into DOM
    var DOM = TestUtils.renderIntoDocument(<StartScreen />);

    //test play
    var playBtn = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-state-screen-selectable');
    TestUtils.Simulate.click(playBtn);
  });
});
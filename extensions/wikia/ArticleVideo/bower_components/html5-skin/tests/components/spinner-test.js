jest.dontMock('../../js/components/spinner');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var Spinner = require('../../js/components/spinner');

describe('Spinner', function () {
  it('tests spinner', function () {

    //Render spinner into DOM
    var DOM = TestUtils.renderIntoDocument(<Spinner />);
  });
});
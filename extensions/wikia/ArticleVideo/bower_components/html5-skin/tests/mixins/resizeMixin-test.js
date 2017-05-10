jest.dontMock('../../js/mixins/resizeMixin');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var ResizeMixin = require('../../js/mixins/resizeMixin');

describe('ResizeMixin', function () {
  it('creates a ResizeMixin', function () {
    var thisMock = {
      props: {
        componentWidth: 400
      },
      handleResize: function(){}
    };
    var nextProps = {
      componentWidth: 200
    };
    ResizeMixin.componentWillReceiveProps.call(thisMock, nextProps);
  });
});
jest.dontMock('../../js/components/watermark')
    .dontMock('../../js/components/utils');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var Watermark = require('../../js/components/watermark');

describe('Watermark', function () {
  var clicked = false;
  var paused = false;
  var playerState = 'playing';
  var mockProps = {
    skinConfig: {
      general: {
        watermark: {
          imageResource: {
            url: 'http://ooyala.com'
          },
          clickUrl: 'http://ooyala.com',
          position: 'bottomRight',
          target: '_blank',
          transparency: 1,
          scalingOption: 'default',
          scalingPercentage: 20
        }
      }
    },
    playerState: playerState,
    controller: {
      togglePlayPause: function(){
        if (playerState == 'playing') {
          paused = true;
          playerState = 'paused';
        }
        else paused = false;
      },
      state: {
        isMobile: false
      }
    }
  }
  it('renders watermark', function () {
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    //test clickable watermark
    var watermark = DOM.refs['watermark'];
  });

  it('tests watermark position', function () {
    mockProps.skinConfig.general.watermark.position = 'left';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    var watermark = DOM.refs['watermark'];
  });

  it('tests watermark position', function () {
    mockProps.skinConfig.general.watermark.position = 'right';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    var watermark = DOM.refs['watermark'];
  });

  it('tests watermark position', function () {
    mockProps.skinConfig.general.watermark.position = 'bottom';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    var watermark = DOM.refs['watermark'];
  });

  it('tests watermark position', function () {
    mockProps.skinConfig.general.watermark.position = 'top';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    var watermark = DOM.refs['watermark'];
  });

  it('tests watermark image default width', function () {
    mockProps.skinConfig.general.watermark.scalingOption = 'default';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    //test watermark width is default
    var image = DOM.refs['watermark'];
    expect(image.style.width).toBe('10%');
  });

  it('tests watermark image with set width', function () {
    mockProps.skinConfig.general.watermark.scalingOption = 'width';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    //test watermark width
    var image = DOM.refs['watermark'];
    expect(image.style.width).toBe(mockProps.skinConfig.general.watermark.scalingPercentage +'%');
  });

  it('tests watermark image with set height', function () {
    mockProps.skinConfig.general.watermark.scalingOption = 'height';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    //test watermark height
    var image = DOM.refs['watermark'];
    expect(image.style.height).toBe(mockProps.skinConfig.general.watermark.scalingPercentage +'%');
  });

  it('tests watermark image with no scaling option', function () {
    mockProps.skinConfig.general.watermark.scalingOption = 'none';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={true}/>
    );

    //test watermark width is not changed
    var image = DOM.refs['watermark'];
    var check = (image.style.width == 'auto' || image.style.width == '')
    expect(check).toBe(true);
  });

  it('tests watermark click', function () {
    var clicked = false;
    //Render watermark into DOM
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={false}/>
    );

    var clickable = DOM.refs['watermark'];
    TestUtils.Simulate.click(clickable);
    expect(paused).toBe(true);

    mockProps.playerState = 'paused';
    playerState = 'paused';
    TestUtils.Simulate.click(clickable);
    expect(paused).toBe(false);

    mockProps.playerState = 'playing';
    playerState = 'playing';
  });

  it('tests watermark not clickable', function () {
    var clicked = false;
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={false}
        nonClickable = {true}/>
    );

    DOM.handleWatermarkClick = function() {clicked = true;};
    var watermark = DOM.refs['watermark'];
    TestUtils.Simulate.click(watermark);
    expect(clicked).toBe(false);

    mockProps.playerState = 'playing';
    playerState = 'playing';
  });

  it('tests no watermark shown', function () {
    mockProps.skinConfig.general.watermark.imageResource.url = '';
    DOM = TestUtils.renderIntoDocument(
      <Watermark {...mockProps}
        controlBarVisible={false}/>
    );
    expect(DOM.refs['watermark']).toBe(undefined);
    mockProps.skinConfig.general.watermark.imageResource.url = 'http://ooyala.com';
  });
});
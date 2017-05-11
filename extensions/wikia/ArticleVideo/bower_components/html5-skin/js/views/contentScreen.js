var React = require('react'),
    CloseButton = require('../components/closeButton'),
    Utils = require('../components/utils'),
    CONSTANTS = require('../constants/constants'),
    Icon = require('../components/icon'),
    Watermark = require('../components/watermark'),
    AccessibilityMixin = require('../mixins/accessibilityMixin');

var ContentScreen = React.createClass({
  mixins: [AccessibilityMixin],

  handleClose: function() {
    switch(this.props.screen) {
      case CONSTANTS.SCREEN.DISCOVERY_SCREEN:
        this.props.controller.toggleDiscoveryScreen();
        break;
      default:
        this.props.controller.toggleScreen(this.props.screen);
    }
  },

  render: function() {
    //overlay only for the closed captions screen. Needs to be different than the other screens because of closed caption preview.
    var closedCaptionOverlay = this.props.screen == CONSTANTS.SCREEN.CLOSEDCAPTION_SCREEN ? (
      <div className="oo-closed-caption-overlay"></div>
    ) :
    null;

    var titleBarStyle = {};
    switch (this.props.screen) {
      case CONSTANTS.SCREEN.DISCOVERY_SCREEN:
        titleBarStyle.fontFamily = Utils.getPropertyValue(this.props.skinConfig, 'discoveryScreen.panelTitle.titleFont.fontFamily');
        titleBarStyle.color = Utils.getPropertyValue(this.props.skinConfig, 'discoveryScreen.panelTitle.titleFont.color');
        break;
    }

    //localized title bar, show nothing if no title text
    var titleBar = this.props.titleText ? (
      <div className="oo-content-screen-title" style={titleBarStyle}>
        {Utils.getLocalizedString(this.props.language, this.props.titleText, this.props.localizableStrings)}
        <Icon {...this.props} icon={this.props.icon}/>
        {this.props.element}
      </div>
    ) :
    null;

    return (
      <div>
        <Watermark {...this.props} controlBarVisible={false} nonClickable={true}/>
        <div className={this.props.screenClassName}>
          {closedCaptionOverlay}
          <div className={this.props.titleBarClassName}>
            {titleBar}
            <CloseButton {...this.props} closeAction={this.handleClose}/>
          </div>
          {this.props.children}
        </div>
      </div>
    );
  }
});

ContentScreen.propTypes = {
  element: React.PropTypes.element,
  skinConfig: React.PropTypes.shape({
    discoveryScreen: React.PropTypes.shape({
      panelTitle: React.PropTypes.shape({
        titleFont: React.PropTypes.shape({
          color: React.PropTypes.string,
          fontFamily: React.PropTypes.string
        })
      })
    })
  })
};

ContentScreen.defaultProps = {
  screen: CONSTANTS.SCREEN.SHARE_SCREEN,
  screenClassName: 'oo-content-screen',
  titleBarClassName: 'oo-content-screen-title-bar',
  titleText: '',
  element: null,
  icon: 'share',
  controller: {
    toggleScreen: function(){},
    state: {
      accessibilityControlsEnabled: true
    }
  }
};

module.exports = ContentScreen;

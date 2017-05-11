/********************************************************************
 MORE OPTIONS PANEL
 *********************************************************************/
/**
 * @class MoreOptionsPanel
 * @constructor
 */
var React = require('react'),
    Utils = require('./utils'),
    CONSTANTS = require('../constants/constants'),
    ClassNames = require('classnames'),
    AnimateMixin = require('../mixins/animateMixin'),
    Icon = require('../components/icon');

var MoreOptionsPanel = React.createClass({
  mixins: [AnimateMixin],

  handleShareClick: function () {
    this.props.controller.toggleShareScreen();
  },

  handleQualityClick: function() {
    this.props.controller.toggleScreen(CONSTANTS.SCREEN.VIDEO_QUALITY_SCREEN);
  },

  handleDiscoveryClick: function () {
    this.props.controller.toggleDiscoveryScreen();
  },

  handleClosedCaptionClick: function () {
    this.props.controller.toggleScreen(CONSTANTS.SCREEN.CLOSEDCAPTION_SCREEN);
  },

  highlight: function (evt) {
    var color = this.props.skinConfig.moreOptionsScreen.iconStyle.active.color;
    var opacity = this.props.skinConfig.moreOptionsScreen.iconStyle.active.opacity;
    Utils.highlight(evt.target, opacity, color);
  },

  removeHighlight: function (evt) {
    var color = this.props.skinConfig.moreOptionsScreen.iconStyle.inactive.color;
    var opacity = this.props.skinConfig.moreOptionsScreen.iconStyle.inactive.opacity;
    Utils.removeHighlight(evt.target, opacity, color);
  },

  buildMoreOptionsButtonList: function () {
    //inline style for config/skin.json elements only
    var buttonStyle = {
      fontSize: this.props.skinConfig.moreOptionsScreen.iconSize + "px",
      color: this.props.skinConfig.moreOptionsScreen.iconStyle.inactive.color,
      opacity: this.props.skinConfig.moreOptionsScreen.iconStyle.inactive.opacity
    };

    var optionsItemsTemplates = {
      "quality": <a className="oo-quality oo-control-bar-item" onClick={this.handleQualityClick} key="quality">
        <Icon {...this.props} icon="quality" style={buttonStyle}
         onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "discovery": <a className="oo-discovery oo-control-bar-item" onClick={this.handleDiscoveryClick} key="discovery">
        <Icon {...this.props} icon="discovery" style={buttonStyle}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "closedCaption": <a className="oo-closed-caption oo-control-bar-item" onClick={this.handleClosedCaptionClick} key="closedCaption">
        <Icon {...this.props} icon="cc" style={buttonStyle}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "share": <a className="oo-share oo-control-bar-item" onClick={this.handleShareClick} key="share">
        <Icon {...this.props} icon="share" style={buttonStyle}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "settings": <div className="oo-settings" key="settings">
        <Icon {...this.props} icon="setting" style={buttonStyle}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </div>
    };

    var items = this.props.controller.state.moreOptionsItems;
    var moreOptionsItems = [];
    
    for (var i = 0; i < items.length; i++) {
      moreOptionsItems.push(optionsItemsTemplates[items[i].name]);
    }

    return moreOptionsItems;
  },

  render: function () {
    var moreOptionsItemsClass = ClassNames({
      'oo-more-options-items': true,
      'oo-animate-more-options': this.state.animate
    });

    var moreOptionsItems = this.buildMoreOptionsButtonList();

    return (
      <div className="oo-content-panel oo-more-options-panel">
        <div className={moreOptionsItemsClass}>
          {moreOptionsItems}
        </div>
      </div>
    );
  }
});

MoreOptionsPanel.defaultProps = {
  skinConfig: {
    moreOptionsScreen: {
      iconStyle: {
        active: {
          color: '#FFF',
          opacity: 1

        },
        inactive: {
          color: '#FFF',
          opacity: 0.6
        }
      }
    }
  }
};

module.exports = MoreOptionsPanel;
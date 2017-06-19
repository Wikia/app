/********************************************************************
  END SCREEN
*********************************************************************/
var React = require('react'),
    ReactDOM = require('react-dom'),
    ClassNames = require('classnames'),
    ControlBar = require('../components/controlBar'),
    Watermark = require('../components/watermark'),
    Icon = require('../components/icon'),
    ResizeMixin = require('../mixins/resizeMixin'),
    Utils = require('../components/utils');

var EndScreen = React.createClass({
  mixins: [ResizeMixin],

  getInitialState: function() {
    return {
      controlBarVisible: true,
      descriptionText: this.props.contentTree.description
    };

  },

  componentDidMount: function() {
    this.handleResize();
  },

  handleResize: function() {
    if (ReactDOM.findDOMNode(this.refs.description)){
      this.setState({
        descriptionText: Utils.truncateTextToWidth(ReactDOM.findDOMNode(this.refs.description), this.props.contentTree.description)
      });
    }
  },

  handleClick: function(event) {
    // pause or play the video if the skin is clicked
    event.preventDefault();
    this.props.controller.state.accessibilityControlsEnabled = true;
    this.props.controller.togglePlayPause();
  },

  render: function() {
    var actionIconStyle = {
      color: this.props.skinConfig.endScreen.replayIconStyle.color,
      opacity: this.props.skinConfig.endScreen.replayIconStyle.opacity
    };

    var titleStyle = {
      color: this.props.skinConfig.startScreen.titleFont.color
    };
    var descriptionStyle = {
      color: this.props.skinConfig.startScreen.descriptionFont.color
    };

    var actionIconClass = ClassNames({
      'oo-action-icon': true,
      'oo-hidden': !this.props.skinConfig.endScreen.showReplayButton
    });

    var infoPanelPosition = Utils.getPropertyValue(this.props.skinConfig, 'endScreen.infoPanelPosition');

    if (infoPanelPosition) {
      var infoPanelClass = ClassNames({
        'oo-state-screen-info': true,
        'oo-info-panel-top': infoPanelPosition.toLowerCase().indexOf("top") > -1,
        'oo-info-panel-bottom': infoPanelPosition.toLowerCase().indexOf("bottom") > -1,
        'oo-info-panel-left': infoPanelPosition.toLowerCase().indexOf("left") > -1,
        'oo-info-panel-right': infoPanelPosition.toLowerCase().indexOf("right") > -1
      });
      var titleClass = ClassNames({
        'oo-state-screen-title': true,
        'oo-text-truncate': true,
        'oo-pull-right': infoPanelPosition.toLowerCase().indexOf("right") > -1,
        'oo-hidden': !Utils.getPropertyValue(this.props.skinConfig, 'endScreen.showTitle')
      });
      var descriptionClass = ClassNames({
        'oo-state-screen-description': true,
        'oo-pull-right': infoPanelPosition.toLowerCase().indexOf("right") > -1,
        'oo-hidden': !Utils.getPropertyValue(this.props.skinConfig, 'endScreen.showDescription')
      });
    }

    var titleMetadata = (<div className={titleClass} style={titleStyle}>{this.props.contentTree.title}</div>);
    var descriptionMetadata = (<div className={descriptionClass} ref="description" style={descriptionStyle}>{this.state.descriptionText}</div>);

    return (
      <div className="oo-state-screen oo-end-screen">
        <div className="oo-underlay-gradient"></div>

        <a className="oo-state-screen-selectable" onClick={this.handleClick}></a>

        <Watermark {...this.props} controlBarVisible={this.state.controlBarVisible}/>

        <div className={infoPanelClass}>
          {titleMetadata}
          {descriptionMetadata}
        </div>

        <a className={actionIconClass} onClick={this.handleClick}>
          <Icon {...this.props} icon="replay" style={actionIconStyle}/>
        </a>

        <div className="oo-interactive-container">
          <ControlBar {...this.props}
            controlBarVisible={this.state.controlBarVisible}
            playerState={this.props.playerState}
            isLiveStream={this.props.isLiveStream} />
        </div>
      </div>
    );
  }
});
module.exports = EndScreen;
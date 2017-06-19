/********************************************************************
 START SCREEN
 *********************************************************************/
var React = require('react'),
    ReactDOM = require('react-dom'),
    ClassNames = require('classnames'),
    CONSTANTS = require('../constants/constants'),
    Spinner = require('../components/spinner'),
    Icon = require('../components/icon'),
    Watermark = require('../components/watermark'),
    ResizeMixin = require('../mixins/resizeMixin'),
    Utils = require('../components/utils');

var StartScreen = React.createClass({
  mixins: [ResizeMixin],

  getInitialState: function() {
    return {
      playButtonClicked: false,
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
    event.preventDefault();
    this.props.controller.togglePlayPause();
    this.props.controller.state.accessibilityControlsEnabled = true;
    this.setState({playButtonClicked: true});
  },

  render: function() {
    //inline style for config/skin.json elements only
    var titleStyle = {
      color: this.props.skinConfig.startScreen.titleFont.color
    };
    var descriptionStyle = {
      color: this.props.skinConfig.startScreen.descriptionFont.color
    };
    var actionIconStyle = {
      color: this.props.skinConfig.startScreen.playIconStyle.color,
      opacity: this.props.skinConfig.startScreen.playIconStyle.opacity
    };
    var posterImageUrl = this.props.skinConfig.startScreen.showPromo ? this.props.contentTree.promo_image : '';
    var posterStyle = {
      backgroundImage: "url('" + posterImageUrl + "')"
    };

    //CSS class manipulation from config/skin.json
    var stateScreenPosterClass = ClassNames({
      'oo-state-screen-poster': this.props.skinConfig.startScreen.promoImageSize != "small",
      'oo-state-screen-poster-small': this.props.skinConfig.startScreen.promoImageSize == "small"
    });
    var infoPanelClass = ClassNames({
      'oo-state-screen-info': true,
      'oo-info-panel-top': this.props.skinConfig.startScreen.infoPanelPosition.toLowerCase().indexOf("top") > -1,
      'oo-info-panel-bottom': this.props.skinConfig.startScreen.infoPanelPosition.toLowerCase().indexOf("bottom") > -1,
      'oo-info-panel-left': this.props.skinConfig.startScreen.infoPanelPosition.toLowerCase().indexOf("left") > -1,
      'oo-info-panel-right': this.props.skinConfig.startScreen.infoPanelPosition.toLowerCase().indexOf("right") > -1
    });
    var titleClass = ClassNames({
      'oo-state-screen-title': true,
      'oo-text-truncate': true,
      'oo-pull-right': this.props.skinConfig.startScreen.infoPanelPosition.toLowerCase().indexOf("right") > -1
    });
    var descriptionClass = ClassNames({
      'oo-state-screen-description': true,
      'oo-pull-right': this.props.skinConfig.startScreen.infoPanelPosition.toLowerCase().indexOf("right") > -1
    });
    var actionIconClass = ClassNames({
      'oo-action-icon': true,
      'oo-action-icon-top': this.props.skinConfig.startScreen.playButtonPosition.toLowerCase().indexOf("top") > -1,
      'oo-action-icon-bottom': this.props.skinConfig.startScreen.playButtonPosition.toLowerCase().indexOf("bottom") > -1,
      'oo-action-icon-left': this.props.skinConfig.startScreen.playButtonPosition.toLowerCase().indexOf("left") > -1,
      'oo-action-icon-right': this.props.skinConfig.startScreen.playButtonPosition.toLowerCase().indexOf("right") > -1,
      'oo-hidden': !this.props.skinConfig.startScreen.showPlayButton
    });

    var titleMetadata = (<div className={titleClass} style={titleStyle}>{this.props.contentTree.title}</div>);
    var iconName = (this.props.controller.state.playerState == CONSTANTS.STATE.END ? "replay" : "play");
    var descriptionMetadata = (<div className={descriptionClass} ref="description" style={descriptionStyle}>{this.state.descriptionText}</div>);

    var actionIcon = (
      <a className={actionIconClass} onClick={this.handleClick}>
        <Icon {...this.props} icon={iconName} style={actionIconStyle}/>
      </a>
    );

    return (
      <div className="oo-state-screen oo-start-screen">
        <div className={stateScreenPosterClass} style={posterStyle}>
          <div className="oo-start-screen-linear-gradient"></div>
          <a className="oo-state-screen-selectable" onClick={this.handleClick}></a>
        </div>
        <Watermark {...this.props} controlBarVisible={false}/>
        <div className={infoPanelClass}>
          {this.props.skinConfig.startScreen.showTitle ? titleMetadata : null}
          {this.props.skinConfig.startScreen.showDescription ? descriptionMetadata : null}
        </div>

        {(this.state.playButtonClicked && this.props.controller.state.playerState == CONSTANTS.STATE.START) || this.props.controller.state.buffering ?
          <Spinner loadingImage={this.props.skinConfig.general.loadingImage.imageResource.url}/> : actionIcon}
      </div>
    );
  }
});

StartScreen.propTypes = {
  skinConfig: React.PropTypes.shape({
    startScreen: React.PropTypes.shape({
      playIconStyle: React.PropTypes.shape({
        color: React.PropTypes.string
      })
    }),
    icons: React.PropTypes.objectOf(React.PropTypes.object)
  })
};

StartScreen.defaultProps = {
  skinConfig: {
    general: {
      loadingImage: {
        imageResource: {
          url: null
        }
      }
    },
    startScreen: {
      titleFont: {
      },
      descriptionFont: {
      },
      playIconStyle: {
        color: 'white'
      },
      infoPanelPosition: 'topLeft',
      playButtonPosition: 'center',
      showPlayButton: true,
      showPromo: true,
      showTitle: true,
      showDescription: true,
      promoImageSize: 'default'
    },
    icons: {
      play:{fontStyleClass:'oo-icon oo-icon-play'},
      replay:{fontStyleClass:'oo-icon oo-icon-upnext-replay'}
    }
  },
  controller: {
    togglePlayPause: function(){},
    state: {
      playerState:'start',
      buffering: false
    }
  },
  contentTree: {
    promo_image: '',
    description:'',
    title:''
  }
};

module.exports = StartScreen;
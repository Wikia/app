/********************************************************************
 WIKIA AD SCREEN
 *********************************************************************/
var React = require('react'),
  CONSTANTS = require('../constants/constants'),
  ControlBar = require('../components/controlBar');

var WikiaAdScreen = React.createClass({

  getInitialState: function () {
    return {
      isMobile: this.props.controller.state.isMobile
    };
  },

  getPlaybackControlItems: function () {
    if (!this.props.skinConfig.adScreen.showControlBar) return null;

    var showControlBar =
      this.props.controller.state.controlBarVisible || this.props.playerState == CONSTANTS.STATE.PAUSE;

    var playbackControlItemTemplates = {
      "controlBar": <ControlBar {...this.props}
                                controlBarVisible={showControlBar}
                                playerState={this.props.playerState}
                                isWikiaAdScreen={true}
                                showAdTimeLeft={this.props.controller.state.showAdTimeLeft}
                                showAdFullScreenToggle={this.props.controller.state.showAdFullScreenToggleToggle}
                                key='controlBar'/>
    };

    var playbackControlItems = [];
    for (var item in playbackControlItemTemplates) {
      if (playbackControlItemTemplates.hasOwnProperty(item)) {
        playbackControlItems.push(playbackControlItemTemplates[item]);
      }
    }

    return playbackControlItems;
  },

  // FIXME XW-3636 move this to controller.js (?) so the first click shows controls, not toggles
  // play/pause
  // onClick: function (e) {
  //   if (!this.state.controlBarVisible && this.props.playerState !== CONSTANTS.STATE.PAUSE) {
  //     this.props.controller.startHideControlBarTimer();
  //     this.showControlBar();
  //   } else {
  //     this.props.controller.togglePlayPause();
  //   }
  //   e.stopPropagation();
  // },

  render: function () {
    var playbackControlItems = null;
    if (this.props.skinConfig.adScreen.showControlBar) {
      playbackControlItems = this.getPlaybackControlItems();
    }

    return (
      <div className="oo-state-screen oo-wikia-ad-screen" ref="wikiaAdScreen">
        <div className="oo-interactive-container">
          {playbackControlItems}
        </div>
      </div>
    );
  }
});
module.exports = WikiaAdScreen;
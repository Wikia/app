/********************************************************************
 AD PANEL
 *********************************************************************/
/**
 * The screen used while the video is playing.
 *
 * @class AdPanel
 * @constructor
 */
var React = require('react'),
  CONSTANTS = require('../constants/constants'),
  Spinner = require('./spinner'),
  ClassNames = require('classnames'),
  Utils = require('./utils'),
  Icon = require('../components/icon');

var AdPanelTopBarItem = React.createClass({
  render: function() {
    return (
      <a className={this.props.itemClassName} onClick={this.props.onButtonClicked}>
        {this.props.children}
      </a>
    );
  }
});

var AdPanel = React.createClass({
  getInitialState: function() {
    this.isMobile = this.props.controller.state.isMobile;
    return null;
  },

  handleSkipAdButtonClick: function() {
    this.props.controller.onSkipAdClicked();
  },

  handleLearnMoreButtonClick: function() {
    this.props.controller.onAdsClicked(CONSTANTS.AD_CLICK_SOURCE.LEARN_MORE_BUTTON);
  },

  handleAdTopBarClick: function(event){
    if (event.type == 'touchend' || !this.isMobile) {
      //since mobile would fire both click and touched events,
      //we need to make sure only one actually does the work
      event.stopPropagation(); // W3C
      event.cancelBubble = true; // IE
    }
  },

  isValidAdPlaybackInfo: function(playbackInfo) {
    return (playbackInfo !== null &&
      typeof playbackInfo !== 'undefined' &&
      playbackInfo !== "");
  },

  populateAdTopBar: function() {
    var adTopBarItems = [];

    // // Ad title
    var adTitle = this.props.currentAdsInfo.currentAdItem.name;
    // AMC puts "Unknown" in the name field if ad name unavailable
    if (this.isValidAdPlaybackInfo(adTitle) && this.props.componentWidth > 560) {
      var adTitleDiv = <AdPanelTopBarItem key="adTitle" ref="adTitle" itemClassName="oo-ad-title">{adTitle}</AdPanelTopBarItem>;
      adTopBarItems.push(adTitleDiv);
    }

    // Ad playback Info
    var adPlaybackInfo = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.AD, this.props.localizableStrings);
    var currentAdIndex = this.props.currentAdsInfo.currentAdItem.indexInPod;
    var totalNumberOfAds = this.props.currentAdsInfo.numberOfAds;
    if (this.isValidAdPlaybackInfo(currentAdIndex) && this.isValidAdPlaybackInfo(totalNumberOfAds)) {
      adPlaybackInfo = adPlaybackInfo + ": (" + currentAdIndex + "/" + totalNumberOfAds + ")";
    }

    var isLive = this.props.currentAdsInfo.currentAdItem.isLive;

    if (this.props.skinConfig.adScreen.showAdCountDown) {
      var remainingTime;
      if (isLive) {
        remainingTime = parseInt((this.props.adStartTime + this.props.adVideoDuration * 1000 - new Date().getTime())/1000);
      } else {
        remainingTime = parseInt(this.props.adVideoDuration - this.props.currentPlayhead)
      }

      if (isFinite(remainingTime)) {
        remainingTime = Utils.formatSeconds(Math.max(0, remainingTime));
        adPlaybackInfo = adPlaybackInfo + " - " + remainingTime;
      }
      else {
        OO.log("ad remaining time is not a finite number");
      }
    }

    var adPlaybackInfoDiv = <AdPanelTopBarItem key="adPlaybackInfo" itemClassName="oo-ad-playback-info">{adPlaybackInfo}</AdPanelTopBarItem>;
    adTopBarItems.push(adPlaybackInfoDiv);

    // Flexible space
    var flexibleSpaceDiv = <AdPanelTopBarItem key="flexibleSpace" itemClassName="oo-flexible-space"/>;
    adTopBarItems.push(flexibleSpaceDiv);

    // Learn more
    var learnMoreClass = ClassNames({
      "oo-learn-more": true,
      "oo-hidden": !this.props.currentAdsInfo.currentAdItem.hasClickUrl
    });
    if (this.props.currentAdsInfo.currentAdItem !== null && this.isValidAdPlaybackInfo(this.props.currentAdsInfo.currentAdItem.hasClickUrl)) {
      var learnMoreText = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.LEARN_MORE, this.props.localizableStrings);
      var learnMoreButtonDiv = <AdPanelTopBarItem key="learnMoreButton" ref="learnMoreButton"
                                onButtonClicked={this.handleLearnMoreButtonClick} itemClassName={learnMoreClass}>
                                  <Icon {...this.props} icon="learn" className="oo-button-icon"/>
                                  {learnMoreText}
                              </AdPanelTopBarItem>;
      adTopBarItems.push(learnMoreButtonDiv);
    }

    // Skip
    var skipButtonClass = ClassNames({
      "oo-skip-button": true,
      "oo-visible": this.props.currentAdsInfo.skipAdButtonEnabled,
      "oo-enabled": this.props.currentAdsInfo.skipAdButtonEnabled
    });
    var skipButtonText = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.SKIP_AD, this.props.localizableStrings);
    var skipButtonDiv = <AdPanelTopBarItem key="skipButton" ref="skipButton"
                          onButtonClicked={this.handleSkipAdButtonClick} itemClassName={skipButtonClass}>
                          <Icon {...this.props} icon="skip" className="oo-button-icon"/>
                            {skipButtonText}
                        </AdPanelTopBarItem>;
    adTopBarItems.push(skipButtonDiv);

    return adTopBarItems;
  },


  render: function() {
    var spinner = null;
    if (this.props.controller.state.buffering === true) {
      spinner = <Spinner loadingImage={this.props.skinConfig.general.loadingImage.imageResource.url}/>;
    }
    var adTopBarItems = this.populateAdTopBar();
    return (
      <div className="oo-ad-screen-panel">
        {spinner}
        <div className="oo-ad-screen-panel-click-layer"></div>
        <div className="oo-ad-top-bar" ref="adTopBar" onClick={this.handleAdTopBarClick} onTouchEnd={this.handleAdTopBarClick}>
          {adTopBarItems}
        </div>
      </div>
    );
  }
});

AdPanel.defaultProps = {
  currentPlayhead: 0,
  adVideoDuration: 0,
  adStartTime: 0,
  currentAdsInfo: {
    numberOfAds: 0,
    skipAdButtonEnabled: false,
    currentAdItem: {
      hasClickUrl: false,
      name: "",
      indexInPod: 0,
      isLive: false
    }
  }
};

module.exports = AdPanel;

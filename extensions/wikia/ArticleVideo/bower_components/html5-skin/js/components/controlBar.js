/********************************************************************
  CONTROL BAR
*********************************************************************/
var React = require('react'),
    ReactDOM = require('react-dom'),
    CONSTANTS = require('../constants/constants'),
    ClassNames = require('classnames'),
    ScrubberBar = require('./scrubberBar'),
    Slider = require('./slider'),
    Utils = require('./utils'),
    Popover = require('../views/popover'),
    VideoQualityPanel = require('./videoQualityPanel'),
    ClosedCaptionPopover = require('./closed-caption/closedCaptionPopover'),
    Logo = require('./logo');
    Icon = require('./icon');

var ControlBar = React.createClass({
  getInitialState: function() {
    this.isMobile = this.props.controller.state.isMobile;
    this.responsiveUIMultiple = this.getResponsiveUIMultiple(this.props.responsiveView);
    this.volumeSliderValue = 0;
    this.moreOptionsItems = null;

    return {
      currentVolumeHead: 0
    };
  },

  componentDidMount: function() {
    window.addEventListener('orientationchange', this.closePopovers);
  },

  componentWillReceiveProps: function(nextProps) {
    // if responsive breakpoint changes
    if (nextProps.responsiveView != this.props.responsiveView) {
      this.responsiveUIMultiple = this.getResponsiveUIMultiple(nextProps.responsiveView);
    }
  },

  componentWillUnmount: function () {
    this.props.controller.cancelTimer();
    this.closePopovers();
    if (Utils.isAndroid()){
      this.props.controller.hideVolumeSliderBar();
    }
    window.removeEventListener('orientationchange', this.closePopovers);
  },

  getResponsiveUIMultiple: function(responsiveView){
    var multiplier = this.props.skinConfig.responsive.breakpoints[responsiveView].multiplier;
    return multiplier;
  },

  handleControlBarMouseUp: function(evt) {
    if (evt.type == 'touchend' || !this.isMobile){
      evt.stopPropagation(); // W3C
      evt.cancelBubble = true; // IE
      this.props.controller.state.accessibilityControlsEnabled = true;
      this.props.controller.startHideControlBarTimer();
    }
  },

  handleFullscreenClick: function(evt) {
    // On mobile, we get a following click event that fires after the Video
    // has gone full screen, clicking on a different UI element. So we prevent
    // the following click.
    evt.stopPropagation();
    evt.cancelBubble = true;
    evt.preventDefault();
    this.props.controller.toggleFullscreen();
  },

  handleLiveClick: function(evt) {
    evt.stopPropagation();
    evt.cancelBubble = true;
    evt.preventDefault();
    this.props.controller.onLiveClick();
    this.props.controller.seek(this.props.duration);
  },

  handleVolumeIconClick: function(evt) {
    if (this.isMobile){
      this.props.controller.startHideControlBarTimer();
      evt.stopPropagation(); // W3C
      evt.cancelBubble = true; // IE
      var canShowVolumeSliderBar = !this.props.skinConfig.controlBar
        || !this.props.skinConfig.controlBar.volumeControl
        || this.props.skinConfig.controlBar.volumeControl.sliderVisible !== false;
      if (canShowVolumeSliderBar && !this.props.controller.state.volumeState.volumeSliderVisible){
        this.props.controller.showVolumeSliderBar();
      }
      else {
        this.props.controller.handleMuteClick();
      }
    }
    else{
      this.props.controller.handleMuteClick();
    }
  },

  handlePlayClick: function() {
    this.props.controller.togglePlayPause();
  },

  handleShareClick: function() {
    this.props.controller.toggleShareScreen();
  },

  handleQualityClick: function() {
    if(this.props.responsiveView == this.props.skinConfig.responsive.breakpoints.xs.id) {
      this.props.controller.toggleScreen(CONSTANTS.SCREEN.VIDEO_QUALITY_SCREEN);
    } else {
      this.toggleQualityPopover();
      this.closeCaptionPopover();
    }
  },

  toggleQualityPopover: function() {
    this.props.controller.toggleVideoQualityPopOver();
  },

  closeQualityPopover: function() {
    if(this.props.controller.state.videoQualityOptions.showVideoQualityPopover == true) {
      this.toggleQualityPopover();
    }
  },

  toggleCaptionPopover: function() {
    this.props.controller.toggleClosedCaptionPopOver();
  },

  closeCaptionPopover: function() {
    if(this.props.controller.state.closedCaptionOptions.showClosedCaptionPopover == true) {
      this.toggleCaptionPopover();
    }
  },

  closePopovers: function() {
    this.closeCaptionPopover();
    this.closeQualityPopover();
  },

  handleVolumeClick: function(evt) {
    evt.preventDefault();
    var newVolume = parseFloat(evt.target.dataset.volume);
    this.props.controller.setVolume(newVolume);
  },

  handleDiscoveryClick: function() {
    this.props.controller.toggleDiscoveryScreen();
  },

  handleMoreOptionsClick: function() {
    this.props.controller.toggleMoreOptionsScreen(this.moreOptionsItems);
  },

  handleClosedCaptionClick: function() {
    if(this.props.responsiveView == this.props.skinConfig.responsive.breakpoints.xs.id) {
      this.props.controller.toggleScreen(CONSTANTS.SCREEN.CLOSEDCAPTION_SCREEN);
    } else {
      this.toggleCaptionPopover();
      this.closeQualityPopover();
    }
  },

  //TODO(dustin) revisit this, doesn't feel like the "react" way to do this.
  highlight: function(evt) {
    var color = this.props.skinConfig.controlBar.iconStyle.active.color ? this.props.skinConfig.controlBar.iconStyle.active.color : this.props.skinConfig.general.accentColor;
    var opacity = this.props.skinConfig.controlBar.iconStyle.active.opacity;
    Utils.highlight(evt.target, opacity, color);
  },

  removeHighlight: function(evt) {
    var color = this.props.skinConfig.controlBar.iconStyle.inactive.color;
    var opacity = this.props.skinConfig.controlBar.iconStyle.inactive.opacity;
    Utils.removeHighlight(evt.target, opacity, color);
  },

  volumeHighlight:function() {
    this.highlight({target: ReactDOM.findDOMNode(this.refs.volumeIcon)});
  },

  volumeRemoveHighlight:function() {
    this.removeHighlight({target: ReactDOM.findDOMNode(this.refs.volumeIcon)});
  },

  changeVolumeSlider: function(event) {
    var newVolume = parseFloat(event.target.value);
    this.props.controller.setVolume(newVolume);
    this.setState({
      volumeSliderValue: event.target.value
    });
  },

  populateControlBar: function() {
    var dynamicStyles = this.setupItemStyle();
    var playIcon = "";
    if (this.props.playerState == CONSTANTS.STATE.PLAYING) {
      playIcon = "pause";
    } else if (this.props.playerState == CONSTANTS.STATE.END) {
      playIcon = "replay";
    } else {
      playIcon = "play";
    }

    var volumeIcon = (this.props.controller.state.volumeState.muted ? "volumeOff" : "volume");

    var fullscreenIcon = "";
    if (this.props.controller.state.fullscreen) {
      fullscreenIcon = "compress"
    }
    else {
      fullscreenIcon = "expand";
    }

    var totalTime = 0;
    if (this.props.duration == null || typeof this.props.duration == 'undefined' || this.props.duration == ""){
      totalTime = Utils.formatSeconds(0);
    }
    else {
      totalTime = Utils.formatSeconds(this.props.duration);
    }

    var volumeBars = [];
    for (var i=0; i<10; i++) {
      //create each volume tick separately
      var turnedOn = this.props.controller.state.volumeState.volume >= (i+1) / 10;
      var volumeClass = ClassNames({
        "oo-volume-bar": true,
        "oo-on": turnedOn
      });
      var barStyle = turnedOn ? {backgroundColor: this.props.skinConfig.controlBar.volumeControl.color ? this.props.skinConfig.controlBar.volumeControl.color : this.props.skinConfig.general.accentColor} : null;

      volumeBars.push(<a data-volume={(i+1)/10} className={volumeClass} key={i}
        style={barStyle}
        onClick={this.handleVolumeClick}></a>);
    }

    var volumeSlider = <div className="oo-volume-slider"><Slider value={parseFloat(this.props.controller.state.volumeState.volume)}
                        onChange={this.changeVolumeSlider}
                        className={"oo-slider oo-slider-volume"}
                        itemRef={"volumeSlider"}
                        minValue={"0"}
                        maxValue={"1"}
                        step={"0.1"}/></div>;

    var volumeControls;
    if (!this.isMobile){
      volumeControls = volumeBars;
    }
    else {
      volumeControls = this.props.controller.state.volumeState.volumeSliderVisible ? volumeSlider : null;
    }

    var playheadTime = isFinite(parseInt(this.props.currentPlayhead)) ? Utils.formatSeconds(parseInt(this.props.currentPlayhead)) : null;
    var isLiveStream = this.props.isLiveStream;
    var durationSetting = {color: this.props.skinConfig.controlBar.iconStyle.inactive.color};
    var timeShift = this.props.currentPlayhead - this.props.duration;
    // checking timeShift < 1 seconds (not == 0) as processing of the click after we rewinded and then went live may take some time
    var isLiveNow = Math.abs(timeShift) < 1;
    var liveClick = isLiveNow ? null : this.handleLiveClick;
    var playheadTimeContent = isLiveStream ? (isLiveNow ? null : Utils.formatSeconds(timeShift)) : playheadTime;
    var totalTimeContent = isLiveStream ? null : <span className="oo-total-time">{totalTime}</span>;

    // TODO: Update when implementing localization
    var liveText = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.LIVE, this.props.localizableStrings);

    var liveClass = ClassNames({
      "oo-control-bar-item oo-live oo-live-indicator": true,
      "oo-live-nonclickable": isLiveNow
    });

    var videoQualityPopover = this.props.controller.state.videoQualityOptions.showVideoQualityPopover ? <Popover><VideoQualityPanel{...this.props} togglePopoverAction={this.toggleQualityPopover} popover={true}/></Popover> : null;
    var closedCaptionPopover = this.props.controller.state.closedCaptionOptions.showClosedCaptionPopover ? <Popover popoverClassName="oo-popover oo-popover-pull-right"><ClosedCaptionPopover {...this.props} togglePopoverAction={this.toggleCaptionPopover}/></Popover> : null;

    var qualityClass = ClassNames({
      "oo-quality": true,
      "oo-control-bar-item": true,
      "oo-selected": this.props.controller.state.videoQualityOptions.showVideoQualityPopover
    });

    var captionClass = ClassNames({
      "oo-closed-caption": true,
      "oo-control-bar-item": true,
      "oo-selected": this.props.controller.state.closedCaptionOptions.showClosedCaptionPopover
    });

    var selectedStyle = {};
    selectedStyle["color"] = this.props.skinConfig.general.accentColor ? this.props.skinConfig.general.accentColor : null;

    var controlItemTemplates = {
      "playPause": <a className="oo-play-pause oo-control-bar-item" onClick={this.handlePlayClick} key="playPause">
        <Icon {...this.props} icon={playIcon}
          style={dynamicStyles.iconCharacter}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "live": <a className={liveClass}
        ref="LiveButton"
        onClick={liveClick} key="live">
        <div className="oo-live-circle"></div>
        <span className="oo-live-text">{liveText}</span>
      </a>,

      "volume": <div className="oo-volume oo-control-bar-item" key="volume">
        <Icon {...this.props} icon={volumeIcon} ref="volumeIcon"
          style={this.props.skinConfig.controlBar.iconStyle.inactive}
          onClick={this.handleVolumeIconClick}
          onMouseOver={this.volumeHighlight} onMouseOut={this.volumeRemoveHighlight}/>
        {volumeControls}
      </div>,

      "timeDuration": <a className="oo-time-duration oo-control-bar-duration" style={durationSetting} key="timeDuration">
        <span>{playheadTimeContent}</span>{totalTimeContent}
      </a>,

      "flexibleSpace": <div className="oo-flexible-space oo-control-bar-flex-space" key="flexibleSpace"></div>,

      "moreOptions": <a className="oo-more-options oo-control-bar-item"
        onClick={this.handleMoreOptionsClick} key="moreOptions">
        <Icon {...this.props} icon="ellipsis" style={dynamicStyles.iconCharacter}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "quality": (
        <div className="oo-popover-button-container" key="quality">
          {videoQualityPopover}
          <a className={qualityClass} onClick={this.handleQualityClick} style={selectedStyle}>
            <Icon {...this.props} icon="quality" style={dynamicStyles.iconCharacter}
              onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
          </a>
        </div>
      ),

      "discovery": <a className="oo-discovery oo-control-bar-item"
        onClick={this.handleDiscoveryClick} key="discovery">
        <Icon {...this.props} icon="discovery" style={dynamicStyles.iconCharacter}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "closedCaption": (
        <div className="oo-popover-button-container" key="closedCaption">
          {closedCaptionPopover}
          <a className={captionClass} onClick={this.handleClosedCaptionClick} style={selectedStyle}>
            <Icon {...this.props} icon="cc" style={dynamicStyles.iconCharacter}
              onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
          </a>
        </div>
      ),

      "share": <a className="oo-share oo-control-bar-item"
        onClick={this.handleShareClick} key="share">
        <Icon {...this.props} icon="share" style={dynamicStyles.iconCharacter}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "fullscreen": <a className="oo-fullscreen oo-control-bar-item"
        onClick={this.handleFullscreenClick} key="fullscreen">
        <Icon {...this.props} icon={fullscreenIcon} style={dynamicStyles.iconCharacter}
          onMouseOver={this.highlight} onMouseOut={this.removeHighlight}/>
      </a>,

      "logo": <Logo key="logo" imageUrl={this.props.skinConfig.controlBar.logo.imageResource.url}
        clickUrl={this.props.skinConfig.controlBar.logo.clickUrl}
        target={this.props.skinConfig.controlBar.logo.target}
        width={this.props.responsiveView != this.props.skinConfig.responsive.breakpoints.xs.id ? this.props.skinConfig.controlBar.logo.width : null}
        height={this.props.skinConfig.controlBar.logo.height}/>
    };

    var controlBarItems = [];
    var defaultItems = this.props.controller.state.isPlayingAd ? this.props.skinConfig.buttons.desktopAd : this.props.skinConfig.buttons.desktopContent;

    //if mobile and not showing the slider or the icon, extra space can be added to control bar width. If volume bar is shown instead of slider, add some space as well:
    var volumeItem = null;
    var extraSpaceVolume = 0;

    for (var j = 0; j < defaultItems.length; j++) {
      if (defaultItems[j].name == "volume") {
        volumeItem = defaultItems[j];

        var extraSpaceVolumeSlider = (((volumeItem && this.isMobile && !this.props.controller.state.volumeState.volumeSliderVisible) || volumeItem && Utils.isIos()) ? parseInt(volumeItem.minWidth) : 0);
        var extraSpaceVolumeBar = this.isMobile ? 0 : parseInt(volumeItem.minWidth)/2;
        extraSpaceVolume = extraSpaceVolumeSlider + extraSpaceVolumeBar;

        break;
      }
    }


    //if no hours, add extra space to control bar width:
    var hours = parseInt(this.props.duration / 3600, 10);
    var extraSpaceDuration = (hours > 0) ? 0 : 45;

    var controlBarLeftRightPadding = CONSTANTS.UI.DEFAULT_SCRUBBERBAR_LEFT_RIGHT_PADDING * 2;

    for (var k = 0; k < defaultItems.length; k++) {

      // filter out unrecognized button names
      if (typeof controlItemTemplates[defaultItems[k].name] === "undefined") {
        continue;
      }

      //do not show CC button if no CC available
      if (!this.props.controller.state.closedCaptionOptions.availableLanguages && (defaultItems[k].name === "closedCaption")){
        continue;
      }

      //do not show quality button if no bitrates available
      if (!this.props.controller.state.videoQualityOptions.availableBitrates && (defaultItems[k].name === "quality")){
        continue;
      }

      //do not show discovery button if no related videos available
      if (!this.props.controller.state.discoveryData && (defaultItems[k].name === "discovery")){
        continue;
      }

      //do not show logo if no image url available
      if (!this.props.skinConfig.controlBar.logo.imageResource.url && (defaultItems[k].name === "logo")){
        continue;
      }

      if (Utils.isIos() && (defaultItems[k].name === "volume")){
        continue;
      }

      // Not sure what to do when there are multi streams
      if (defaultItems[k].name === "live" &&
        (typeof this.props.isLiveStream === 'undefined' ||
        !(this.props.isLiveStream))) {
        continue;
      }

      controlBarItems.push(defaultItems[k]);
    }

    var collapsedResult = Utils.collapse(this.props.componentWidth + this.responsiveUIMultiple * (extraSpaceDuration + extraSpaceVolume - controlBarLeftRightPadding), controlBarItems, this.responsiveUIMultiple);
    var collapsedControlBarItems = collapsedResult.fit;
    var collapsedMoreOptionsItems = collapsedResult.overflow;
    this.moreOptionsItems = collapsedMoreOptionsItems;

    finalControlBarItems = [];

    for (var k = 0; k < collapsedControlBarItems.length; k++) {
      if (collapsedControlBarItems[k].name === "moreOptions" && collapsedMoreOptionsItems.length === 0) {
        continue;
      }

      finalControlBarItems.push(controlItemTemplates[collapsedControlBarItems[k].name]);
    }

    return finalControlBarItems;
  },

  setupItemStyle: function() {
    var returnStyles = {};

    returnStyles.iconCharacter = {
      color: this.props.skinConfig.controlBar.iconStyle.inactive.color,
      opacity: this.props.skinConfig.controlBar.iconStyle.inactive.opacity

    };
    return returnStyles;
  },


  render: function() {
    var controlBarClass = ClassNames({
      "oo-control-bar": true,
      "oo-control-bar-hidden": !this.props.controlBarVisible
    });

    var controlBarItems = this.populateControlBar();

    var controlBarStyle = {
      height: this.props.skinConfig.controlBar.height
    };

    return (
      <div className={controlBarClass} style={controlBarStyle} onMouseUp={this.handleControlBarMouseUp} onTouchEnd={this.handleControlBarMouseUp}>
        <ScrubberBar {...this.props} />

        <div className="oo-control-bar-items-wrapper">
          {controlBarItems}
        </div>
      </div>
    );
  }
});

ControlBar.defaultProps = {
  isLiveStream: false,
  skinConfig: {
    responsive: {
      breakpoints: {
        xs: {id: 'xs'},
        sm: {id: 'sm'},
        md: {id: 'md'},
        lg: {id: 'lg'}
      }
    }
  },
  responsiveView: 'md'
};

module.exports = ControlBar;
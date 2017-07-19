/********************************************************************
  SCRUBBER BAR
*********************************************************************/
var React = require('react'),
    ReactDOM = require('react-dom'),
    ResizeMixin = require('../mixins/resizeMixin'),
    Thumbnail = require('./thumbnail'),
    ThumbnailCarousel = require('./thumbnailCarousel'),
    CONSTANTS = require('../constants/constants');

var ScrubberBar = React.createClass({
  mixins: [ResizeMixin],

  getInitialState: function() {
    this.lastScrubX = null;
    this.isMobile = this.props.controller.state.isMobile;
    this.touchInitiated = false;

    return {
      scrubberBarWidth: 0,
      playheadWidth: 0,
      scrubbingPlayheadX: 0,
      hoveringX: 0,
      currentPlayhead: 0,
      transitionedDuringSeek: false
    };
  },

  componentWillMount: function() {
    if (this.props.seeking) {
      this.setState({transitionedDuringSeek: true});
    }
  },

  componentDidMount: function() {
    this.handleResize();
  },

  componentWillReceiveProps: function(nextProps) {
    if (this.state.transitionedDuringSeek && !nextProps.seeking) {
      this.setState({transitionedDuringSeek: false});
    }
  },

  componentWillUnmount: function() {
    if (!this.isMobile){
      ReactDOM.findDOMNode(this).parentNode.removeEventListener("mousemove", this.handlePlayheadMouseMove);
      document.removeEventListener("mouseup", this.handlePlayheadMouseUp, true);
    }
    else{
      ReactDOM.findDOMNode(this).parentNode.removeEventListener("touchmove", this.handlePlayheadMouseMove);
      document.removeEventListener("touchend", this.handlePlayheadMouseUp, true);
    }
  },

  getResponsiveUIMultiple: function(responsiveView){
    var multiplier = this.props.skinConfig.responsive.breakpoints[responsiveView].multiplier;
    return multiplier;
  },

  handleResize: function() {
    this.setState({
      scrubberBarWidth: ReactDOM.findDOMNode(this.refs.scrubberBar).clientWidth,
      playheadWidth: ReactDOM.findDOMNode(this.refs.playhead).clientWidth
    });
  },

  handlePlayheadMouseDown: function(evt) {
    if (this.props.controller.state.screenToShow == CONSTANTS.SCREEN.AD_SCREEN) return;
    this.props.controller.startHideControlBarTimer();
    if (evt.target.className.match("playhead") && evt.type !== "mousedown") {
        this.touchInitiated = true;
    }
    if ((this.touchInitiated && evt.type !== "mousedown") || (!this.touchInitiated && evt.type === "mousedown") ){
      //since mobile would fire both click and touched events,
      //we need to make sure only one actually does the work

      evt.preventDefault();
      if (this.touchInitiated){
        evt = evt.touches[0];
      }

      // we enter the scrubbing state to prevent constantly seeking while dragging
      // the playhead icon
      this.props.controller.beginSeeking();
      this.props.controller.renderSkin();

      if (!this.lastScrubX) {
        this.lastScrubX = evt.clientX;
      }

      if (!this.touchInitiated){
        ReactDOM.findDOMNode(this).parentNode.addEventListener("mousemove", this.handlePlayheadMouseMove);
        // attach a mouseup listener to the document for usability, otherwise scrubbing
        // breaks if your cursor leaves the player element
        document.addEventListener("mouseup", this.handlePlayheadMouseUp, true);
      }
      else {
        ReactDOM.findDOMNode(this).parentNode.addEventListener("touchmove", this.handlePlayheadMouseMove);
        document.addEventListener("touchend", this.handlePlayheadMouseUp, true);
      }
    }
  },

  handlePlayheadMouseMove: function(evt) {
    this.props.controller.startHideControlBarTimer();
    evt.preventDefault();
    if (this.props.seeking && this.props.duration > 0) {
      if (this.touchInitiated){
        evt = evt.touches[0];
      }
      var deltaX = evt.clientX - this.lastScrubX;
      var scrubbingPlayheadX = this.props.currentPlayhead * this.state.scrubberBarWidth / this.props.duration + deltaX;
      this.props.controller.updateSeekingPlayhead((scrubbingPlayheadX / this.state.scrubberBarWidth) * this.props.duration);
      this.setState({
        scrubbingPlayheadX: scrubbingPlayheadX
      });
      this.lastScrubX = evt.clientX;
    }
  },

  handlePlayheadMouseUp: function(evt) {
    if (!this.isMounted()) {
      return;
    }
    this.props.controller.startHideControlBarTimer();
    evt.preventDefault();
    // stop propagation to prevent it from bubbling up to the skin and pausing
    evt.stopPropagation(); // W3C
    evt.cancelBubble = true; // IE

    this.lastScrubX = null;
    if (!this.touchInitiated){
      ReactDOM.findDOMNode(this).parentNode.removeEventListener("mousemove", this.handlePlayheadMouseMove);
      document.removeEventListener("mouseup", this.handlePlayheadMouseUp, true);
    }
    else{
      ReactDOM.findDOMNode(this).parentNode.removeEventListener("touchmove", this.handlePlayheadMouseMove);
      document.removeEventListener("touchend", this.handlePlayheadMouseUp, true);
    }
    this.props.controller.seek(this.props.currentPlayhead);
    if (this.isMounted()) {
      this.setState({
        currentPlayhead: this.props.currentPlayhead,
        scrubbingPlayheadX: 0
      });
      this.props.controller.endSeeking();
    }
    this.touchInitiated = false;
  },

  handleScrubberBarMouseDown: function(evt) {
    if (this.props.controller.state.screenToShow == CONSTANTS.SCREEN.AD_SCREEN) return;
    if (evt.target.className.match("oo-playhead")) { return; }
    if (this.touchInitiated && evt.type === "mousedown") { return; }
    var offsetX = 0;
    this.touchInitiated = evt.type === "touchstart";
    if (this.touchInitiated){
      offsetX = evt.targetTouches[0].pageX - evt.target.getBoundingClientRect().left;
    }
    else {
      offsetX = evt.nativeEvent.offsetX == undefined ? evt.nativeEvent.layerX : evt.nativeEvent.offsetX;
    }

    this.setState({
      scrubbingPlayheadX: offsetX
    });
    this.props.controller.updateSeekingPlayhead((offsetX / this.state.scrubberBarWidth) * this.props.duration);
    this.handlePlayheadMouseDown(evt);
  },

  handleScrubberBarMouseOver: function(evt) {
    if (!this.props.skinConfig.controlBar.scrubberBar.thumbnailPreview) return;
    if (this.props.controller.state.screenToShow == CONSTANTS.SCREEN.AD_SCREEN) return;
    if (this.isMobile) { return; }
    if (evt.target.className.match("oo-playhead")) { return; }

    this.setState({
      hoveringX: evt.nativeEvent.offsetX
    });
  },

  handleScrubberBarMouseMove: function(evt) {
    this.handleScrubberBarMouseOver(evt);
  },

  handleScrubberBarMouseOut: function(evt) {
    if (!this.props.controller.state.thumbnails) return;
    this.setState({
      hoveringX: 0
    });
  },

  render: function() {
    var scrubberBarStyle = {
      backgroundColor: this.props.skinConfig.controlBar.scrubberBar.backgroundColor
    };
    var bufferedIndicatorStyle = {
      width: Math.min((parseFloat(this.props.buffered) / parseFloat(this.props.duration)) * 100, 100) + "%",
      backgroundColor: this.props.skinConfig.controlBar.scrubberBar.bufferedColor
    };
    var playedIndicatorStyle = {
      width: Math.min((parseFloat(this.props.currentPlayhead) / parseFloat(this.props.duration)) * 100, 100) + "%",
      backgroundColor: this.props.skinConfig.controlBar.scrubberBar.playedColor ? this.props.skinConfig.controlBar.scrubberBar.playedColor : this.props.skinConfig.general.accentColor
    };
    var playheadStyle = {
      backgroundColor: this.props.skinConfig.controlBar.scrubberBar.playedColor ? this.props.skinConfig.controlBar.scrubberBar.playedColor : this.props.skinConfig.general.accentColor
    };
    var playheadPaddingStyle = {};

    if (!this.state.transitionedDuringSeek) {

      if (this.state.scrubbingPlayheadX && this.state.scrubbingPlayheadX != 0) {
        playheadPaddingStyle.left = this.state.scrubbingPlayheadX;
      } else {
        playheadPaddingStyle.left = ((parseFloat(this.props.currentPlayhead) /
        parseFloat(this.props.duration)) * this.state.scrubberBarWidth);
      }

      playheadPaddingStyle.left = Math.max(
        Math.min(this.state.scrubberBarWidth - parseInt(this.state.playheadWidth)/2,
          playheadPaddingStyle.left), 0);

      if (isNaN(playheadPaddingStyle.left)) playheadPaddingStyle.left = 0;
    }

    var playheadMouseDown = this.handlePlayheadMouseDown;
    var scrubberBarMouseDown = this.handleScrubberBarMouseDown;
    var scrubberBarMouseOver = this.handleScrubberBarMouseOver;
    var scrubberBarMouseOut = this.handleScrubberBarMouseOut;
    var scrubberBarMouseMove = this.handleScrubberBarMouseMove;
    var playedIndicatorClassName = "oo-played-indicator";
    var playheadClassName = "oo-playhead";
    var scrubberBarClassName = "oo-scrubber-bar";

    if (this.props.controller.state.screenToShow == CONSTANTS.SCREEN.AD_SCREEN){
      playheadClassName += " oo-ad-playhead";
      playedIndicatorClassName += " oo-played-ad-indicator";
      playheadMouseDown = null;

      scrubberBarStyle.backgroundColor = this.props.skinConfig.controlBar.adScrubberBar.backgroundColor;
      bufferedIndicatorStyle.backgroundColor = this.props.skinConfig.controlBar.adScrubberBar.bufferedColor;
      playedIndicatorStyle.backgroundColor = this.props.skinConfig.controlBar.adScrubberBar.playedColor;
    }

    var thumbnailContainer = null;
    var thumbnailCarousel = null;
    var hoverTime = 0;
    var hoverPosition = 0;
    var hoveredIndicatorStyle = null;

    if (this.props.controller.state.thumbnails && (this.state.scrubbingPlayheadX || this.lastScrubX || this.state.hoveringX)) {
      if (this.state.scrubbingPlayheadX) {
        hoverPosition = this.state.scrubbingPlayheadX;
        hoverTime = (this.state.scrubbingPlayheadX / this.state.scrubberBarWidth) * this.props.duration;
        playheadClassName += " oo-playhead-scrubbing";

        thumbnailCarousel =
          <ThumbnailCarousel
           thumbnails={this.props.controller.state.thumbnails}
           duration={this.props.duration}
           hoverTime={hoverTime > 0 ? hoverTime : 0}
           scrubberBarWidth={this.state.scrubberBarWidth}/>
      } else if (this.lastScrubX) {//to show thumbnail when clicking on playhead
        hoverPosition = this.props.currentPlayhead * this.state.scrubberBarWidth / this.props.duration;
        hoverTime = this.props.currentPlayhead;
        playheadClassName += " oo-playhead-scrubbing";
      } else if (this.state.hoveringX) {
        hoverPosition = this.state.hoveringX;
        hoverTime = (this.state.hoveringX / this.state.scrubberBarWidth) * this.props.duration;
        hoveredIndicatorStyle = {
          width: Math.min((parseFloat(hoverTime) / parseFloat(this.props.duration)) * 100, 100) + "%",
          backgroundColor: this.props.skinConfig.controlBar.scrubberBar.playedColor ? this.props.skinConfig.controlBar.scrubberBar.playedColor : this.props.skinConfig.general.accentColor
        };
        scrubberBarClassName += " oo-scrubber-bar-hover";
        playheadClassName += " oo-playhead-hovering";
      }
      if (!thumbnailCarousel) {
        thumbnailContainer = (
          <Thumbnail
           thumbnails={this.props.controller.state.thumbnails}
           hoverPosition={hoverPosition}
           duration={this.props.duration}
           hoverTime={hoverTime > 0 ? hoverTime : 0} />
        )
      }
    }

    return (
      <div className="oo-scrubber-bar-container" ref="scrubberBarContainer" onMouseOver={scrubberBarMouseOver} onMouseOut={scrubberBarMouseOut} onMouseMove={scrubberBarMouseMove}>
        {thumbnailContainer}
        {thumbnailCarousel}
        <div className="oo-scrubber-bar-padding" ref="scrubberBarPadding" onMouseDown={scrubberBarMouseDown} onTouchStart={scrubberBarMouseDown}>
          <div ref="scrubberBar" className={scrubberBarClassName} style={scrubberBarStyle}>
            <div className="oo-buffered-indicator" style={bufferedIndicatorStyle}></div>
            <div className="oo-hovered-indicator" style={hoveredIndicatorStyle}></div>
            <div className={playedIndicatorClassName} style={playedIndicatorStyle}></div>
            <div className="oo-playhead-padding" style={playheadPaddingStyle}
              onMouseDown={playheadMouseDown} onTouchStart={playheadMouseDown}>
              <div ref="playhead" className={playheadClassName} style={playheadStyle}></div>
            </div>
          </div>
        </div>
      </div>
    );
  }
});

ScrubberBar.defaultProps = {
  skinConfig: {
    controlBar: {
      scrubberBar: {
        backgroundColor: 'rgba(5,175,175,1)',
        bufferedColor: 'rgba(127,5,127,1)',
        playedColor: 'rgba(67,137,5,1)'
      },
      adScrubberBar: {
        backgroundColor: 'rgba(175,175,5,1)',
        bufferedColor: 'rgba(127,5,127,1)',
        playedColor: 'rgba(5,63,128,1)'
      }
    }
  }
};

module.exports = ScrubberBar;
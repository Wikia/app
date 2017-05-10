/********************************************************************
  COUNT DOWN CLOCK
*********************************************************************/
/**
*
*
* @class CountDownClock
* @constructor
*/
var React = require('react'),
    ReactDOM = require('react-dom'),
    ClassNames = require('classnames'),
    CONSTANTS = require('../constants/constants');

var CountDownClock = React.createClass({
  getInitialState: function() {
    // canvas, interval, and context are changing based on time instead of user interaction
    this.canvas = null;
    this.context = null;
    this.interval = null;
    var tmpFraction = 0;
    var tmpRemainSeconds = 0;
    var upNextTimeToShow = parseInt(this.props.controller.state.upNextInfo.timeToShow);

    if(this.props.controller.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN) {
      tmpFraction = 2 / this.props.timeToShow;
      tmpRemainSeconds = this.props.timeToShow;
    }
    else {
      tmpFraction = 2 / upNextTimeToShow;
      tmpRemainSeconds = this.props.duration - this.props.currentPlayhead;
    }

    return {
      counterInterval: 0.05,
      fraction: tmpFraction, // fraction = 2 / (skinConfig.upNext.timeToShow) so "fraction * pi" is how much we want to fill the circle for each second
      remainSeconds: tmpRemainSeconds,
      hideClock: false
    };
  },

  handleClick: function(event) {
    if (event.type == 'touchend' || !this.isMobile){
      //since mobile would fire both click and touched events,
      //we need to make sure only one actually does the work

      if(this.props.controller.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN) {
        this.setState({hideClock: true});
        clearInterval(this.interval);
      }
    }
  },

  componentWillMount: function() {
    this.updateClockSize();
  },

  componentDidMount: function() {
    this.setupCountDownTimer();
  },

  componentWillUnmount: function() {
    clearInterval(this.interval);
  },

  setupCountDownTimer: function() {
    this.setupCanvas();
    this.drawBackground();
    this.drawTimer();
    this.startTimer();
  },

  setupCanvas: function() {
    this.canvas = ReactDOM.findDOMNode(this);
    this.context = this.canvas.getContext("2d");
    this.context.textAlign = 'center';
    this.context.textBaseline = 'middle';
    this.context.font = "regular 12px Arial";
  },

  drawBackground: function() {
    this.context.beginPath();
    this.context.globalAlpha = 1;
    this.context.fillStyle = 'gray';
    this.context.arc(this.state.clockContainerWidth / 2, this.state.clockRadius, this.state.clockRadius, 0, Math.PI * 2, false);
    this.context.arc(this.state.clockContainerWidth / 2, this.state.clockRadius, this.state.clockRadius / 1.2, Math.PI * 2, 0, true);
    this.context.fill();
  },

  updateClockSize: function(){
    if (this.props.controller.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN){
      var clockWidth = 75;
    }
    else {
      var clockWidth = this.props.responsiveView == this.props.skinConfig.responsive.breakpoints.xs.id ? 25 : 36;
    }
    this.setState({
      clockRadius: parseInt(clockWidth, 10)/2,
      clockContainerWidth: parseInt(clockWidth, 10)
    });
  },

  drawTimer: function() {
    var decimals;
    var percent = this.state.fraction * this.state.remainSeconds + 1.5;
    this.context.fillStyle = 'white';
    if(this.props.controller.state.screenToShow === CONSTANTS.SCREEN.PLAYING_SCREEN || this.props.controller.state.screenToShow === CONSTANTS.SCREEN.PAUSE_SCREEN) {
      this.context.fillText(this.state.remainSeconds.toFixed(decimals), this.state.clockContainerWidth / 2, this.state.clockRadius, 100);
    }
    this.context.beginPath();
    this.context.arc(this.state.clockContainerWidth / 2, this.state.clockRadius, this.state.clockRadius, Math.PI * 1.5, Math.PI * percent, false);
    this.context.arc(this.state.clockContainerWidth / 2, this.state.clockRadius, this.state.clockRadius / 1.2, Math.PI * percent, Math.PI * 1.5, true);
    this.context.fill();
  },

  startTimer: function() {
    this.interval = setInterval(this.tick, this.state.counterInterval * 1000);
  },

  tick: function() {
    if(this.props.controller.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN) {
      if(this.state.remainSeconds < 1) {
        this.setState({remainSeconds: 0});
        clearInterval(this.interval);
        this.startDiscoveryVideo();
      }
      else {
        this.setState({remainSeconds: this.state.remainSeconds-(this.state.counterInterval)});
        this.updateCanvas();
      }
    }
    else if(this.props.controller.state.screenToShow === CONSTANTS.SCREEN.PLAYING_SCREEN || this.props.controller.state.screenToShow === CONSTANTS.SCREEN.PAUSE_SCREEN) {
      if (this.state.remainSeconds < 1 || this.props.playerState === CONSTANTS.STATE.END) {
        this.setState({remainSeconds: 0});
        clearInterval(this.interval);
        this.startUpNextVideo();
      }
      else {
        this.setState({remainSeconds: this.props.duration - this.props.currentPlayhead});
        this.updateCanvas();
      }
    }
  },

  updateCanvas: function() {
    this.clearCanvas();
    this.drawTimer();
  },

  clearCanvas: function() {
    this.context = this.canvas.getContext("2d");
    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    this.drawBackground();
  },

  startDiscoveryVideo: function() {
    var eventData = {
          "clickedVideo" : this.props.discoveryData.relatedVideos[0],
          "custom" : this.props.discoveryData.custom
        };
    this.props.controller.sendDiscoveryClickEvent(eventData, false);
  },

  startUpNextVideo: function() {
    OO.log("startUpNext");
    var eventData = {
      "clickedVideo" : this.props.upNextInfo.upNextData,
      "custom" : {"source": CONSTANTS.SCREEN.UP_NEXT_SCREEN}
    };
    this.props.controller.sendDiscoveryClickEvent(eventData, true);
  },

  render: function() {
    var canvasClassName = ClassNames({
      'oo-countdown-clock': true,
      'oo-up-next-count-down': this.props.controller.state.screenToShow !== CONSTANTS.SCREEN.DISCOVERY_SCREEN,
      'oo-discovery-count-down': this.props.controller.state.screenToShow === CONSTANTS.SCREEN.DISCOVERY_SCREEN,
      'oo-hidden': this.state.hideClock
    });

    return (
      <canvas className={canvasClassName}
              width={this.state.clockContainerWidth}
              height={this.state.clockContainerWidth}
              onClick={this.handleClick}
              onTouchEnd={this.handleClick}>
      </canvas>
    );
  }
});

CountDownClock.propTypes = {
  timeToShow: React.PropTypes.string,
  clockWidth: React.PropTypes.number,
  currentPlayhead: React.PropTypes.number
};

CountDownClock.defaultProps = {
  timeToShow: "10", //seconds
  clockWidth: 36,
  currentPlayhead: 0,
  controller: {
    state: {
      screenToShow: '',
      upNextInfo: {
        timeToShow: "10"
      }
    }
  },
  skinConfig: {
    responsive: {
      breakpoints: {
        xs: {
          id: 'xs'
        }
      }
    }
  },
};

module.exports = CountDownClock;
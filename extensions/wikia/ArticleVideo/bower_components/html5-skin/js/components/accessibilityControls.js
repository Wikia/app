var CONSTANTS = require('./../constants/constants');

var AccessibilityControls = function (controller) {
    this.controller = controller;
    this.state = {
      "fastForwardRate": 1,
      "lastKeyDownTime": null
    };
    document.addEventListener("keydown", this.handleKey.bind(this));
};

AccessibilityControls.prototype = {
  handleKey: function(e) {
    if (!this.controller.state.accessibilityControlsEnabled){
      return;
    }

    var currentTime;
    var newPlayheadTime;
    var newVolume;

    if (e.keyCode === CONSTANTS.KEYCODES.SPACE_KEY){
      e.preventDefault();
      this.controller.togglePlayPause();
    }

    else if ((e.keyCode === CONSTANTS.KEYCODES.DOWN_ARROW_KEY && this.controller.state.volumeState.volume > 0) || (e.keyCode === CONSTANTS.KEYCODES.UP_ARROW_KEY && this.controller.state.volumeState.volume < 1)){
      e.preventDefault();
      var deltaVolumeSign = 1; // positive 1 for volume increase, negative for decrease

      if (e.keyCode === CONSTANTS.KEYCODES.DOWN_ARROW_KEY){
        deltaVolumeSign = -1;
      }
      else {
        deltaVolumeSign = 1;
      }

      newVolume = (this.controller.state.volumeState.volume * 10 + 1*deltaVolumeSign)/10;
      this.controller.setVolume(newVolume);
    }

    else if (e.keyCode === CONSTANTS.KEYCODES.RIGHT_ARROW_KEY || e.keyCode === CONSTANTS.KEYCODES.LEFT_ARROW_KEY){
      e.preventDefault();
      var shiftSign = 1; // positive 1 for fast forward, negative for rewind back

      var shiftSeconds = 1;
      var fastForwardRateIncrease = 1.1;

      currentTime = Date.now();
      if (this.state.lastKeyDownTime && currentTime - this.state.lastKeyDownTime < 500){
        //increasing the fast forward rate to go faster if key is pressed often
        if (this.state.fastForwardRate < 300){
          this.state.fastForwardRate *= fastForwardRateIncrease;
        }
      }
      else {
        this.state.fastForwardRate = 1;
      }

      this.state.lastKeyDownTime = currentTime;
      if (e.keyCode === CONSTANTS.KEYCODES.RIGHT_ARROW_KEY){
        shiftSign = 1;
      }
      else {
        shiftSign = -1;
      }

      newPlayheadTime = this.controller.skin.state.currentPlayhead + shiftSign*shiftSeconds * this.state.fastForwardRate;
      this.controller.seek(newPlayheadTime);
    }
  }
};

module.exports = AccessibilityControls;
/**
 * Panel component for video quality selection
 *
 * @module VideoQualityPanel
 */
var React = require('react'),
    ScrollArea = require('react-scrollbar/dist/no-css'),
	  CONSTANTS = require('../constants/constants'),
	  Utils = require('./utils'),
    ClassNames = require('classnames');

var VideoQualityPanel = React.createClass({
  getInitialState: function() {
    return {
      selected: this.props.videoQualityOptions.selectedBitrate ? this.props.videoQualityOptions.selectedBitrate.id : 'auto'
    };
  },

  handleVideoQualityClick: function(selectedBitrateId, event) {
    event.preventDefault();
    var eventData = {
      "id": selectedBitrateId
    };
    this.props.controller.sendVideoQualityChangeEvent(eventData);
    this.setState({
      selected: selectedBitrateId
    });
    this.props.togglePopoverAction();
    this.props.toggleVideoQualityPanel();
  },

    handleBackClick: function() {
        this.props.toggleVideoQualityPopOver();
    },

  render: function() {
    var availableBitrates  = this.props.videoQualityOptions.availableBitrates;
    var bitrateButtons = [];
    var label;

    //available bitrates
    for (var i = 0; i < availableBitrates.length; i++) {
      var qualityBtn = ClassNames({
        'oo-quality-btn': true,
        'oo-selected': this.state.selected == availableBitrates[i].id
      });
      var selectedBitrateStyle = {color: (this.props.skinConfig.general.accentColor && this.state.selected == availableBitrates[i].id) ? this.props.skinConfig.general.accentColor : null};

      if (availableBitrates[i].id === 'auto') {
        label = 'Auto';
      } else if (typeof availableBitrates[i].height === "number") {
				label = Math.round(availableBitrates[i].height) + 'p';
			}
			else {
				label = availableBitrates[i].bitrate;
			}
			bitrateButtons.push(<li key={i}><a className={qualityBtn} style={selectedBitrateStyle} key={i} onClick={this.handleVideoQualityClick.bind(this, availableBitrates[i].id)}>{label}</a></li>);
    }

    var qualityScreenClass = ClassNames({
      'oo-content-panel': !this.props.popover,
      'oo-quality-panel': !this.props.popover,
      'oo-quality-popover': this.props.popover,
      'oo-mobile-fullscreen': !this.props.popover && this.props.controller.state.isMobile && (this.props.controller.state.fullscreen || this.props.controller.state.isFullWindow)
    });

    var back;
    var backText = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.BACK, this.props.localizableStrings);
    if(this.props.skinConfig.controlBar.autoplayToggle) {
      back = <a className="back" onClick={this.handleBackClick}>
        <svg className="oo-chevron" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
          <path d="M9 14a.997.997 0 0 1-.707-.293l-7-7a.999.999 0 1 1 1.414-1.414L9 11.586l6.293-6.293a.999.999 0 1 1 1.414 1.414l-7 7A.997.997 0 0 1 9 14" fill-rule="evenodd"/></svg>
        {backText}
      </a>;
    }

    return (
      <div className={qualityScreenClass}>
        <ScrollArea
          className="oo-quality-screen-content"
          speed={this.props.popover ? 0.6 : 1}
          horizontal={!this.props.popover}>
          <ul>
            {bitrateButtons}
          </ul>
          {back}
        </ScrollArea>
      </div>
    );
  }
});

VideoQualityPanel.propTypes = {
  videoQualityOptions: React.PropTypes.shape({
    availableBitrates: React.PropTypes.arrayOf(React.PropTypes.shape({
      id: React.PropTypes.string,
      bitrate: React.PropTypes.oneOfType([
      React.PropTypes.string,
      React.PropTypes.number,
      ]),
      label: React.PropTypes.string
    }))
  }),
  togglePopoverAction: React.PropTypes.func,
  controller: React.PropTypes.shape({
    sendVideoQualityChangeEvent: React.PropTypes.func
  })
};

VideoQualityPanel.defaultProps = {
  popover: false,
  skinConfig: {
    icons: {
      quality:{fontStyleClass:'oo-icon oo-icon-topmenu-quality'}
    }
  },
  videoQualityOptions: {
    availableBitrates: []
  },
  togglePopoverAction: function(){},
  controller: {
    sendVideoQualityChangeEvent: function(a){}
  }
};

module.exports = VideoQualityPanel;
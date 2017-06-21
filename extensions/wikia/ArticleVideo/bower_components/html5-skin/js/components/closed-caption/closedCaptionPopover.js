var React = require('react'),
    CONSTANTS = require('../../constants/constants'),
    Utils = require('../utils'),
    OnOffSwitch = require('./onOffSwitch'),
    CloseButton = require('../closeButton');

var ClosedCaptionPopover = React.createClass({

  handleMoreCaptions: function() {
    this.props.controller.toggleScreen(CONSTANTS.SCREEN.CLOSEDCAPTION_SCREEN);
    this.handleClose();
  },

  handleClose: function() {
    this.props.togglePopoverAction();
  },

  render: function() {
    var captionBtnText = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.CC_OPTIONS, this.props.localizableStrings);

    return (
      <ul className="oo-popover-horizontal">
        <li>
          <OnOffSwitch {...this.props} />
        </li>
        <li>
          <a className="oo-more-captions" onClick={this.handleMoreCaptions}>{captionBtnText}</a>
        </li>
        <li>
          <CloseButton {...this.props} closeAction={this.handleClose} />
        </li>
      </ul>
    );
  }
});

module.exports = ClosedCaptionPopover;
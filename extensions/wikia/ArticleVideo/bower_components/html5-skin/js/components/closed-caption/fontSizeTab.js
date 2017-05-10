var React = require('react'),
    ClassNames = require('classnames'),
    Utils = require('../utils'),
    CONSTANTS = require('../../constants/constants'),
    SelectionContainer = require('./selectionContainer');

var FontSizeTab = React.createClass({
  getInitialState: function() {
    return {
      selectedFontSize: this.props.closedCaptionOptions.fontSize,
      fontSizes: ["Small", "Medium", "Large", "Extra Large"]
    };
  },

  changeFontSize: function(fontSize) {
    if (!this.props.closedCaptionOptions.enabled) {
      this.props.controller.toggleClosedCaptionEnabled();
    }
    this.props.controller.onClosedCaptionChange('fontSize', fontSize);
    this.setState({
      selectedFontSize: fontSize
    });
  },

  setClassname: function(item, elementType) {
    return ClassNames({
      'oo-font-size-letter': elementType == "letter",
      'oo-font-size-label': elementType == "label",
      'oo-font-size-selected': this.props.closedCaptionOptions.fontSize == item && this.props.closedCaptionOptions.enabled,
      'oo-font-size-label-selected': this.props.closedCaptionOptions.fontSize == item && this.props.closedCaptionOptions.enabled && elementType == "label",
      'oo-disabled': !this.props.closedCaptionOptions.enabled
    });
  },

  render: function() {
    var fontSizeTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.FONT_SIZE, this.props.localizableStrings);
    var fontSizeSelection = Utils.getLocalizedString(
      this.props.language,
      CONSTANTS.SKIN_TEXT[this.props.closedCaptionOptions.fontSize.toUpperCase().replace(" ", "_")],
      this.props.localizableStrings
    );
    var fontItems = [];
    for(var i = 0; i < this.state.fontSizes.length; i++) {
      //accent color
      var selectedFontSizeStyle = {};
      if (this.props.closedCaptionOptions.enabled && this.props.skinConfig.general.accentColor && this.props.closedCaptionOptions.fontSize == this.state.fontSizes[i]) {
        selectedFontSizeStyle = {color: this.props.skinConfig.general.accentColor};
      }

      fontItems.push(
      <a className="oo-font-size-container" onClick={this.changeFontSize.bind(this, this.state.fontSizes[i])} key={i}>
        <div className={this.setClassname(this.state.fontSizes[i], "letter") + " oo-font-size-letter-" + this.state.fontSizes[i].replace(" ", "-")} style={selectedFontSizeStyle}>A</div>
        <div className={this.setClassname(this.state.fontSizes[i], "label")} style={selectedFontSizeStyle} >{
          Utils.getLocalizedString(
            this.props.language,
            CONSTANTS.SKIN_TEXT[this.state.fontSizes[i].toUpperCase().replace(" ", "_")],
            this.props.localizableStrings
          )
        }</div>
      </a>
      );
    }

    return (
      <div className="oo-font-size-tab">
        <div className="oo-font-size-inner-wrapper">
          <SelectionContainer
            title={fontSizeTitle}
            selectionText={fontSizeSelection}
            >
            {fontItems}
          </SelectionContainer>
        </div>
      </div>
    );
  }
});

module.exports = FontSizeTab;
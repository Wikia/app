var React = require('react'),
    ClassNames = require('classnames'),
    Utils = require('../utils'),
    CONSTANTS = require('../../constants/constants'),
    SelectionContainer = require('./selectionContainer');

var TextEnhancementsTab = React.createClass({
  getInitialState: function() {
    return {
      selectedTextEnhancement: this.props.closedCaptionOptions.textEnhancement,
      textEnhancements: ["Uniform", "Depressed", "Raised", "Shadow"]
    };
  },

  changeTextEnhancement: function(textEnhancement) {
    if (!this.props.closedCaptionOptions.enabled) {
      this.props.controller.toggleClosedCaptionEnabled();
    }
    this.props.controller.onClosedCaptionChange('textEnhancement', textEnhancement);
    this.setState({
      selectedTextEnhancement: textEnhancement
    });
  },

  setClassname: function(item, elementType) {
    return ClassNames({
      'oo-text-enhancement-letter': elementType == "letter",
      'oo-text-enhancement-label': elementType == "label",
      'oo-text-enhancement-selected': this.props.closedCaptionOptions.textEnhancement == item && this.props.closedCaptionOptions.enabled,
      'oo-text-enhancement-label-selected': this.props.closedCaptionOptions.textEnhancement == item && this.props.closedCaptionOptions.enabled && elementType == "label",
      'oo-disabled': !this.props.closedCaptionOptions.enabled
    });
  },

  render: function() {
    var textEnhancementTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.TEXT_ENHANCEMENT, this.props.localizableStrings);
    var textEnhancementSelection = Utils.getLocalizedString(
      this.props.language,
      CONSTANTS.SKIN_TEXT[this.props.closedCaptionOptions.textEnhancement.toUpperCase()],
      this.props.localizableStrings
    );
    var textEnhancementItems = [];
    for(var i = 0; i < this.state.textEnhancements.length; i++) {
      //accent color
      var selectedTextEnhancementStyle = {};
      if (this.props.closedCaptionOptions.enabled && this.props.skinConfig.general.accentColor &&  this.props.closedCaptionOptions.textEnhancement == this.state.textEnhancements[i]) {
        selectedTextEnhancementStyle = {color: this.props.skinConfig.general.accentColor};
      }

      textEnhancementItems.push(
       <a className="oo-text-enhancements-container" onClick={this.changeTextEnhancement.bind(this, this.state.textEnhancements[i])} key={i}>
        <div className={this.setClassname(this.state.textEnhancements[i], "letter") + " oo-text-enhancement-letter-" + this.state.textEnhancements[i]} style={selectedTextEnhancementStyle}>A</div>
          <div className={this.setClassname(this.state.textEnhancements[i], "label")} style={selectedTextEnhancementStyle}>{
            Utils.getLocalizedString(
            this.props.language,
            CONSTANTS.SKIN_TEXT[this.state.textEnhancements[i].toUpperCase()],
            this.props.localizableStrings
          )
        }</div>
      </a>
      );
    }

    return (
      <div className="oo-text-enhancements-tab">
        <div className="oo-text-enhancements-inner-wrapper">
          <SelectionContainer
            title={textEnhancementTitle}
            selectionText={textEnhancementSelection}
            >
            {textEnhancementItems}
          </SelectionContainer>
        </div>
      </div>
    );
  }
});

module.exports = TextEnhancementsTab;
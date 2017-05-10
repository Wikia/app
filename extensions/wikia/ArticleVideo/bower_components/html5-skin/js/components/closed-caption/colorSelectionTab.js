var React = require('react'),
    Utils = require('../utils'),
    CONSTANTS = require('../../constants/constants'),
    SelectionContainer = require('./selectionContainer'),
    ColorSelector = require('../colorSelector');

var ColorSelectionTab = React.createClass({

  getInitialState: function() {
    return {
      selectedTextColor: this.props.closedCaptionOptions.textColor,
      selectedWindowColor: this.props.closedCaptionOptions.windowColor,
      selectedBackgroundColor: this.props.closedCaptionOptions.backgroundColor,
      textColors: ["White", "Blue", "Magenta", "Green", "Yellow", "Red", "Cyan", "Black"],
      windowColors: ["Transparent", "White", "Blue", "Magenta", "Green", "Yellow", "Red", "Cyan", "Black"],
      backgroundColors: ["Transparent", "White", "Blue", "Magenta", "Green", "Yellow", "Red", "Cyan", "Black"]
    };
  },

  changeTextColor: function(color){
    if (!this.props.closedCaptionOptions.enabled) {
      this.props.controller.toggleClosedCaptionEnabled();
    }
    this.props.controller.onClosedCaptionChange('textColor', color);
    this.setState({
      selectedTextColor: color
    });
  },

  changeWindowColor: function(color){
    if (!this.props.closedCaptionOptions.enabled) {
      this.props.controller.toggleClosedCaptionEnabled();
    }
    this.props.controller.onClosedCaptionChange('windowColor', color);
    this.setState({
      selectedWindowColor: color
    });
  },

  changeBackgroundColor: function(color){
    if (!this.props.closedCaptionOptions.enabled) {
      this.props.controller.toggleClosedCaptionEnabled();
    }
    this.props.controller.onClosedCaptionChange('backgroundColor', color);
    this.setState({
      selectedBackgroundColor: color
    });
  },

  render: function(){

    var textColorTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.TEXT_COLOR, this.props.localizableStrings);
    var textColorSelection = Utils.getLocalizedString(
      this.props.language,
      CONSTANTS.SKIN_TEXT[this.props.closedCaptionOptions.textColor.toUpperCase()],
      this.props.localizableStrings
    );

    var backgroundColorTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.BACKGROUND_COLOR, this.props.localizableStrings);
    var backgroundColorSelection = Utils.getLocalizedString(
      this.props.language,
      CONSTANTS.SKIN_TEXT[this.props.closedCaptionOptions.backgroundColor.toUpperCase()],
      this.props.localizableStrings
    );

    var windowColorTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.WINDOW_COLOR, this.props.localizableStrings);
    var windowColorSelection = Utils.getLocalizedString(
      this.props.language,
      CONSTANTS.SKIN_TEXT[this.props.closedCaptionOptions.windowColor.toUpperCase()],
      this.props.localizableStrings
    );

    return(
      <div className="oo-color-selection-tab">
        <div className="oo-color-selection-inner-wrapper">
          <SelectionContainer
            className="oo-text-color-selection-container"
            title={textColorTitle}
            selectionText={textColorSelection}
            >
            <div className="oo-text-color-items-container">
              <ColorSelector
                {...this.props}
                colors={this.state.textColors}
                onColorChange={this.changeTextColor}
                selectedColor={this.props.closedCaptionOptions.textColor}
                enabled={this.props.closedCaptionOptions.enabled}
              />
            </div>
          </SelectionContainer>

          <SelectionContainer
            title={backgroundColorTitle}
            selectionText={backgroundColorSelection}
            >
            <ColorSelector
              {...this.props}
              colors={this.state.backgroundColors}
              onColorChange={this.changeBackgroundColor}
              selectedColor={this.props.closedCaptionOptions.backgroundColor}
              enabled={this.props.closedCaptionOptions.enabled}
            />
          </SelectionContainer>

          <SelectionContainer
            title={windowColorTitle}
            selectionText={windowColorSelection}
            >
            <ColorSelector
              {...this.props}
              colors={this.state.windowColors}
              onColorChange={this.changeWindowColor}
              selectedColor={this.props.closedCaptionOptions.windowColor}
              enabled={this.props.closedCaptionOptions.enabled}
            />
          </SelectionContainer>
        </div>
      </div>
    );
  }
});

module.exports = ColorSelectionTab;

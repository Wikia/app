/**
 * Display component for video text tracks
 *
 * @module TextTrackPanel
 */
var React = require('react');
var baseFontSize = 1.0;

var TextTrackPanel = React.createClass({

  colorMap: {
    "White": "255,255,255",
    "Blue": "0,0,255",
    "Magenta": "255,0,255",
    "Green": "0,255,0",
    "Yellow": "255,255,0",
    "Red": "255,0,0",
    "Cyan": "0,255,255",
    "Black": "0,0,0",
    "Transparent": "0,0,0"
  },

  fontTypeMap: {
    "Monospaced Serif": '"Courier New", Courier, "Nimbus Mono L", "Cutive Mono", monospace',
    "Proportional Serif": '"Times New Roman", Times, Georgia, Cambria, "PT Serif Caption", serif',
    "Monospaced Sans-Serif": '"Deja Vu Sans Mono", "Lucida Console", Monaco, Consolas, "PT Mono", monospace',
    "Proportional Sans-Serif": 'Roboto, "Arial Unicode Ms", Arial, Helvetica, Verdana, "PT Sans Caption", sans-serif',
    "Casual": '"Comic Sans MS", Impact, Handlee, fantasy',
    "Cursive": '"Monotype Corsiva", "URW Chancery L", "Apple Chancery", "Dancing Script", cursive',
    "Small Capitals": '"Arial Unicode Ms", Arial, Helvetica, Verdana, "Marcellus SC", sans-serif'
  },

  fontVariantMap: {
    "Monospaced Serif": 'normal',
    "Proportional Serif": 'normal',
    "Monospaced Sans-Serif": 'normal',
    "Proportional Sans-Serif": 'normal',
    "Casual": 'normal',
    "Cursive": 'normal',
    "Small Capitals": 'small-caps'
  },

  fontSizeMap: {
    "Small": {
      "xs": (baseFontSize * 0.8) + "em",
      "sm": (baseFontSize * 1.0) + "em",
      "md": (baseFontSize * 1.2) + "em",
      "lg": (baseFontSize * 1.4) + "em"
    },
    "Medium": {
      "xs": (baseFontSize * 1.2) + "em",
      "sm": (baseFontSize * 1.4) + "em",
      "md": (baseFontSize * 1.6) + "em",
      "lg": (baseFontSize * 1.8) + "em"
    },
    "Large": {
      "xs": (baseFontSize * 1.6) + "em",
      "sm": (baseFontSize * 1.8) + "em",
      "md": (baseFontSize * 2.0) + "em",
      "lg": (baseFontSize * 2.2) + "em"
    },
    "Extra Large": {
      "xs": (baseFontSize * 2.0) + "em",
      "sm": (baseFontSize * 2.2) + "em",
      "md": (baseFontSize * 2.4) + "em",
      "lg": (baseFontSize * 2.6) + "em"
    }
  },

  textEnhancementMap: {
    "Uniform": "none",
    "Depressed": "1px 1px white",
    "Raised": "-1px -1px white, -3px 0px 5px black",
    "Shadow": "2px 2px 2px #1a1a1a"
  },

  setWindowBackgroundStyle: function(color, opacity) {
    if (color == "Transparent") opacity = 0;
    return {
      backgroundColor: "rgba(" + this.colorMap[color] + "," + opacity + ")"
    }
  },

  setTextStyle: function(color, opacity, fontType, fontSize, textEnhancement) {
    return {
      color: "rgba(" + this.colorMap[color] + "," + opacity + ")",
      fontFamily: this.fontTypeMap[fontType],
      fontVariant: this.fontVariantMap[fontType],
      fontSize: this.fontSizeMap[fontSize][this.props.responsiveView],
      textShadow: this.textEnhancementMap[textEnhancement]
    }
  },

  render: function() {
    if (!this.props.cueText) {
      return null;
    }

    return (
      <div className="oo-text-track-container">
        <div
          className={"oo-text-track-window"}
          style={
            this.setWindowBackgroundStyle(
              this.props.closedCaptionOptions.windowColor,
              this.props.closedCaptionOptions.windowOpacity
            )
          }
          >
          <div
            className={"oo-text-track-background"}
            style={
              this.setWindowBackgroundStyle(
                this.props.closedCaptionOptions.backgroundColor,
                this.props.closedCaptionOptions.backgroundOpacity
              )
            }
            >
            <div
              className={"oo-text-track"}
              style={
                this.setTextStyle(
                  this.props.closedCaptionOptions.textColor,
                  this.props.closedCaptionOptions.textOpacity,
                  this.props.closedCaptionOptions.fontType,
                  this.props.closedCaptionOptions.fontSize,
                  this.props.closedCaptionOptions.textEnhancement
                )
              }
              >
              {this.props.cueText}
            </div>
          </div>
        </div>
      </div>
    );
  }
});

TextTrackPanel.propTypes = {
  cueText: React.PropTypes.string,
  closedCaptionOptions: React.PropTypes.shape({
    textColor: React.PropTypes.string,
    windowColor: React.PropTypes.string,
    backgroundColor: React.PropTypes.string,
    textOpacity: React.PropTypes.oneOfType([React.PropTypes.string, React.PropTypes.number]),
    backgroundOpacity: React.PropTypes.oneOfType([React.PropTypes.string, React.PropTypes.number]),
    windowOpacity: React.PropTypes.oneOfType([React.PropTypes.string, React.PropTypes.number]),
    fontType: React.PropTypes.string,
    fontSize: React.PropTypes.string,
    textEnhancement: React.PropTypes.string
  })
};

TextTrackPanel.defaultProps = {
  cueText: null,
  closedCaptionOptions: {
    textColor: "White",
    windowColor: "Transparent",
    backgroundColor: "Black",
    textOpacity: 1,
    backgroundOpacity: 0.6,
    windowOpacity: 0,
    fontType: "Proportional Sans-Serif",
    fontSize: "Medium",
    textEnhancement: "Uniform"
  }
};

module.exports = TextTrackPanel;
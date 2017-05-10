/********************************************************************
  CLOSED CAPTION PANEL
*********************************************************************/
/**
* Closed caption settings screen.
*
* @class ClosedCaptionPanel
* @constructor
*/
var React = require('react'),
    Utils = require('../utils'),
    CONSTANTS = require('../../constants/constants'),
    LanguageTab = require('./languageTab'),
    ColorSelectionTab = require('./colorSelectionTab'),
    CaptionOpacityTab = require('./captionOpacityTab'),
    FontTypeTab = require('./fontTypeTab'),
    FontSizeTab = require('./fontSizeTab'),
    TextEnhancementsTab = require('./textEnhancementsTab'),
    CCPreviewPanel = require('./ccPreviewPanel'),
    Tabs = require('../tabs'),
    Tab = Tabs.Panel;

//The scroll buttons are not needed until the player's width is below a specific amount. This varies by language.
var tabMenuOverflowMap = {
  "en": 730,
  "es": 995,
  "zh": 610
};

var ClosedCaptionPanel = React.createClass({
  render: function(){

    var languageTabTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.LANGUAGE_TAB_TITLE, this.props.localizableStrings);
    var colorSelectionTabTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.COLOR_SELECTION_TAB_TITLE, this.props.localizableStrings);
    var captionOpacityTabTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.CAPTION_OPACITY_TAB_TITLE, this.props.localizableStrings);
    var fontTypeTabTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.FONT_TYPE_TAB_TITLE, this.props.localizableStrings);
    var fontSizeTabTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.FONT_SIZE_TAB_TITLE, this.props.localizableStrings);
    var textEnhancementsTabTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.TEXT_ENHANCEMENTS_TAB_TITLE, this.props.localizableStrings);

    return (
        <div className="oo-content-panel oo-closed-captions-panel">
          <Tabs
            className="captions-navbar"
            showScrollButtons={this.props.componentWidth < tabMenuOverflowMap[this.props.language]}
            {...this.props}>
            <Tab title={languageTabTitle}>
              <LanguageTab {...this.props} />
            </Tab>
            <Tab title={colorSelectionTabTitle}>
              <ColorSelectionTab {...this.props} />
            </Tab>
            <Tab title={captionOpacityTabTitle}>
              <CaptionOpacityTab {...this.props} />
            </Tab>
            <Tab title={fontTypeTabTitle}>
              <FontTypeTab {...this.props} />
            </Tab>
            <Tab title={fontSizeTabTitle}>
              <FontSizeTab {...this.props} />
            </Tab>
            <Tab title={textEnhancementsTabTitle}>
              <TextEnhancementsTab {...this.props} />
            </Tab>
          </Tabs>

          <CCPreviewPanel {...this.props} />
        </div>
    );
  }
});

module.exports = ClosedCaptionPanel;
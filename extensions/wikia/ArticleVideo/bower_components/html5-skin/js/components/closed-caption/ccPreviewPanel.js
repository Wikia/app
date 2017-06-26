var React = require('react'),
    Utils = require('../utils'),
    CONSTANTS = require('../../constants/constants'),
    ClassNames = require('classnames'),
    TextTrack = require('../textTrackPanel');

var CCPreviewPanel = React.createClass({
  render: function(){
    var closedCaptionPreviewTitle = Utils.getLocalizedString(this.props.language, CONSTANTS.SKIN_TEXT.CLOSED_CAPTION_PREVIEW, this.props.localizableStrings);
    var closedCaptionSampleText = Utils.getLocalizedString(this.props.closedCaptionOptions.language, CONSTANTS.SKIN_TEXT.SAMPLE_TEXT, this.props.localizableStrings);
    if (!closedCaptionSampleText) closedCaptionSampleText = Utils.getLocalizedString('en', CONSTANTS.SKIN_TEXT.SAMPLE_TEXT, this.props.localizableStrings);

    var previewCaptionClassName = ClassNames({
      'oo-preview-caption': true,
      'oo-disabled': !this.props.closedCaptionOptions.enabled
    });
    var previewTextClassName = ClassNames({
      'oo-preview-text': true,
      'oo-disabled': !this.props.closedCaptionOptions.enabled
    });

    return (
      <div className="oo-preview-panel">
        <div className={previewCaptionClassName}>{closedCaptionPreviewTitle}</div>
        <TextTrack {...this.props} cueText={closedCaptionSampleText} />
      </div>
    );
  }
});

module.exports = CCPreviewPanel;
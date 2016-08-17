(function($, tracker, wikiaEditor) {
  var dataKey = 'keyup-tracked';
  var textBoxId = 'wpTextbox1';
  var textBox = $('#'+textBoxId);

  var keyupTracked = function() {
    return $.data(textBox.get(0), dataKey);
  };

  var trackKeyup = function(category) {
    $.data(textBox.get(0), dataKey, true);
    tracker.track({
      category: category,
      action: 'enable',
      label: 'button-publish',
      trackingMethod: 'analytics'
    })
  };

  var tryTrackKeyup = function(category) {
    if (!keyupTracked()) {
      trackKeyup(category);
    }
  };

  if (typeof(wikiaEditor) != 'undefined' &&
    wikiaEditor.getInstance(textBoxId) != null &&
    wikiaEditor.getInstance(textBoxId).config.mode == 'wysiwyg') { // wysiwyg

    wikiaEditor.getInstance(textBoxId).events['ck-keyUp'].push({
      fn: function() {
        tryTrackKeyup('editor-ck');
      },
      scope: {}
    })
  } else { // source mode
    textBox.keyup(function() {
      tryTrackKeyup('editor-mw');
    });
  }
})($, Wikia.Tracker, WikiaEditor);

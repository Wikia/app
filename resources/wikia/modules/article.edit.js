(function($, tracker) {
  $('#wpTextbox1').keyup(function() {
    var dataKey = 'keyup-tracked';
    var tracked = $.data(this, dataKey);
    if (tracked) {
      return;
    }

    $.data(this, dataKey, true);
    tracker.track({
      action: 'enable',
      category: 'editor',
      label: 'nelsontest',
      trackingMethod: 'analytics'
    });
  });
})($, Wikia.Tracker);
$(function () {
	// ABTEST: DAR_RIGHTRAILPOSITION
	// Determine if we're in experiment DAR_RIGHTRAILPOSITION
	group = window.Wikia.AbTest
		? Wikia.AbTest.getGroup( "DAR_RIGHTRAILPOSITION" )
		: null ;

	switch (group) {
    case "STATIC":
        // don't let right rail to fall down
        $('html').addClass('keep-rail-on-right');
        break;
    default:
        // no changes in behaviour
	}
});

$(function() {
    // Determine what group we're in for experiment DAR_GlobalNavigationFixed
    group = window.Wikia.AbTest
        ? Wikia.AbTest.getGroup( "DAR_GlobalNavigationFixed" )
        : ;

    switch (group) {
        case "FIXED_HIDE_WIKIA_BAR":
            // collapse as the default state for anons
            if (WikiaBar && WikiaBar.isUserAnon() && WikiaBar.getAnonData(false) === false) {
                WikiaBar.handleLoggedOutUsersWikiaBar();
            }
            // no break intended: for this group we should have global nav fixed too
        case "FIXED_SHOW_WIKIA_BAR":
            $('body').addClass('global-header-fixed-at-top');
            break;
        default:
            // no changes in behaviour
    }
});

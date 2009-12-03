/**
 * WikiStickies "namespace."
 */
var WikiStickies = {};

// Parameters for feed types.
WikiStickies.newpagesParams = [
    'format=json',
    'action=query', 
    'list=recentchanges',
    'rcprop=title',
    'rcnamespace=0',
    'rctype=new',
    'rclimit=50'
];
WikiStickies.wantedpagesParams = [
    'format=json',
    'action=query', 
    'list=wantedpages',
    'wnoffset=3',
    'wnlimit=50'
];
WikiStickies.wantedimagesParams = [
'format=json',
    'action=query', 
    'list=wantedimages',
    'wnoffset=3',
    'wnlimit=50'
];

/**
 * Retrieves more items from a feed.
 *
 * @param object e    Event object used to call the function. Probably a click.
 * @param string feed Which feed to retrieve more items from.
 * @return ???
 */
WikiStickies.retrieveFeed = function (e, feed) {
    if (e) { e.preventDefault(); }
    switch (feed) {
        case 'newpages':
            var params = WikiStickies.newpagesParams;
            break;
        case 'wantedpages':
            var params = WikiStickies.wantedpagesParams;
            break;
        case 'wantedimages':
        default:
            var params = WikiStickies.wantedimagesParams;
            break;
    };
    $.getJSON( wgServer + '/api.php?' + params.join('&'), function ( response ) {
    });
}

/**
 * Displays the additional items and hides itself.
 */
WikiStickies.showMore = function (e) {
    if (e) {
        e.preventDefault();
        $(e.currentTarget.previousSibling).show();
        $(e.currentTarget).hide();
    }
}

$(document).ready(function() {
    $('.wikistickiesfeed .MoreLink').click(WikiStickies.showMore);
});

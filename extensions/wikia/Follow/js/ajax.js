var Follow = {};

Follow.tracklick = function(e) {
    var index = 0;
    var ul = null;
    var msg = "";
    ul =  $(e.target).closest("UL");
    index = $(e.target).closest("LI").index() + 1;
    msg = ul.attr("id").split("-");
    WET.byStr( 'WikiaFollowedPages/specialpage/links/' + msg[3] + '/' + index );
}

Follow.hover = function(e) {
    $(e.target).closest("LI").find(".otherNs,.ajax-unwatch").css('visibility', 'visible');
}


Follow.unhover = function(e) {
    $(".otherNs,.ajax-unwatch").css('visibility', 'hidden');
}


Follow.uwatch = function(e) {
    var msg = "";
    var target = $(e.target);

    var title = target.closest("A").attr("title");
    var ul = target.closest("UL");
    var li = target.closest("LI");
    var index = li.index() + 1;

    msg = ul.attr("id").split("-");
    WET.byStr( 'WikiaFollowedPages/specialpage/delete/' + msg[3] + '/' + index);

	api = new mw.Api();
	api['unwatch'](
        title,
        // Success
        function( watchResponse ) {
        	li.remove();
        }, function( ) {}
	);
    return false;
}

Follow.loadStatus = [];

Follow.showMore = function(e) {
    var eid = $(e.target).attr("id");
    var msg = eid.split("-");
    var key = msg[4];
    var head = eid.replace('more-', '');
    WET.byStr( 'WikiaFollowedPages/specialpage/viewall/' + msg[4] );

    if(typeof(Follow.loadStatus[key]) == 'undefined' || Follow.loadStatus[key] === null ) {
        var valueKey = 'count-' + head;
        Follow.loadStatus[key] = {'loaded' : wgFollowedPagesPagerLimit,'toload' : $('#'+valueKey).val()};
    }
    var cTime = new Date();
    var url = $(e.target).attr("href") + '&from=' + Follow.loadStatus[key].loaded + '&cb=' + cTime.getTime();
    $.ajax({
              url: url,
              success: function(data) {
                    Follow.loadStatus[key].loaded += wgFollowedPagesPagerLimitAjax;
                    if (Follow.loadStatus[key].loaded >= Follow.loadStatus[key].toload) {
                        $(e.target).hide();
                    }

                    $( "#" + head ).append(data);
                    var lis = $( "#wikiafollowedpages-special-heading-article" ).find('li');
                    lis.unbind().hover( Follow.hover,Follow.unhover );
                    lis.find('.title-link').unbind().click(Follow.tracklick);
                    lis.find('.ajax-unwatch').click(Follow.uwatch);
              }
            });
    return false;
}

Follow.syncUserPrefsEvent = function(e) {
	Follow.syncUserPrefs($(e.target));
}

Follow.syncUserPrefs = function(target) {
    var syncArray  = [];
    syncArray[ 'mw-input-enotifminoredits' ] = 'mw-input-enotiffollowedminoredits';
    syncArray[ 'mw-input-enotifwatchlistpages' ] = 'mw-input-enotiffollowedpages';
    syncArray[ 'mw-input-enotiffollowedminoredits' ] = 'mw-input-enotifminoredits';
    syncArray[ 'mw-input-enotiffollowedpages' ] =  'mw-input-enotifwatchlistpages';
    var dst = $( '#' + syncArray[target.attr('id')] );
    dst.attr('checked', target.attr('checked'));
}

$(function(){
    $('.ajax-unwatch').click(Follow.uwatch);
    $('.ajax-show-more').click(Follow.showMore);
    $('.ajax-show-more').show();

    $('#mw-input-enotiffollowedminoredits,#mw-input-enotiffollowedpages,#mw-input-enotifminoredits,#mw-input-enotifwatchlistpages').click(Follow.syncUserPrefsEvent);
    Follow.syncUserPrefs($('#mw-input-enotifminoredits'));
    Follow.syncUserPrefs($('#mw-input-enotifwatchlistpages'));
    $('.watched-list li').hover( Follow.hover,Follow.unhover );
    $('.title-link').click(Follow.tracklick);

    $('#unhide_list').click( function() {
        WET.byStr( 'WikiaFollowedPages/specialpage/unhide' );
    });
});
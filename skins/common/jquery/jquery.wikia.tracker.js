// Port of getTarget and resolveTextNode function (altogether) from YUI Event lib
// @author: Inez
// TODO: Move it to some more general place because it is not realted only to tracking
function getTarget(ev) {
    var t = ev.target || ev.srcElement;
    if(t && 3 == t.nodeType) {
        t = t.parentNode;
    }
    return t;
}

/*
@#@
*/

jQuery.tracker = function() {

    // Page view
    if(wgIsArticle) {
        $.tracker.byStr('view');
    }

    // Edit page
    if(wgArticleId != 0 && wgAction == 'edit') {
        $.tracker.byStr('editpage/view');
    }

    // Recent changes tracking
    if(wgCanonicalSpecialPageName == 'Recentchanges') {
        $.tracker.byStr('RecentChanges/view');
        $('#bodyContent').click(function (e) {
            var target = getTarget(e);
            if($.nodeName(target, 'a')) {
                if($.nodeName(target.parentNode, 'fieldset')) {
                    switch(target.innerHTML) {
                        case "50":
                        case "100":
                        case "250":
                        case "500":
                            $.tracker.byStr('RecentChanges/show/'+target.innerHTML+'changes');
                            break;
                        case "1":
                        case "3":
                        case "7":
                        case "14":
                        case "30":
                            $.tracker.byStr('RecentChanges/show/'+target.innerHTML+'days');
                            break;
                        default:
                            var option = target.href.substr(target.href.indexOf(wgPageName)+wgPageName.length+1);
                            option = option.substr(0, option.indexOf('=') + 2);
                            option = option.split('=');
                            if(option.length == 2) {
                                $.tracker.byStr('RecentChanges/show/'+(option[1] == 1 ? 'hide' : 'show')+option[0].substr(4));
                            }
                            break;
                    }
                } else {
                    if($(target).hasClass('mw-userlink')) {
                        $.tracker.byStr('RecentChanges/click/username');
                    } else if($.nodeName(target.parentNode, 'span')) {
                        if($(target.parentNode).hasClass('mw-usertoollinks')) {
                            var As = $(target.parentNode).find('a');
                            if(As.length == 3) {
                                if(As[0] == target) {
                                    $.tracker.byStr('RecentChanges/click/usertalk');
                                } else if(As[1] == target) {
                                    $.tracker.byStr('RecentChanges/click/usercontribs');
                                } else if(As[2] == target) {
                                    $.tracker.byStr('RecentChanges/click/userblock');
                                }
                            } else if(As.length == 2) {
                                if(As[0] == target) {
                                    $.tracker.byStr('RecentChanges/click/usertalk');
                                } else if(As[1] == target) {
                                    $.tracker.byStr('RecentChanges/click/userblock');
                                }
                            }
                        } else if($(target.parentNode).hasClass('mw-rollback-link')) {
                            $.tracker.byStr('RecentChanges/click/rollback');
                        }
                    } else if(target.href.indexOf('action=history') > 0) {
                            $.tracker.byStr('RecentChanges/click/history');
                    } else if(target.href.indexOf('diff=') > 0) {
                            $.tracker.byStr('RecentChanges/click/diff');
                    } else if(target.href.indexOf('/delete') > 0) {
                            $.tracker.byStr('RecentChanges/click/deletionlog');
                    } else {
                            $.tracker.byStr('RecentChanges/click/item');
                    }
                }
            } else if($.nodeName(target, 'input')) {
                $.tracker.byStr('RecentChanges/show/namespacego');
            }
        });
    }

    // Links on edit page
    $('#wpMinoredit, #wpWatchthis, #wpSave, #wpPreview, #wpDiff, #wpCancel, #wpEdithelp').click(function (e) {
        $.tracker.byStr('editpage/' + $(this).attr('id').substring(2).toLowerCase());
    });

    // TODO: Verify if it works
    // EditSimilar extension - result & preferences links - Bartek, Inez
    $('#editsimilar_links').click(function(e) {
        if(e.target.nodeName == 'A' && e.target.id != 'editsimilar_preferences') {
            $.tracker.byStr('userengagement/editSimilar_click');
        } else if(e.target.id == 'editsimilar_preferences') {
            $.tracker.byStr('userengagement/editSimilar/editSimilarPrefs');
        }
    });

    // CreateAPage extension - Bartek, Inez
    if($('#createpageform').length) {
        $('#wpSave').click(function(e) { $.tracker.byStr('createPage/save'); });
        $('#wpPreview').click(function(e) { $.tracker.byStr('createPage/preview'); });
        $('#wpAdvancedEdit').click(function(e) { $.tracker.byStr('createPage/advancedEdit'); });
    }

    // TODO: Verify if it works
    // Special:Userlogin (Macbre)
    if(wgCanonicalSpecialPageName && wgCanonicalSpecialPageName == 'Userlogin') {
        $('#userloginlink').children('a:first').click(function(e) { $.tracker.byStr('loginActions/goToSignup'); });
    }


    // Special:Search - Macbre, Inez
    if(wgCanonicalSpecialPageName && wgCanonicalSpecialPageName == 'Search') {
        var listNames = ['title', 'text'];
        // parse URL to get offset value
        var re = (/\&offset\=(\d+)/).exec(document.location);
        var offset = re ? (parseInt(re[1], 10) + 1) : 1;

        $('#bodyContent').children('.mw-search-results').each(function(i) {
            $(this).find('a').each(function(j) {
                $(this).click(function() {
                    $.tracker.byStr('search/searchResults/' + listNames[i] + 'Match/' + (offset + j));
                });
            });
            if(i == 0) {
                $.tracker.byStr('search/searchResults/view');
            }
        });
    }

    // Create Page
    if(wgCanonicalSpecialPageName && wgCanonicalSpecialPageName == 'CreatePage') {
        $.tracker.byStr('createPage');
    }

    initTracker();
};

jQuery.tracker.byStr = function(message) {
    $.tracker.track(message);
};

jQuery.tracker.byId = function(e) {
    $.tracker.track(this.id);
};

jQuery.tracker.track = function(fakeurl) {     
    fakeurlArray = fakeurl.split('/');
    if(typeof urchinTracker != 'undefined') {
        _uacct = "UA-2871474-1";
        var username = wgUserName == null ? 'anon' : 'user';
        var fake = '/1_' + skin + '/' + username + '/' + fakeurl;
        $().log('tracker: ' + fake);
        urchinTracker(fake);
        if(wgPrivateTracker) {
            fake = '/1_' + skin + '/' + wgDB + '/' + username + '/' + fakeurl;
            $().log('tracker: ' + fake);
            urchinTracker(fake);
        }
    }
};


// macbre: temporary fix
var WET = {
    byStr: function(str) {
        $.tracker.byStr(str)
    },
    byId: $.tracker.byId
};

$(document).ready($.tracker);

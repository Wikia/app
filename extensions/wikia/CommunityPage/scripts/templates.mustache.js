/* jshint ignore:start */ define( 'communitypage.templates.mustache', [], function() { 'use strict'; return {
    "CommunityPageSpecial_index" : '{{>pageHeader}}<div class="CommunityPageContainer"><div class="CommunityPageMainContent">{{#insightsModules.modules}}{{>insightsModule}}{{/insightsModules.modules}}</div><div class="WikiaRail">{{>contributorsModule}}{{>recentActivityModule}}</div></div>',"allAdmins" : '<h2>{{allMembersHeaderText}}</h2><ul class="reset top-contributors">{{#allAdminsList}}<li class="community-page-contributor"><div class="avatar-container"><a data-tracking="all-admins-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div><div class="community-page-contributor-details"><span class="community-page-details">{{contributionsText}}</span><a data-tracking="all-admins-user" href="{{profilePage}}">{{userName}}</a>{{#isAdmin}}<span class="community-page-subtle">{{admin}}</span>{{/isAdmin}}</div></li>{{/allAdminsList}}{{^allAdminsList}}<div class="community-page-zero">{{noAdminText}}<a href="{{noAdminHref}}">{{noAdminContactText}}</a></div>{{/allAdminsList}}</ul>',"allMembers" : '<h2>{{allMembersHeaderText}}</h2><div class="community-page-all-contributors-legend">{{allContributorsLegend}}</div><ul class="reset top-contributors">{{#members}}<li class ="community-page-all-contributors-item {{#isCurrent}}community-page-current-contributor{{/isCurrent}}"><div class="avatar-container"><a data-tracking="all-members-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div><div class="community-page-contributor-details"><span class="community-page-details">{{timeAgo}}</span><a data-tracking="all-members-user" href="{{profilePage}}">{{userName}}</a>{{#isAdmin}}<span class="community-page-subtle">{{admin}}</span>{{/isAdmin}}</div></li>{{/members}}{{^members}}<div class="community-page-zero">{{noMembersText}}</div>{{/members}}{{#haveMoreMembers}}<li class="community-page-all-contributors-item"><div class="contributor-details"><a href="{{moreMembersLink}}">{{moreMembersText}}</a></div></li>{{/haveMoreMembers}}</ul>',"contributorsModule" : '<div class="module ContributorsModule">{{#topContributors}}{{>topContributors}}{{/topContributors}}{{#topAdminsData}}{{>topAdmins}}{{/topAdminsData}}{{#recentlyJoined}}{{>recentlyJoined}}{{/recentlyJoined}}</div>',"insightsModule" : '<section class="community-page-insights-module" data-tracking="community-page-insights-{{type}}"><h3 class="community-page-insights-module-header">{{title}}</h3><p class="community-page-insights-module-description">{{description}}</p>{{#fulllistlink}}<a class="community-page-insights-module-full-list-link" href="{{fulllistlink}}" data-tracking="view-full-list">{{insightsModules.messages.fulllist}} &rarr;</a>{{/fulllistlink}}<ul class="community-page-insights-module-list">{{#pages}}<li class="community-page-insights-module-list-item"><a class="community-page-insights-module-edit-icon" href="{{editlink}}" data-tracking="edit-icon"></a><span class="community-page-insights-module-article-data"><a href="{{link.articleurl}}" data-tracking="page-link">{{link.text}}</a><div class="community-page-insights-module-metadata">{{{metadataDetails}}} {{#pageviews}}&middot; {{pageviews}}{{/pageviews}}</div></span><a class="community-page-insights-module-edit-link" data-tracking="edit-link" href="{{editlink}}">{{edittext}}</a></li>{{/pages}}</ul></section>',"loadingError" : '<div>{{loadingError}}</div>',"modalHeader" : '<ul class="reset modal-nav"><li class="modal-nav-all"><a data-tracking="modal-tab-all" id="modalTabAll" class="modal-tab-link" href="#">{{allText}} <span id="allCount">{{allMembersCount}}</span></a></li><li class="modal-nav-admins"><a data-tracking="modal-tab-admins" id="modalTabAdmins" class="modal-tab-link" href="#">{{adminsText}} <span id="allAdminsCount">{{allAdminsCount}}</span></a></li><li class="modal-nav-leaderboard"><a data-tracking="modal-tab-leaderboard" id="modalTabLeaderboard" class="modal-tab-link" href="#">{{leaderboardText}}</a></li></ul>',"modalLoadingScreen" : '<div class="throbber-placeholder"></div>',"pageHeader" : '<div class="community-page-header {{#heroImageUrl}}community-page-header-cover" style="background-image: url({{heroImageUrl}});{{/heroImageUrl}}"><div class="community-page-header-content"><h1>{{headerWelcomeMsg}}</h1><p><a href="#" class="signup-button">{{inviteFriendsText}}</a></p></div></div><div class="community-page-admin-welcome-message"><p class="community-page-admin-welcome-message-text">{{adminWelcomeMsg}}</p></div>',"recentActivityModule" : '{{#recentActivityModule}}<div class="module RecentActivityModule"><h2 class="activity-heading">{{activityHeading}}</h2><ul class="reset recent-changes">{{#activity}}<li><div class="avatar-container"><a data-tracking="user-avatar-link" href="{{profilePage}}">{{{userAvatar}}}</a></div><div class="change-message">{{{changeMessage}}}</div>{{#timeAgo}}<div class="community-page-subtle">{{timeAgo}}</div>{{/timeAgo}}</li>{{/activity}}</ul><a data-tracking="view-all-activity-link" href="{{moreActivityLink}}">{{moreActivityText}}</a></div>{{/recentActivityModule}}',"recentlyJoined" : '<div class="community-page-recently-joined">{{#haveNewMembers}}<div class="members"><h2>{{recentlyJoinedHeaderText}}</h2>{{#members}}<div class="avatar-container"><a data-tracking="recently-joined-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div>{{/members}}</div>{{/haveNewMembers}}<span class="more-link"><a data-tracking="show-modal-all" href="#" id="viewAllMembers">{{allMembers}}</a></span></div>',"topAdmins" : '<div class="top-admins"><h2>{{topAdminsHeaderText}}</h2><ul class="reset">{{#topAdminsList}}<li class="community-page-contributor"><div class="avatar-container"><a data-tracking="top-admins-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div><div class="community-page-contributor-details"><a data-tracking="top-admins-user" href="{{profilePage}}">{{userName}}</a></div></li>{{/topAdminsList}}{{^topAdminsList}}<div class="community-page-zero">{{noAdminText}}<a href="{{noAdminHref}}">{{noAdminContactText}}</a></div>{{/topAdminsList}}</ul>{{#haveOtherAdmins}}<div class="community-page-contributor" id="openModalTopAdmins"><div class="avatar-container avatar-more">+{{otherAdminsCount}}</div><div class="community-page-contributor-details"><a href="">{{otherAdmins}}</a></div></div>{{/haveOtherAdmins}}</div>',"topContributors" : '<h2>{{topContribsHeaderText}}</h2><div class="user-details"><div class="avatar-container">{{{userAvatar}}}</div><div class="community-page-rank"><span class="community-page-user-rank">{{userRank}} <small>/ {{weeklyEditorCount}}</small></span><span class="community-page-subtle">{{yourRankText}}</span></div><div class="user-contrib-count"><span class="community-page-user-rank">{{userContribCount}}</span><span class="community-page-subtle">{{userContributionsText}}</span></div></div><ul class="reset top-contributors">{{#contributors}}<li class="community-page-contributor"><div class="avatar-container"><a data-tracking="top-contributors-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div><div class="community-page-top-contributor-details"><div class="community-page-count">{{count}}.</div><div class="community-page-contributor-container"><a data-tracking="top-contributors-user" href="{{profilePage}}">{{userName}}</a><div class="community-page-subtle">{{contributionsText}}</div></div></div></li>{{/contributors}}{{^contributors}}<div class="community-page-zero">{{noContribsText}}</div>{{/contributors}}</ul>',"topContributorsModal" : '<h2>{{topContribsHeaderText}}</h2><div class="user-details"><div class="avatar-container">{{{userAvatar}}}</div><div class="community-page-rank"><span>{{userRank}} <small>/ {{weeklyEditorCount}}</small></span><span class="community-page-subtle">{{yourRankText}}</span></div><div class="user-contrib-count"><span>{{userContribCount}}</span><span class="community-page-subtle">{{userContributionsText}}</span></div></div><ul class="reset top-contributors">{{#contributors}}<li class="community-page-contributor"><div class="avatar-container"><a data-tracking="top-contributors-user-avatar" href="{{profilePage}}">{{{avatar}}}</a></div><div class="community-page-top-contributor-details"><div class="community-page-count">{{count}}.</div><div class="community-page-contributor-container"><a data-tracking="top-contributors-user" href="{{profilePage}}">{{userName}}</a>{{#isAdmin}}<span class="community-page-subtle">{{admin}}</span>{{/isAdmin}}</div><span class="community-page-details">{{contributionsText}}</span></div></li>{{/contributors}}{{^contributors}}<div class="community-page-zero">{{noContribsText}}</div>{{/contributors}}</ul>',
    "done": "true"
  }; }); /* jshint ignore:end */
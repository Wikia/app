define( 'ext.wikia.design-system.templates.mustache', [], function() { 'use strict'; return {
    "DesignSystemGlobalNavigationOnSiteNotifications" : '{{#.}}<li data-type={{type}} data-uri={{uri}} class="wds-notification-card {{#isUnread}}wds-is-unread{{/isUnread}}">{{#showAvatars}}<div class="wds-avatar-stack">{{#avatars}}<div class="wds-avatar"><a href="{{profileUrl}}"><img class="wds-avatar__image" src="{{avatarUrl}}" title="{{name}}" alt="{{name}}"></a></div>{{/avatars}}{{#showAvatarOverflow}}<div class="wds-avatar-stack__overflow">+{{avatarOverflow}}</div>{{/showAvatarOverflow}}</div>{{/showAvatars}}<a href="{{latestEventUri}}" class="wds-notification-card__outer-body"><div class="wds-notification-card__icon-wrapper"><svg class="wds-icon wds-icon-small" viewBox="0 0 18 18"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#{{icon}}"></use></svg></div><div class="wds-notification-card__body"><p class="wds-notification-card__text">{{{text}}}</p>{{#showSnippet}}<p class="wds-notification-card__snippet">{{snippet}}</p>{{/showSnippet}}{{#showLatestActor}}<p class="wds-notification-card__last-actor">{{latestActor.name}}</p>{{/showLatestActor}}<ul class="wds-notification-card__context-list"><li class="wds-notification-card__context-item">{{timeAgo}}</li><li class="wds-notification-card__context-separator">·</li><li class="wds-notification-card__context-item wds-notification-card__community">{{communityName}}</li></ul></div></a></li>{{/.}}',"DesignSystemLoadingSpinner" : '<svg class="{{spinnerClasses}}" width="{{fullDiameter}}" height="{{fullDiameter}}" viewBox="0 0 {{fullDiameter}} {{fullDiameter}}" xmlns="http://www.w3.org/2000/svg"><g transform="translate({{fullRadius}}, {{fullRadius}})"><circle class="{{strokeClasses}}" fill="none" stroke-width="{{strokeWidth}}"stroke-dasharray="{{strokeLength}}" stroke-dashoffset="{{strokeLength}}"stroke-linecap="round" r="{{radius}}"></circle></g></svg>',
    "done": "true"
  }; });

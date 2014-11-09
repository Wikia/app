define( 'wikia.dropdownNavigation.templates', [], function() { 'use strict'; return {
    "dropdown" : '<div class="wikia-dropdown-nav-wrapper" id="{{id}}"><ul class="wikia-dropdown-nav{{#classes}} {{.}}{{/classes}}" style="{{#maxHeight}}max-height: {{maxHeight}}px;{{/maxHeight}}">{{#sections}}{{>dropdownItem}}{{/sections}}</ul><div class="wikia-dropdown-nav-subsections-wrapper">{{#subsections}}<ul id="{{referenceId}}" class="wikia-dropdown-nav" style="{{#maxHeight}}max-height: {{maxHeight}}px;{{/maxHeight}}">{{#sections}}{{>dropdownItem}}{{/sections}}</ul>{{/subsections}}</div></div>',
    "dropdownItem" : '<li {{#referenceId}}data-id="{{referenceId}}" {{/referenceId}} class="wikia-dropdown-nav-item"><a href="{{href}}" title="{{title}}" rel="nofollow">{{title}}</a></li>',
    "done": "true"
  }; });

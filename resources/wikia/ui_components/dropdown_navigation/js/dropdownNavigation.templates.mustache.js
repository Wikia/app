define( 'wikia.dropdownNavigation.templates', [], function() { 'use strict'; return {
    "dropdown" : '<div class="wikia-dropdown-nav-wrapper" id="{{id}}"><div class="wikia-dropdown-nav-sections-wrapper"><div class="wikia-dropdown-nav-inner-wrapper"><ul class="wikia-dropdown-nav{{#classes}} {{.}}{{/classes}}">{{#sections}}{{>dropdownItem}}{{/sections}}</ul></div></div><div class="wikia-dropdown-nav-subsections-wrapper"><div class="wikia-dropdown-nav-inner-wrapper">{{#subsections}}<ul id="{{referenceId}}" class="wikia-dropdown-nav">{{#sections}}{{>dropdownItem}}{{/sections}}</ul>{{/subsections}}</div></div></div>',
    "dropdownItem" : '<li {{#referenceId}}data-id="{{referenceId}}" {{/referenceId}} class="wikia-dropdown-nav-item"><a href="{{href}}" title="{{title}}"{{#trackingId}}data-tracking-id="{{trackingId}}" {{/trackingId}}rel="nofollow"{{#dataAttr}}data-{{key}}="{{value}}"{{/dataAttr}}{{#class}} class="{{class}}" {{/class}}>{{title}}</a></li>',
    "done": "true"
  }; });

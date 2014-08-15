define( 'mediaGallery.templates.mustache', [], function() { 'use strict'; return {
    "MediaGalleryController_gallery" : '<div class="media-gallery-wrapper count-{{count}}">{{#media}}<div class="media {{classes}}">{{{thumbnail}}}</div>{{/media}}</div>',
    "MediaGalleryController_showMore" : '<div class="more"><button class="primary show">{{showMore}}</button><button class="secondary hide hidden">{{showLess}}</button></div>',
    "done": "true"
  }; });
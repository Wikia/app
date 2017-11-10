# JWPlayer for Fandom Apps
JWPlayer wrapped with Fandom's custom solutions:

* custom settings menu
* Design System icons
* custom events
* server-side logging errors
* prevents autoplaying on inactive tab
* tracking

## Installation

```
npm install https://github.com/Wikia/jwplayer-fandom --save
```

## Usage

1. Inject dist/index.css
2. Inject dist/wikiajwplayer.js
3. Execute:

```javascript
wikiaJWPlayer(playerElementId, options, callback);
```

### Arguments

#### playerElementId
Id of DOM element where the player should be placed

#### options
```javascript
{
  // adding this object enables tracking
  tracking: {
    // GA category, default: 'featured-video'
    category: string,
    // pass track function, data argument structure:
    /* {
          // event action name
          action: string,
          // event action category
          category: string,
          label: gaData.label,
          // value tracks sound state: 1 for muted, 0 for unmuted
          value: number,
          // event name for internal tracking
          eventName: 'videoplayerevent',
          // jwplayer video id (aka mediaId)
          videoId: string,
          player: 'jwplayer',
          trackingMethod: 'analytics'
        }
    */
    track: function,
    // pass custom dimension function, probably just window.guaSetCustomDimension
    setCustomDimension: function,
    // set to true if you want to enable comscore tracking
    comscore: boolean
  },
  // set to true if you want video to autostart
  autoplay: boolean,
  // set to true if you want video to be initiallty muted
  mute: boolean,
  // set language for captions, must map captions' label, defaults to user browser language
  // set to 'false' to turn them off completely
  selectedCaptionsLanguage: string,
  // if settings is not defined or all show* properties are set to false, settings icon doesn't appear
  settings: {
    // set to true when you want to give user option to enable/disable autoplay
    // autoplay toggle appears in settings menu which sends event `autoplayToggle` on click
    // application should listen on this event and set cookie for enabling/disabling autoplay for user
    showAutoplayToggle: boolean,
    // set to true when you want to give user option to change quality of the video
    // show quality option doesn't appear in Safari and mobile browsers even if the option is set to true
    showQuality: boolean,
	// set to true when you want to show captions toggle
	// captions toggle appears in settings menu, sends event `captionsSelected` on click
	showCaptions: boolean
  },
  related: {
    // countdown time to autoplay next video
    time: number,
    // playlistId configured in dashboard
    playlistId: string,
    // enable/disable autoplay for related videos
    autoplay: true
  },
  videoDetails: {
    // description of the video
    description: string,
    // title of the video
    title: string,
    // pass playlist returned by jwplayer API (https://cdn.jwplayer.com/v2/media/{mediaId})
    playlist: array
  },
  logger: {
    // logging level, default is error, available values: 'info', 'warn', 'error', 'off'
    logLevel: string,
    // client name (will be passed into logging service) e.g. 'oasis', 'mobile-wiki'
    clientName: string
  },
  // services domain, required by logging errors to event-logger service, default: 'services.wikia.com'
  servicesDomian: string
}
```

#### callback
Function executed when the player instance object is ready. JWPlayer instance object is passed as an argument.

### Example
Example usage in index.html

### Logging
By default we log all jwplayer errors through our service `event-logger`
You can browse logs in Kibana in `logstash-event-logger-*`

### Custom tracking pixel
When there is `pixel` property set in the first element of (videoDetails) playlist array, an `img`
element with this pixel will be created. The pixel property can be set in JWPlayer Dashboard as 
custom parameter. And it will be returned in `https://cdn.jwplayer.com/v2/media/{mediaId}` 
response in playlist item object.
 
For all next (related) videos played tracking pixel will be sent automatically if an url was set
in video custom parameter in jwplayer dashboard.

## Contributing
* Clone repo
* run `npm install`
* run `npm run dev` to build project, watch for file changes and run server
* we keep built project in dist folder, remember to run `npm run build`

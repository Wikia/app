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
  servicesDomian: string,
  // language code, default 'en'
  lang: string
}
```

### Testing ads
To enable add pre-rooll, ad this to playerSetup.advertising:
```
tag: 'https://pubads.g.doubleclick.net/gampad/ads?output=xml_vast3&env=vp&gdfp_req=1&unviewed_position_start=1&iu
=%2F5441%2Fwka1a.VIDEO%2Ffeatured%2Fsmartphone%2Fmercury-fv-article-ic%2F_project43-life&sz=640x480&url=http%3A%2F%2Fsandbox-so.project43.wikia.com%2Fwiki%2FSyntheticTests%2FPremium%2FFeaturedVideo&description_url=http%3A%2F%2Fsandbox-so.project43.wikia.com%2Fwiki%2FSyntheticTests%2FPremium%2FFeaturedVideo&correlator=2870076516136183&cust_params=wsi%3Dmxax%26s0%3Dlife%26s0v%3Dlifestyle%26s0c%3Dtech%26s1%3D_project43%26s2%3Dfv-article%26ab%3D52_170%26ar%3D3%3A4%26artid%3D355%26dmn%3Dwikiacom%26hostpre%3Dsandbox-so%26skin%3Dmercury%26lang%3Den%26wpage%3Dsynthetictests%2Fpremium%2Ffeaturedvideo%26ref%3Ddirect%26esrb%3Dteen%26geo%3DPL%26pv%3D4%26u%3Dsddavhq8d%26ksgmnt%3D%26top%3D1k%26passback%3Djwplayer%26pos%3DFEATURED%26rv%3D1%26src%3Dtest&vpos=preroll&vid_t=Synthetic%20green%20(16%3A9)&eid=31061775%2C509445015&sdkv=h.3.184.2&sdki=3c0d&scor=2816083339846417&adk=663970154&u_so=l&osd=2&frm=0&sdr=1&vpa=click&mpt=jwplayer&mpv=8.0.1&ged=ve4_td4_tt1_pd4_la4000_er123.0.275.300_vi0.0.732.412_vp100_ts0_eb24171_ct120'
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

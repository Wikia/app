## Video Handlers
A first thing to note is that Wikia does not store any videos on our servers.
Because we don't have the physical files ourselves, we have VideoHandler classes which are in charge of determining how to
play the video based on its provider. In some cases this involves loading a javascript player (as is the case with videos
ingested from YouTube), and in others it involves just using an iframe.

VideoHandlers are registered to their corresponding video files via the `$wgMediaHandlers[]` array (eg, `$wgMediaHandlers['video/youtube'] = 'YoutubeVideoHandler';`).
Mediawiki keys of the `img_major_mime` and the `img_minor_mime` columns found in the image table joined by a '/' to
determine which key to use when checking `$wgMediaHandlers`. So, for example, all YouTube videos have 'video' as
the value for their `img_major_mime`, and 'youtube' as the value for their `img_minor_mime`. Mediawiki will join those
2 creating 'video/youtube' then look in the `$wgMediaHandlers` array for that key and use the corresponding
`YoutubeVideoHandler` handler. See
[VideoHandlers.setup.php](https://github.com/Wikia/app/blob/dev/extensions/wikia/VideoHandlers/VideoHandlers.setup.php)
for more examples of registering video handlers.

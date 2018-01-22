# Feed Ingesters and Video Handers
## Feed Ingesters
Videos at wikia are broken into 2 categories: Premium and Non-Premium.

Non-premium videos are videos that we allow users to upload onto the site. These include videos from providers like youtube,
vimeo, dailymotion, etc. The full list of non-premium providers we support can be found [here](https://one.wikia-inc.com/wiki/Video/Video_Providers).

Premium videos are those that we license. We have a cron job which runs 4 times a day and polls each of our premium providers
to see if they have any new content. If they do, we upload those videos onto our video wikia found at [video.wikia.com](video.wikia.com).
Once those videos have been added to video wiki, users can then embed them in their local wikias (eg, thelastofus.wikia.com,
callofduty.wikia.com, disney.wikia.com, etc). The FeedIngester classes found in this extension are part of the ETL process
for each of these providers. Each one will check its corresponding provider's api, then normalize the data before uploading
it onto our site.

The cron job which runs is the [ingestPartnerWithVideoData.php script](https://github.com/Wikia/app/blob/dev/maintenance/wikia/ingestPartnerVideoWithData.php).
It iterates over our list of currently active premium providers, instantiates the corresponding feedingester class for
the provider, and kicks off the ingestion process.

## Remote Assets
Within premium videos there's a distinction between whether a video is a remote asset or not. A video which is not a
remote asset is one which is hosted by the provider themselves. For example, all of our CrunchyRoll videos are hosted
on CrunchyRoll servers and are played using CrunchyRoll's player. IGN is the same. All IGN's videos are hosted on IGN
servers and use the IGN player. A remote asset on the other hand, is a premium video which is actually hosted on Ooyala
and is played through Ooyala's player. Currently we have 2 providers whose videos we treat as remote assets: IVA and
Screenplay. During the ingestion process for these 2 providers, rather than uploading their assets onto our site, we instead
use Ooyala's API and load them onto Ooyala. Then, when we ingest videos from Ooyala, we ingest the video to Wikia normally
from there.

Here's a document on Wikia One which has a diagram for the overall process:
[Feed Ingestion Architecture]( https://one.wikia-inc.com/wiki/Video/Technical_Documentation/Feed_Ingestion_Architecture?file=Ingestion.jpg)

## Video Handlers
A first thing to note is that Wikia does not store any videos on our servers. Instead we store metadata about the video in
the video151 database (the database for video.wikia.com). The exact tables which we store information in can be found in
the [Feed Ingestion Architecture](https://one.wikia-inc.com/wiki/Video/Technical_Documentation/Feed_Ingestion_Architecture) link.
Because we don't have the physical files ourselves, we have VideoHandler classes which are in charge of determining how to
play the video based on its provider. In some cases this involves loading a javascript player (as is the case with videos
ingested from Ooyala), and in others it involves just using an iframe (as is the case for videos ingested from Maker Studios).

VideoHandlers are registered to their corresponding video files via the `$wgMediaHandlers[]` array (eg, `$wgMediaHandlers['video/youtube'] = 'YoutubeVideoHandler';`).
Mediawiki keys of the `img_major_mime` and the `img_minor_mime` columns found in the image table joined by a '/' to
determine which key to use when checking `$wgMediaHandlers`. So, for example, all YouTube videos have 'video' as
the value for their `img_major_mime`, and 'youtube' as the value for their `img_minor_mime`. Mediawiki will join those
2 creating 'video/youtube' then look in the `$wgMediaHandlers` array for that key and use the corresponding
`YoutubeVideoHandler` handler. See
[VideoHandlers.setup.php](https://github.com/Wikia/app/blob/dev/extensions/wikia/VideoHandlers/VideoHandlers.setup.php)
for more examples of registering video handlers.

Youtube extension
======


This extension allows you to use the `<youtube>` parser tag to embed a youtube video into an article. Please note that
in most of the cases the video is uploaded and the tag is replaced with a `[File]` references.

### Usage
 
Usage is documented on this cummunity help page: [http://community.wikia.com/wiki/Help%3AYouTube_extension]()

### Usage reports

The `<youtube>` parser tag is covered by this tags usage reporter: [https://github.com/Wikia/backend/blob/736feac731371cb763e6489d60b061a078dcc666/bin/specials/tags_report.pl](). 
To find articles on which this is used, simply go to `statsdb` and take a look at the `stats/city_used_tags` table. 


### Sunsetting

This extension should be deprecated, as we have much better ways of adding videos to articles. But this would require
going through all the articles using this tag and upgrading the tags (which is actually implemented by the `upgradeYouTubeTag`
function).

Before sunsetting this consider if this tag was used as a `{{#youtube:` template - not very likely, but it is worth checking.

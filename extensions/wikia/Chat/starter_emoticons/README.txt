Author: Sean Colombo
Date: 20110903

NOTE: These emoticons were made at Wikia and are some example images.
Like other Wikia content, they are open source and are released under
whatever the current Wikia license is (at the moment of this writing,
it is CC-BY-SA).

== IF YOU WANT TO USE CUSTOM EMOTICONS ON YOUR WIKI ==
Somewhat technical intro:<br/>
For performance reasons, the extension doesn't default to using
emoticons out of this directory though, we use them straight from
Community Wiki at Wikia (this lets them be cached once in Varnish
for all chats to use & minimizes the amount of images in a user's
browser cache if they're chatting on multiple wikis).

=== A quick how-to ===
* Upload the images from this directory as images on your site (by visiting Special:Upload).
* Edit the page "MediaWiki:Emoticons" with the full URLs of your images.
* Upload any new icons you'd like to use & also add them to the MediaWiki:Emoticons page.
* To see the changes, disconnect your user from Chat, then rejoin the room (you can just force-refresh the Special:Chat page). (Each time a user connects to chat, the emoticons-list for them will be loaded by Chat for that connection.)


== TODO: REFACTOR ==
To make this easier to use out of the box, we should re-write the Chat server to track wgExtensionsPath (it already does wgScriptPath and wgArticlePath) and use that to prepend the wgServer and wgExtensions path to any images that don't start with "http[s]?:\/\/" regex.

This will make it so that the icons will be pulled out of this directory by default instead of hotlinking from Wikia (which kinda sucks for Wikia since bandwidth costs money).

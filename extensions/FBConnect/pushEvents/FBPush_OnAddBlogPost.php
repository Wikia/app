<?php
/**
 * @author Sean Colombo
 *
 * Pushes an item to Facebook News Feed when the user adds a blog post to the site.
 */

global $wgExtensionMessagesFiles;
$pushDir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['FBPush_OnAddBlogPost'] = $pushDir . "FBPush_OnAddBlogPost.i18n.php";

class FBPush_OnAddBlogPost extends FBConnectPushEvent {
	protected $isAllowedUserPreferenceName = 'fbconnect-push-allow-OnAddBlogPost'; // must correspond to an i18n message that is 'tog-[the value of the string on this line]'.
	
	public function init(){
		wfProfileIn(__METHOD__);

		wfLoadExtensionMessages('FBPush_OnAddBlogPost');
		
		wfProfileOut(__METHOD__);
	}
}

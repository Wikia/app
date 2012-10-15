/** Mobile Redirect Helper
 *
 *  Redirects to a wikimedia-mobile installation for viewers on iPhone, iPod 
 *  Touch, Palm Pre, and Android devices.
 *
 *  You can turn off the redirect by setting the cookie "stopMobileRedirect=true"
 */
if ( /(iPhone|iPod|Android.*Mobile|webOS|NetFront|Opera Mini|SEMC-Browser|PlayStation Portable|BlackBerry|Bada|NokiaBrowser|MeeGo|Series 60)/
  .test( navigator.userAgent ) )
{
  if (    (document.cookie.indexOf("irect=t") < 0)  // Don't redirect if we have the stop cookie ... only testing a subportion of the cookie. Should be REALLY unique!
       && (wgNamespaceNumber >= 0)                 // Don't redirect special pages
       && (wgAction == "view"))                    // Don't redirect URLs that aren't simple page views 
  {
    // If we've made it here, then we are going ahead with the redirect

    // If we are NOT on the main page, then set the pageName!
    if (wgPageName != wgMainPageTitle.replace(/ /g, '_')) {
      wgWikimediaMobileUrl += '/' + encodeURI(wgPageName);
    }
    document.location = wgWikimediaMobileUrl;
  }
}

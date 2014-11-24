# Helios #

## Implementation Log ##

* Step 1: simplify the global function `wfGetSessionKey()`
    * get rid of `$wgExternalUserEnabled` as it is `true`, always
    * use literal `wikicities` rather than `$wgExternalSharedDB` as it is not
      going to change before the Helios project is delivered
* Step 2: remove `$wgExternalUserEnabled` from code and config

## Notes ##

### Problems ###

* I want an AuthPlugin class dealing only with authentication
* I want an ExternalUser class dealing only with storage (for as long as it is
  required)

    * A long time ago (in a galaxy far, far away), ExternalUser was built to
      replace AuthPlugin. It turned out otherwise and ExternalUser was removed
      from MediaWiki in 1.22.

    * ExternalUser will be removed from Wikia MediaWiki-based application, too,
      once we have a service (as in SOA) for dealing with user meta data.

    * Wikia MediaWiki-based application uses ExternalUser_Wikia which extends
      the original ExternalUser class. In order to simplify our code and to
      make ExternalUser easier to remove from it, I am going to merge
      ExternalUser to ExternalUser_Wikia and do all require cleanups here and
      there.

    * there is a special case of [Uncyclopedia](http://uncyclopedia.wikia.com/)
      that has to be taken into account (it has to be configurable whether to
      use Helios or not, although backwards compatibility will be limited)

    * `$wgExternalUserEnabled` and `$wgExternalAuthType` are the point to start.

    * `$wgExternalUserEnabled` is `true` everywhere, including Uncyclopedia and
      it is referenced in the application code only once in the method used to
      determine the session key. It is `wikicities:session:<UserId>`, always.

    * for all wikis but Uncyclopedia, `$wgExternalAuthType` is not null and set
      to 'ExternalUser_Wikia' and `/includes/wikia/ExternalUser_Wikia.php` is
      included.

    * the next step is to reuse current AuthPlugin and ExternalUser classes
      under new names: HeliosAuthPlugin and HeliosExternalUser

    * also, $wgExternalAuthType is terribly misleading, because ExternalUser
      in fact does not have anything to do with authentication
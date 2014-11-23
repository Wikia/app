# Helios #

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
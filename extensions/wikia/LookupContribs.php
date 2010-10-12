<?php
define ('LOOKUPCONTRIBS_HELP','This special page can be used to display user\'s contributions on multiple wikias. For displaying the list, give username below.') ;
define ('LOOKUPCONTRIBS_PATH', '/') ;
/* cache? no cache? */
define ('LOOKUPCONTRIBS_NO_CACHE', 'false') ;

require_once ($IP.LOOKUPCONTRIBS_PATH."extensions/wikia/LookupContribs/SpecialLookupContribs.php") ;
require_once ($IP.LOOKUPCONTRIBS_PATH."extensions/wikia/LookupContribs/SpecialLookupContribs_hooks.php") ;

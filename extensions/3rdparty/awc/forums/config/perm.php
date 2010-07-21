<?PHP
# Forum Admins and Moderators
#   awc_ForumAdmin
#   awc_ForumMod
# bureaucrat - is defaulted with FULL control
# sysops  - is defaulted with Admin and Mod control (a few AdminCP options limited)
$wgGroupPermissions['Forum:Admin']['awc_ForumAdmin']  = true;
$wgGroupPermissions['Forum:Mod']['awc_ForumMod']      = true;

# awc_CanNotView
// Users who can not read the forums (this overwride any other permission setting)...
$wgGroupPermissions['Forum:CantView']['awc_CanNotView']          	= true;

# awc_CanNotPost
// Users that can NOT post in the forums (this overwride any other permission setting)...
$wgGroupPermissions['Forum:CantPost'    ]['awc_CanNotPost']          	= true;

# awc_CanEdit
// Allowed to edit their own post...
$wgGroupPermissions['user' ]['awc_CanEdit']         = true ;
$wgGroupPermissions['*'    ]['awc_CanEdit']         = false ;

# awc_CanNotEdit
// Users who can NOT edit their own posts (this overwride any other permission setting)...
$wgGroupPermissions['Forum:CantEdit']['awc_CanNotEdit']          	= true;

# awc_CanDelete
// Allowed to delete their own post...
$wgGroupPermissions['user' ]['awc_CanDelete']      	= false ;
$wgGroupPermissions['*'    ]['awc_CanDelete']      	= false ;

# awc_CanNotDelete
//Users that can NOT delete their own posts (this overwride any other permission setting)...
$wgGroupPermissions['Forum:CantDelete']['awc_CanNotDelete']          	= true;

# awc_CanSearch
// Allowed to search...
$wgGroupPermissions['*'    ]['awc_CanSearch']      	= true ;
$wgGroupPermissions['user' ]['awc_CanSearch']      	= true ;

# awc_CanNotSearch
// Users that can NOT search..
$wgGroupPermissions['Forum:CantSearch']['awc_CanNotSearch']          	= true;

# awc_CanHaveSig
// Allowed to have Sig..
$wgGroupPermissions['user' ]['awc_CanHaveSig']      = true;

# awc_CanNotHaveSig
// Users who can not have a Sig...
$wgGroupPermissions['Forum:NoSigs' ]['awc_CanNotHaveSig']      = true ;

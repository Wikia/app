<?php
/**
 * Error/warning codes for DynamicPageList2 extension.
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author m:User:Dangerman <cyril.dangerville@gmail.com>
 * @version 1.0.5
 * @version 1.0.8
 * 			removed blank lines at the end of the file
 * @version 1.0.9
 * 			added message: ERR_OpenReferences
 * @version 1.6.4
 *			moved messages into the format needed for wfLoadExtensionMessages - Sean Colombo
 *			moved error codes to a separate file from internationalization - Sean Colombo
*/


class DPL2_i18n
{
    // FATAL
    const FATAL_WRONGNS                  = 1;
    const FATAL_WRONGLINKSTO             = 2;
    const FATAL_TOOMANYCATS              = 3;
    const FATAL_TOOFEWCATS               = 4;
    const FATAL_NOSELECTION              = 5;
    const FATAL_CATDATEBUTNOINCLUDEDCATS = 6;
    const FATAL_CATDATEBUTMORETHAN1CAT   = 7;
    const FATAL_MORETHAN1TYPEOFDATE      = 8;
    const FATAL_WRONGORDERMETHOD         = 9;
    const FATAL_DOMINANTSECTIONRANGE     = 10;
    const FATAL_NOCLVIEW                 = 11;
    const FATAL_OPENREFERENCES           = 12;

    // ERROR

    // WARN
    const WARN_UNKNOWNPARAM                = 13;
    const WARN_WRONGPARAM                  = 14;
    const WARN_WRONGPARAM_INT              = 15;
    const WARN_NORESULTS                   = 16;
    const WARN_CATOUTPUTBUTWRONGPARAMS     = 17;
    const WARN_HEADINGBUTSIMPLEORDERMETHOD = 18;
    const WARN_DEBUGPARAMNOTFIRST          = 19;
    const WARN_TRANSCLUSIONLOOP            = 20;

    // INFO

    // DEBUG
    const DEBUG_QUERY = 21;

    // TRACE
}

/**
 * This little file is used to register jQuery as AMD module
 *
 * Due to the way we load jQuery (i.e. from CDN) we can't
 * load AMD framework before jQuery is loaded, hence it
 * cannot register itself. So, we do it here
 *
 * @author macbre
 */
define( "jquery", [], function () { return jQuery; } );

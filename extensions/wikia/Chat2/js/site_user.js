/**
 * Loads Chat's site and user custom JavaScript after "ext.Chat2" module and it's dependencies are fully loaded
 *
 * @see SUS-2198
 */
if (mw.config.get('wgUseSiteJs') === true) {
    mw.loader.load('chat.site');
}

if (mw.config.get('wgAllowUserJs') === true) {
    mw.loader.load('chat.user');
}

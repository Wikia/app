# Helios #

Helios is Wikia's approach to extract logic related to user meta data and
user authentication from MediaWiki-based application and set it up as an
external service. The MediaWiki-based application would then be a client of that
service.

The `\Wikia\Helios\ExternalUser` class will replace the currently used
`\ExternalUser_Wikia` and handle all things related to storage.

The `\Wikia\Helios\AuthPlugin` class will replace the currently used
`\AuthPlugin` (a dummy class) and handle all things related to authentication.

The `\Wikia\Helios\AuthPluginUser` class will replace the currently used
`\AuthPluginUser` (a dummy class) which is a complementary class for the above
`AuthPlugin`.

Currently, the above classes do not implement any logic, they just extend
the previously used classes and let us have a consistent and unified way to
reference them.
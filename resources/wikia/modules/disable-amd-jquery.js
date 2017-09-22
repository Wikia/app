/**
 * We have to disable defining jquery AMD module after jquery is loaded
 * to prevent redefine jQuery again by another jQuery library that may be loaded later.
 *
 * Loading jQuery again caused overriding jQuery AMD module and we were loosing jquery plugins (e.g. $.throttle).
 * E.g. Ooyala Player caused the issue, because it has its own jQuery lib included.
 */
define.amd.jQuery = false;

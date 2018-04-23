<?php
/**
 * Bump $wgStyleVersion when changing the global style sheets and JavaScript.
 * It should be appended in the query string of static CSS and JS includes,
 * to ensure that client-side caches do not keep obsolete copies of global
 * styles. This entire file will be overwritten by deploy tools upon release.
 * @var int $wgStyleVersion
 */
$wgStyleVersion = 0;

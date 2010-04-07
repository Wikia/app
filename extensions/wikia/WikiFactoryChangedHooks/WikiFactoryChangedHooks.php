<?php
/**
 * @author Sean Colombo
 *
 * Since these hooks need to be available on any wiki where WikiFactory is enabled (even
 * when the extensions that they pertain to aren't available) they have all been aggregated here.
 */

// Alphabetical
$wgHooks['WikiFactoryChanged'][] = 'WikiFactoryChangedHooks::recipesTweaks';

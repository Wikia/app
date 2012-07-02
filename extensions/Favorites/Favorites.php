<?php
/**
 * Copyright (C) 2011 Jeremy Lemley
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Favorites',
	'author' => 'Jeremy Lemley',
	'descriptionmsg' => 'favorites-desc',
	'version' => '0.2.6',
	'url' => "http://www.mediawiki.org/wiki/Extension:Favorites",
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Favorites'] = $dir . 'favorites.i18n.php';
$wgAutoloadClasses['FavoritelistEditor'] = $dir . 'FavoritelistEditor.php';
$wgAutoloadClasses['FavoritedItem'] = $dir . 'FavoritedItem.php';
$wgAutoloadClasses['SpecialFavoritelist'] = $dir . 'SpecialFavoritelist.php';
$wgAutoloadClasses['FavoritesHooks'] = $dir . 'FavoritesHooks.php';
$wgAutoloadClasses['FavParser'] =  $dir . 'FavParser.php';

$wgSpecialPages['Favoritelist'] = 'SpecialFavoritelist';
$wgSpecialPageGroups['Favoritelist'] = 'other';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'FavoritesHooks::onLoadExtensionSchemaUpdates';

//tag hook
$wgHooks['ParserFirstCallInit'][] = 'FavoritesHooks::onParserFirstCallInit';

//add the icon / link
$wgHooks['SkinTemplateNavigation'][] = 'FavoritesHooks::onSkinTemplateNavigation';  // For Vector
$wgHooks['SkinTemplateTabs'][] = 'FavoritesHooks::onSkinTemplateTabs';  // For other skins

//add CSS - only needed for icon display
$wgHooks['BeforePageDisplay'][] = 'FavoritesHooks::onBeforePageDisplay';

//add or remove
$wgHooks['UnknownAction'][] = 'FavoritesHooks::onUnknownAction';

//handle page moves and deletes
$wgHooks['TitleMoveComplete'][] = 'FavoritesHooks::onTitleMoveComplete';
$wgHooks['ArticleDeleteComplete'][] = 'FavoritesHooks::onArticleDeleteComplete';

// Display a "My Favorites" link in the personal urls area
$wgHooks['PersonalUrls'][] = 'FavoritesHooks::onPersonalUrls';

$wgFavoritesPersonalURL = true;
$wgUseIconFavorite = true;

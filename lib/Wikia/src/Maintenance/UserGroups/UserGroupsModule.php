<?php

namespace Wikia\Maintenance\UserGroups;

use Interop\Container\ContainerInterface;
use Wikia\Cache\BagOStuffCacheProvider;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;

class UserGroupsModule implements Module {

	const GROUP_LIST_VERSION = 1;
	const USER_GROUP_VERSION = 1;

	public function configure(InjectorBuilder $builder) {
		$builder
				->bind(UserGroupList::class)->to(function () {
					global $wgSpecialsDB, $wgMemc;

					$specialsDb = wfGetDB(DB_MASTER, [], $wgSpecialsDB);
					$cache = new BagOStuffCacheProvider( $wgMemc );
					$cache->setNamespace( UserGroupList::class . ":" . self::GROUP_LIST_VERSION );

					return new UserGroupList($specialsDb, $cache);
				})
				->bind(UserGroupUpdater::class)->to(function (ContainerInterface $c) {
					global $wgSpecialsDB, $wgMemc, $wgExternalSharedDB;

					$specialsDb = wfGetDB(DB_MASTER, [], $wgSpecialsDB);
					$wikiCitiesDb = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);

					$cache = new BagOStuffCacheProvider( $wgMemc );
					$cache->setNamespace( UserGroupUpdater::class . ":" . self::USER_GROUP_VERSION );

					/** @var UserGroupList $groupList */
					$groupList = $c->get(UserGroupList::class);

					return new UserGroupUpdater($groupList, $specialsDb, $wikiCitiesDb, $cache);
				});
	}
}

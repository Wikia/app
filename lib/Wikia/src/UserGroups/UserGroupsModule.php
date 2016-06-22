<?php

namespace Wikia\UserGroups;

use Interop\Container\ContainerInterface;
use Wikia\Cache\BagOStuffCacheProvider;
use Wikia\DependencyInjection\InjectorBuilder;
use Wikia\DependencyInjection\Module;
use Wikia\UserGroups\Maintenance\UserGroupUpdater;

class UserGroupsModule implements Module {

	const GROUP_LIST_VERSION = 1;
	const USER_GROUP_VERSION = 1;

	public function configure(InjectorBuilder $builder) {
		$builder
				->bind(UserGroupStorage::class)->to(function () {
					global $wgSpecialsDB, $wgExternalSharedDB;
					
					return new UserGroupStorage(
							wfGetDB(DB_MASTER, [], $wgSpecialsDB),
							wfGetDB(DB_SLAVE, [], $wgExternalSharedDB));
				})
				->bind(UserGroupList::class)->to(function (ContainerInterface $c) {
					global $wgMemc;

					/** @var UserGroupStorage $storage */
					$storage = $c->get(UserGroupStorage::class);

					$cache = new BagOStuffCacheProvider( $wgMemc );
					$cache->setNamespace( UserGroupList::class . ":" . self::GROUP_LIST_VERSION );

					return new UserGroupList($storage, $cache);
				})
				->bind(UserGroupUpdater::class)->to(function (ContainerInterface $c) {
					global $wgMemc;

					$cache = new BagOStuffCacheProvider( $wgMemc );
					$cache->setNamespace( UserGroupUpdater::class . ":" . self::USER_GROUP_VERSION );

					/** @var UserGroupList $groupList */
					$groupList = $c->get(UserGroupList::class);

					/** @var UserGroupStorage $storage */
					$storage = $c->get(UserGroupStorage::class);

					return new UserGroupUpdater($storage, $groupList, $cache);
				});
	}
}

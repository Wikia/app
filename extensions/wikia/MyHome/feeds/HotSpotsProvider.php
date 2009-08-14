<?php

class HotSpotsProvider {

	public function get() {
		global $wgContentNamespaces;

		$namespaces[] = NS_USER_TALK;
		$namespaces[] = NS_PROJECT;
		$namespaces[] = NS_PROJECT_TALK;

		foreach(array_values($wgContentNamespaces) as $ns) {
			$namespaces[] = $ns;
			$namespaces[] = $ns + 1;
		}

		$dbr = wfGetDB(DB_SLAVE);

		$rc_id = $dbr->selectField(
				'recentchanges',
				'rc_id',
				array(
					'rc_timestamp > date_sub(now(), interval 7 day)',
					'rc_namespace IN ('.implode(',', $namespaces).')'
				),
				__METHOD__
			);

		$res = $dbr->select(
				'recentchanges',
				'rc_title, count(distinct(rc_user)) as cnt',
				array(
					'rc_id > '.$rc_id,
					'rc_namespace IN ('.implode(',', $namespaces).')'
				),
				__METHOD__,
				array('GROUP BY' => 1, 'ORDER BY' => 'cnt DESC, rc_title ASC', 'LIMIT' => 5, 'HAVING' => 'cnt > 1')
			);

		while($row = $dbr->fetchObject($res)) {
			print_pre($row);
		}





		print_pre($rc_id);

	}

}

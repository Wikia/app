<?php

class ActiveStrategy {
	static function getTaskForces( $limit ) {
		$dbr = wfGetDB( DB_SLAVE );

		$options = array();

		if ($limit) {
			$options['LIMIT'] = $limit;
		}

		$res = $dbr->select(
			array( "page", 'categorylinks',
				'categorylinks as finishedcategory' ),
			array(
				'page_id',
				'page_namespace',
				'page_title',
				"substring_index(page_title, '/', 2) AS tf_name"
			),
			array(
				'page_namespace' => 0,
				"page_title LIKE 'Task_force/%'",
				"page_title NOT LIKE 'Task_force/%/%'",
				'finishedcategory.cl_from IS NULL',
			),
			__METHOD__,
			$options,
			array(
				'categorylinks' => array( 'RIGHT JOIN',
					array(
						'categorylinks.cl_from=page_id',
						'categorylinks.cl_to' => 'Task_force',
					),
				),
				'categorylinks as finishedcategory' =>
					array( 'left join',
						array(
							'finishedcategory.cl_from=page.page_id',
							'finishedcategory.cl_to' => 'Task_force_finished'
						),
					),
			) );

		return $res;
	}

	static function getProposals() {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			array( "page",
				'categorylinks as finishedcategory' ),
			array(
				'page_id',
				'page_namespace',
				'page_title',
				"page_title AS tf_name"
			),
			array(
				'page_namespace' => 106 /* Proposal: */,
				'finishedcategory.cl_from IS NULL',
			),
			__METHOD__,
			array(),
			array(
				'categorylinks as finishedcategory' =>
					array( 'left join',
						array(
							'finishedcategory.cl_from=page.page_id',
							'finishedcategory.cl_to' => 'Archived Done'
						),
					),
			) );

		return $res;
	}

	static function formatResult( $skin, $taskForce, $number, $sort, $type ) {
		global $wgContLang, $wgLang, $wgActiveStrategyColors;

		if ( ! $taskForce ) {
			// Fail.
			return;
		}

		$title = Title::newFromText( $taskForce );
		$text = $wgContLang->convert( $title->getPrefixedText() );
		if ( $type == 'taskforce' ) {
			$text = self::getTaskForceName( $text );
		} else {
			$title = Title::newFromText( $text );
			$text = $title->getText();
		}
		$pageLink = $skin->linkKnown( $title, $text );
		$colors = null;
		$color = null;
		$style = '';

		if ( isset( $wgActiveStrategyColors[$sort] ) ) {
			$colors = $wgActiveStrategyColors[$sort];
		} else {
			$colors = $wgActiveStrategyColors['default'];
		}

		ksort($colors);

		foreach( $colors as $threshold => $curColor ) {
			if ( $number >= $threshold ) {
				$color = $curColor;
			} else {
				break;
			}
		}

		if ($color) {
			$style = 'padding-left: 3px; border-left: 1em solid #'.$color;
		}

		if ( $sort == 'members' ) {
			$pageLink .= ' ('.wfMsg( 'nmembers', $number ).')';
		}

		$pageLink .= " <!-- $number -->";

		if ($style) {
			$item = Xml::tags( 'span', array( 'style' => $style ), $pageLink );
		} else {
			$item = $pageLink;
		}

		$item .= "<br/>";

		return $item;
	}

	static function getTaskForceName( $text ) {
		$text = substr( $text, strpos($text, '/') + 1 );

		if ( strpos( $text, '/' ) ) {
			$text = substr( $text, 0, strpos( $text, '/' ) );
		}

		return $text;
	}

	static function getTaskForcePageConditions( $taskForces, &$tables, &$fields, &$conds,
							&$joinConds, &$lookup ) {
		$categories = array();
		foreach( $taskForces as $row ) {
			$text = self::getTaskForceName( $row->tf_name );
			$tempTitle = Title::makeTitleSafe( NS_CATEGORY, $text );
			$categories[$tempTitle->getDBkey()] = $row->tf_name;
			$categories[$tempTitle->getDBkey()."_task_force"] = $row->tf_name;
			$categories[$tempTitle->getDBkey()."_Task_Force"] = $row->tf_name;
		}

		$tables[] = 'categorylinks';
		$fields[] = 'categorylinks.cl_to AS keyfield';
		$conds['categorylinks.cl_to'] = array_keys($categories);
		$joinConds = array( 'categorylinks' =>
				array( 'left join', 'categorylinks.cl_from=page.page_id' ) );

		$lookup = $categories;
	}

	static function getProposalPageConditions( &$tables, &$fields, &$conds,
							&$join_conds, &$lookup ) {
		$fields[] = 'page.page_title AS keyfield';
		$conds['page_namespace'] = 106;

		$tables[] = 'categorylinks as finishedcategory';
		$conds[] = 'finishedcategory.cl_from IS NULL';
		$join_conds['categorylinks as finishedcategory'] =
			array( 'left join', array( 'cl_from=page_id',
				'cl_to' => 'Archived_Done' ) );
	}

	static function getOutput( $args ) {
		global $wgUser, $wgActiveStrategyPeriod;

		$html = '';
		$db = wfGetDB( DB_MASTER );
		$sk = $wgUser->getSkin();
		$limit = null;

		if ( empty( $args['type'] ) ) {
			$args['type'] = 'taskforce';
		}

		$sortField = 'members';

		if ( isset($args['sort']) ) {
			$sortField = $args['sort'];
		}

		if ( isset( $args['max'] ) ) {
			$limit = intval($args['max']);
		}

		if ( $args['type'] == 'taskforce' ) {
			$masterPages = self::getTaskForces( $limit );
		}

		$tables = array( );
		$fields = array( );
		$conds = array();
		$joinConds = array();
		$options = array( 'GROUP BY' => 'keyfield', 'ORDER BY' => 'value DESC' );
		$lookup = NULL;

		if ( $limit ) {
			$options['LIMIT'] = intval($limit);
		}

		if ( $args['type'] == 'taskforce' ) {
			self::getTaskForcePageConditions( $masterPages, $tables, $fields,
								$conds, $joinConds, $lookup );
		} elseif( $args['type'] == 'proposal' ) {
			self::getProposalPageConditions( $tables, $fields,
							$conds, $joinConds, $lookup );
		}

		$tables[] = 'page';

		if ( $sortField == 'edits' ) {
			$cutoff = $db->timestamp( time() - $wgActiveStrategyPeriod );
			$cutoff = $db->addQuotes( $cutoff );
			$tables[] = 'revision';
			$joinConds['revision'] =
				array( 'left join',
					array( 'revision.rev_page=page.page_id',
						"rev_timestamp > $cutoff",
						"rev_page IS NOT NULL" ) );
			$fields[] = 'count(distinct rev_id) + count(distinct thread_id) as value';
			$tables[] = 'user_groups';
			$joinConds['user_groups'] = array( 'left join',
							array( 'ug_user != 0', 'ug_user=rev_user',
								'ug_group' => 'bot' ) );
			$conds[] = 'ug_user IS NULL';

			// Include LQT posts
			$tables[] = 'thread';
			$joinConds['thread'] =
				array( 'left join',
					array( 'thread.thread_article_title=page.page_title',
						"thread.thread_modified > $cutoff" )
				);
		} elseif ( $sortField == 'ranking' ) {
			$tables[] = 'pagelinks';
			$joinConds['pagelinks'] = array( 'left join',
				array( 'pl_namespace=page_namespace', 'pl_title=page_title' ) );
			$fields[] = 'count(distinct pl_from) as value';
		} elseif ( $sortField == 'members' ) {
			$tables[] = 'pagelinks';
			$joinConds['pagelinks'] = array( 'left join',
				array( 'pl_from=page_id', 'pl_namespace' => NS_USER ) );
			$fields[] = 'count(distinct pl_title) AS value';
		}

		$result = $db->select( $tables, $fields, $conds,
					__METHOD__, $options, $joinConds );

		$count = array();

		foreach( $result as $row ) {
			$number = $row->value;
			$taskForce = $lookup ? $lookup[$row->keyfield] : $row->keyfield;

			if (!$lookup && $args['type'] == 'proposal') {
				$title = Title::makeTitleSafe( 106, $taskForce );
				$taskForce = $title->getPrefixedText();
			}

			if ( isset( $count[$taskForce] ) ) {
				$count[$taskForce] += $number;
			} elseif ( $number > 0 ) {
				$count[$taskForce] = $number;
			}
		}

		foreach( $count as $taskForce => $number ) {
			if ( $number > 0 ) {
				$html .= self::formatResult( $sk, $taskForce, $number, $sortField, $args['type'] );
			}
		}

		$html = Xml::tags( 'div', array( 'class' => 'mw-activestrategy-output' ),
				$html );

		return $html;
	}

	static function handleSortByMembers( $taskForces ) {
		global $wgUser;

		$memberCount = array();
		$output = '';
		$sk = $wgUser->getSkin();

		foreach( $taskForces as $row ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			$memberCount[$row->tf_name] =
				self::getMemberCount( $title->getPrefixedText() );
		}

		asort( $memberCount );
		$memberCount = array_reverse( $memberCount );

		foreach( $memberCount as $name => $count ) {
			if ( $count > 0 ) {
				$output .= self::formatResult( $sk, $name, $count, 'members' );
			}
		}

		$output = Xml::tags( 'div', array( 'class' => 'mw-activestrategy-output' ),
				$output );

		return $output;
	}

	static function getMemberCount( $taskForce ) {
		global $wgMemc;

		$key = wfMemcKey( 'taskforce-member-count', $taskForce );
		$cacheVal = $wgMemc->get( $key );

		if ( $cacheVal > 0 || $cacheVal === 0 ) {
			return $cacheVal;
		}

		$article = new Article( Title::newFromText( $taskForce ) );

		$dbr = wfGetDB( DB_SLAVE );

		$count = $dbr->selectField( 'pagelinks', 'count(*)',
				array( 'pl_from' => $article->getId(),
					'pl_namespace' => NS_USER ), __METHOD__ );

		$wgMemc->set( $key, $count, 86400 );

		return $count;
	}

	// FIXME THIS IS TOTALLY AWFUL
	static function parseMemberList( $text ) {
		$regex = "/'''Members'''.*<!--- begin --->(.*)?<!--- end --->/s";
		$matches = array();

		if ( !preg_match( $regex, $text, $matches ) ) {
			return -1;
		} else {
			$regex = "/^\* .*/m";
			$text = $matches[1];
			$matches = array();

			preg_match_all( $regex, $text, $matches );

			return count( $matches[0] );
		}
	}
}


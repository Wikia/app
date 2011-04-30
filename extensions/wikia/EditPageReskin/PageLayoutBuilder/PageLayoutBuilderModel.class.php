<?php

class PageLayoutBuilderModel {
	static $element_limits = 100;
	public static function getListOfLayout($list_db = DB_SLAVE){
//TODO: memc
		$db = wfGetDB($list_db, array());
		$res = $db->select('page_wikia_props',
			array('page_id'),
			array(
				'propname' => WPP_PLB_LAYOUT_DELETE,
			),
			__METHOD__
		);
		
		$deleted = array(0);
		while($row = $db->fetchRow($res)) {
			$deleted[] = $row["page_id"];
		}

		$res = $db->select('page_wikia_props',
			array('page_id'),
			array(
				'propname' => WPP_PLB_LAYOUT_NOT_PUBLISH,
			),
			__METHOD__
		);

		$not_publish = array(0);
		while($row = $db->fetchRow($res)) {
			$not_publish[$row["page_id"]] = $row["page_id"];
		}

		$db = wfGetDB(DB_SLAVE, array());
		
		$res = $db->select(
				array('page', 'revision', 'page_wikia_props', 'plb_page'),
				array(
					'page.page_title',
					'page.page_id',
					'revision.rev_timestamp',
					'revision.rev_user',
					'page_wikia_props.props',
					'count(plb_page.plb_p_page_id) as page_count',
				),
				array(
					'page_namespace' => NS_PLB_LAYOUT,
					"page.page_id not in (".implode(",", $deleted).")"
				),
				__METHOD__,
				array(
					'GROUP BY' => "page.page_id"
				),
				array( 
					'plb_page' => array('LEFT JOIN', 'page.page_id = plb_page.plb_p_layout_id'),
					'revision' => array('LEFT JOIN', 'page_latest=rev_id'),
					'page_wikia_props' => array('LEFT JOIN', 'page_wikia_props.page_id=page.page_id and page_wikia_props.propname = '.WPP_PLB_PROPS )
				)
		);


		$out = array();
		while($row = $db->fetchRow($res)) {
			$row['props'] = unserialize($row['props']);
			$row['desc'] =  $row['props']['desc'];
			$row['rev_user'] = User::newFromId($row['rev_user']);
			$row['not_publish'] = !empty($not_publish[$row['page_id']]);
			$out[] = $row;
		}

		return $out;
	}
	
	public static function saveArticle(Article $article, $body, $edittime, $summary = "" ) {
		global $wgOut, $wgUser, $wgContLang, $wgRequest, $wgCaptchaTriggers;

		$editPage = new EditPage( $article );
		$editPage->textbox1 = $body;
		$editPage->watchthis = true;
		$editPage->minoredit = false;
		$editPage->recreate = true;
		$editPage->summary = $summary;
		$editPage->edittime = $edittime;
		
		$result = false;
		$wgCaptchaTriggers = array();
		
		$status = $editPage->internalAttemptSave( $result, false );
		return $status;
	}

	public static function getProp($id, $dbname = '') {
		return wfGetWikiaPageProp(WPP_PLB_PROPS, $id, DB_SLAVE, $dbname);
	}

	public static function setProp($id, $value = array(), $dbname = '') {
		$out = wfGetWikiaPageProp(WPP_PLB_PROPS, $id, DB_MASTER, $dbname);
		if($out) {
			$value = $value + $out;
		}
		
		if(!empty($value['desc'])) {
			$value['desc'] = htmlspecialchars($value['desc']);
		}
		
		wfSetWikiaPageProp(WPP_PLB_PROPS, $id, $value);
		return $value;
	}

	public static function saveElementList( $layout_id, $elements) {
		$db = wfGetDB(DB_MASTER, array());

		if(!is_array($elements)) {
			$elements = array();
		}

		$db->begin();
		$inArray = array_keys($elements);
		$inArray[] = 0;
		$db->update("plb_field", array("plb_f_is_deleted" => 1),
				array(
					"plb_f_layout_id" => (int) $layout_id,
					"plb_f_element_id not in (".implode(",", $inArray).")"
				)
		);

		foreach($elements as $key => $value) {
			$inArray[] = (int) $key;
			$dbArray = array(
				'plb_f_prop' => serialize($value),
				'plb_f_layout_id'=> (int) $layout_id,
				'plb_f_element_id' => (int) $key,
				'plb_f_is_deleted' => 0
			);
			$db->replace("plb_field", "", $dbArray);
		}

		$db->commit();
	}
//TODO: memc
	public static function getElementList( $layout_id, $is_delete = 0) {
		$db = wfGetDB(DB_SLAVE, array());
		$res = $db->select(
				'plb_field',
				array(
					'plb_f_prop',
					'plb_f_element_id' ),
				array( 
					'plb_f_is_deleted' => (int) $is_delete,
					'plb_f_layout_id' => (int) $layout_id ),
				__METHOD__
		);

		$out = array();
		while($row = $db->fetchRow($res)) {
			$out[$row['plb_f_element_id']] = unserialize($row['plb_f_prop']);
			
		}
		return $out;
	}
//TODO: memc
	public static function getElement( $layout_id, $element_id, $is_delete = 0) {
		$db = wfGetDB(DB_SLAVE, array());
		$res = $db->select(
				'plb_field',
				array(
					'plb_f_prop',
					'plb_f_element_id' ),
				array( 
					'plb_f_element_id' => (int) $element_id,
					'plb_f_layout_id' => (int) $layout_id ),
				__METHOD__
		);
		
		$out = null;
		while($row = $db->fetchRow($res)) {
			$out = unserialize($row['plb_f_prop']);
		}
		
		return $out;
	}
//TODO: memec
	public static function articleIsFromPLB($page_id) {
		if($page_id == 0) {
			return false;
		}
		
		$db = wfGetDB(DB_SLAVE, array());
		$res = $db->select('plb_page',
			array('plb_p_layout_id'),
			array(
				'plb_p_page_id' =>  (int) $page_id,
			),
			__METHOD__
		);

		if($out = $db->fetchRow($res)) {
			return $out['plb_p_layout_id'];
		}

		return false;
	}
//TODO: memec
	public static function articleMarkAsPLB($page_id, $layout_id) {
		$db = wfGetDB(DB_MASTER, array());
		$db->insert("plb_page",
					array(
						'plb_p_layout_id' => (int) $layout_id,
						'plb_p_page_id' => (int) $page_id
					),
					__METHOD__,
					array("IGNORE")
		);
	}

	public static function articleUnmarkAsPLB($page_id) {
		$db = wfGetDB(DB_MASTER, array());
		$db->delete("plb_page", array('plb_p_layout_id' => (int) $page_id ));
	}
	
	public static function getLayoutForWikiCategory( $cat_ids = array() ) {
		$db = wfGetDB(DB_MASTER, array() );
	}

	public static function setCopyCatIds( $layout_id, $cat_ids) {
		global $wgDefaultLayoutWiki;
		PageLayoutBuilderModel::setProp( $layout_id, array( 'copy_cat_ids' => $cat_ids ), WikiFactory::IDtoDB( $wgDefaultLayoutWiki ) );	
	}
	
	public static function getCopyCatIds( $layout_id ) {
		global $wgDefaultLayoutWiki;
		$prop = PageLayoutBuilderModel::getProp( $layout_id, WikiFactory::IDtoDB( $wgDefaultLayoutWiki ) );
		if(empty($prop['copy_cat_ids'])) {
			return array();
		}
		return $prop['copy_cat_ids'];
	}
	
	public static function setLayoutCopy( $layout_id, $to_city_id  ) {
		global $wgExternalDatawareDB, $wgDefaultLayoutWiki;
		
		$from_city_id = $wgDefaultLayoutWiki;
	
		$db = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
		$db->insert("plb_copy_layout",
					array(
						'plb_c_layout_id' => (int) $layout_id,
						'plb_c_from_city_id' => (int) $from_city_id, 
						'plb_c_to_city_id' => (int) $to_city_id,
					),
					__METHOD__,
					array("IGNORE")
		);
		
		$db->commit();
	}
	
	public static function getLayoutsToCopy() {
		global $wgDefaultLayoutWiki;
		
		$dbname = WikiFactory::IDtoDB( $wgDefaultLayoutWiki );
		
		$db = wfGetDB(DB_MASTER, array(), $dbname);
		$res = $db->select(
			array('page'),
			array(
					'page.page_id',
				),
				array(
					'page_namespace' => NS_PLB_LAYOUT,
				)
		);

		$layoutsIds = array();
		while( $out = $db->fetchRow($res) ) {
			if( !self::layoutIsDelete($out['page_id']) ) {
				$toCopy = self::getCopyCatIds($out['page_id']);
				if(!empty($toCopy)) {
					$layoutsIds[ $out['page_id'] ] = $toCopy;	
				}
			}
		}
 
		return $layoutsIds;
	}

	public static function getLayoutCopyInfo($id) {
		global $wgDefaultLayoutWiki;
		$dbname = WikiFactory::IDtoDB( $wgDefaultLayoutWiki );
		
		if(self::layoutIsDelete( $id, $dbname )) {
			return false;
		}
		
		$title = GlobalTitle::newFromId( $id, $wgDefaultLayoutWiki );
		$url = self::getRequestUrl($title->getFullURL("action=raw"));
		$prop = self::getProp($id, $dbname);
		
		return array(
			"desc" => empty($prop['desc']) ? '':$prop['desc'],
			"text" => HTTP::get( $url ),
			"title" => $title->getText()
		);
	}
	
	
	private static function getRequestUrl($url) {
		global $wgDevelEnvironment;
		
		if (!empty($wgDevelEnvironment)) {
			$url = str_replace('wikia.com','tomek.wikia-dev.com',$url);
		}
		return $url;
	}
		
	
	public static function layoutMarkAsDelete($layout_id) {
		if(self::layoutIsDelete($layout_id)) {
			return null;
		}
		$title = Title::newFromID($layout_id);
		
		if(empty($title)) {
			return null;
		}
		
		if($title->getNamespace() == NS_PLB_LAYOUT) {
			$db = wfGetDB(DB_MASTER, array());
			//* rename it to prevent title validation problem */
			$db->query("update page set page_title = CONCAT(page_title, '-', page_id) where page_id = ".((int) $title->getArticleId()));	
			$db->commit();			
			return wfSetWikiaPageProp(WPP_PLB_LAYOUT_DELETE, $layout_id, 1);
		}
		return null;
	}

	public static function layoutMarkAsNoPublish($layout_id) {
		return wfSetWikiaPageProp(WPP_PLB_LAYOUT_NOT_PUBLISH, $layout_id, 1);
	}

	public static function layoutUnMarkAsNoPublish($layout_id) {
		return wfDeleteWikiaPageProp(WPP_PLB_LAYOUT_NOT_PUBLISH, $layout_id);
	}

	public static function layoutIsDelete($layout_id, $dbname = '') {
		return wfGetWikiaPageProp(WPP_PLB_LAYOUT_DELETE, $layout_id, DB_SLAVE, $dbname) == 1;
	}
	
	public static function layoutIsNoPublish($layout_id) {
		return wfGetWikiaPageProp(WPP_PLB_LAYOUT_NOT_PUBLISH, $layout_id) == 1;
	}
}
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
			$row['desc'] = $row['props']['desc'];
			$row['rev_user'] = User::newFromId($row['rev_user']);
			$row['not_publish'] = !empty($not_publish[$row['page_id']]);
			$out[] = $row;
		}

		return $out;
	}


	public static function saveArticle(Article $article, $body, $summary = "" ) {
		global $wgOut, $wgUser, $wgContLang, $wgRequest, $wgCaptchaTriggers;

		$editPage = new EditPage( $article );
		$editPage->textbox1 = $body;
		$editPage->watchthis = true;
		$editPage->minoredit = false;
		
		$editPage->summary = $summary;
		
		if(empty($summary)) {
			$editPage->summary =  wfMsgForContent('plb-create-summary-updated');
		}

		$result = false;
		$wgCaptchaTriggers = array();
		$status = $editPage->internalAttemptSave( $result, false );
		return $status;
	}

	public static function getProp($id) {
		return wfGetWikiaPageProp(WPP_PLB_PROPS, $id);
	}

	public static function setProp($id, $value = array()) {
		$out = wfGetWikiaPageProp(WPP_PLB_PROPS, $id);
		if($out) {
			$value = $value + $out;
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

//TODO: memec
	public static function articleIsFromPLB($page_id) {
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

	public static function layoutMarkAsDelete($layout_id) {
		return wfSetWikiaPageProp(WPP_PLB_LAYOUT_DELETE, $layout_id, 1);
	}

	public static function layoutMarkAsNoPublish($layout_id) {
		return wfSetWikiaPageProp(WPP_PLB_LAYOUT_NOT_PUBLISH, $layout_id, 1);
	}

	public static function layoutUnMarkAsNoPublish($layout_id) {
		return wfDeleteWikiaPageProp(WPP_PLB_LAYOUT_NOT_PUBLISH, $layout_id);
	}

	public static function layoutIsDelete($layout_id) {
		return wfGetWikiaPageProp(WPP_PLB_LAYOUT_DELETE, $layout_id) == 1;
	}
	
	public static function layoutIsNoPublish($layout_id) {
		return wfGetWikiaPageProp(WPP_PLB_LAYOUT_NOT_PUBLISH, $layout_id) == 1;
	}
}
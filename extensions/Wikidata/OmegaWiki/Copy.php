<?php

# (C) 2007  Alan Smithee  (licensed under the GPL v. 2, GPL v. 3 or any later version, though you're not likely to care)
# Copy library to copy defined meanings between tables.
# Based on the util/copy.php throwaway. 
#
# Not the greatest code ever written, but will have to live with it for now
#
# common abbreviations used in varnames and comments:
# dm = defined meaning. 
# dmid = defined meaning id: unique identifier for each dm.
# dc = dataset context. datasets are implemented by having
#			tables with different prefixes
# dc1 = dataset (context) 1 (we are copying FROM dc1 (so we READ) )
# dc2 = dataset (context) 2 (we are copying TO dc2 (so we WRITE) ) 
# 
# naming conventions (may deviate slightly from current conventions document):
# Normal: Java Style  
#	* ClassName->methodName($variableName); /* comment */
#	* CopyTools::getRow(...); # comment
# Wrappers around PHP functions or extensions to PHP function set: Same style as the wrapped function
#	* mysql_insert_assoc(...); # comment
# Variables that coincide with database columns: Same style as column
#	* $object_id
#	* $defined_meaning_id
#	$ $attribute_mid
#
# TODO:
# * Change to library
# * some read/write/dup functions are still main namespace, should get their own
# * classes (!!)

# How to use:
#
# Step 1:
# Set up one of those fancy wikidata transactions on dc2
# Don't have one? CopyTools::newCopyTransaction($dc1, $dc2) is your friend
#
# Step 2:  
# copy
# $copier=new DefinedMeaningCopier($dmid, $dc1, $dc2);
# $copier->dup()
# 
# et voila!
#
# Optional 1:
# dup()ing  something will return the new id.
# so ie you can get the dmid (defined meaning id) in dc2 (the
# destination dataset) with:
# $newDmid=$copier->dup();
# 
# note that if something is already copied, no new
# copy is made, but dup() will still return the appropriate
# new id.
# 
# This behaviour is only true for singular items (like defined meanings).
# O classes that duplicate entire sets of items at once, the dup method
# currently returns nothing. Logically it should really return an array,
# but I haven't really found anything that needs that yet, so haven't
# made an effort.
#
# Optional 2:
# If you attempt to dup something that was already there, nothing will
# happen, the item will not be dupped and the already_there flag will be set.
#  Querying $something->already_there() will return true in that case. 
#
# TWarning on testing:
# so far I've only tested this thoroughly where DefinedMeaningCopier is the entry point.
# In all other cases: YMMV, HTH, HAND. 
# (we so need unit testing ^^;;)

#require_once("../../../StartProfiler.php");
#include_once("../../../includes/Defines.php");
#include_once("../../../LocalSettings.php");
#require_once("Setup.php");
require_once("WikiDataAPI.php");
require_once("Transaction.php");

/** copies items in the objects table.
 * As a "side-effect" 
 * also conveniently reports  to see if something was already_there
 * (we don't want to accidentally duplicate things umpteen times, so the
 * side-effect is almost as important)
 */
class ObjectCopier {
	
	protected $id;
	protected $dc1;
	protected $dc2;
	protected $object;
	protected $already_there=null;
	protected $autovivify=false; # tradeoff: create object references if not found,
					# but catch less errors
	protected $tableName;

	function getId() {
		return $this->id;
	}

	function setTableName($tableName) {
		$this->tableName=$tableName;
	}

	/** 
	 * if can't find object in src (dc1) dataset,
	 * if set:  create said object now.
	 * if unset: throw exception.
	 * default: unset, because typically not finding
	 * the object we're looking for means something is
	 * very wrong. Some tables (like uw_collection_conte
	 */
	function setAutovivify($bool) {
		$this->autovivify=$bool;
	}

	function __construct($id, $dc1, $dc2) {
		$this->id=$id;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}

	function getObject() {
		return $this->object;
	}

	function setObject($object) {
		$this->object=$object;
	}

	/** return true if the object was already present in the other dataset*/
	public function already_there(){
		return $this->already_there;
	}

	protected function read() {
		$dc1=$this->dc1;
		$id=$this->id;
		if (is_null($dc1))
			throw new Exception("ObjectCopier: provided source dataset(dc1) is null");
		if (is_null($id))
			throw new Exception("ObjectCopier: provided identifier is null");

		$this->object=CopyTools::getRow($dc1, "objects", "WHERE object_id=$id");
	}

	/* tries to retrieve the identical UUID from the destination
	 * (dc2) dataset, if it exists.
	 * @returns the associative array representing this object,
	 *  if successful. Else returns an empty array.
	 */
	protected function identical() {
		$uuid=mysql_escape_string($this->object["UUID"]);
		if (is_null($uuid))
			throw new Exception("ObjectCopier: UUID is null");
		$dc2=$this->dc2;
		return CopyTools::getRow($dc2, "objects", "WHERE `UUID`='$uuid'");
	}

	/** Utility: provided with an id in dc1, return the equivalent id in dc2 */
	public  function getIdenticalId() {
		$destobject=$this->identical();
		return $destobject["object_id"];
	}

	/** Write copy of object into the objects table,taking into account
	 * necessary changes.
	 * possible TODO: Currently induces the target table from the original
	 * destination table name.
	 * Perhaps would be wiser to get the target table as an (override) parameter.
	 */
	function write($dc=Null) {

		if (is_null($dc)) {
			$dc = $this->dc2;
		}
		
		$object = $this->object;
		unset($object["object_id"]);

		$tableName_exploded = explode("_", $object["table"]);
		$tableName_exploded[0] = $dc;
		$tableName = implode("_", $tableName_exploded);
		$object["table"]=$tableName;

		CopyTools::dc_insert_assoc($dc,"objects",$object);
		return mysql_insert_id();
	}

	/** create a new objects table entry . 
	 * See also database schema documentation (insofar available) or
	 * do sql statement DESC <dc>_objects for table format (where <dc> is a valid
	 * dataset prefix) */
	function create_key($uuid=null) {
		if (is_null($this->tableName)) {
			throw new Exception("ObjectCopier: Object autovivification requires a table name to assist in creating an object. No table name was provided.");
		}
		$this->object["object_id"]=null; # just to be on some kind of safe side.
		$this->object["table"]="unset_".$this->tableName; # slightly hackish, this
		$this->object["original_id"]=0;	# no idea what this is for.

		if (is_null($uuid)) {
			$uuid_query=CopyTools::doQuery("SELECT UUID()");
			$uuid=$uuid_query["UUID()"];
		}
		$this->object["UUID"]=$uuid;
		$this->id=$this->write($this->dc1);
		return $this->id;
	}
	
	/** 
	 * create a valid object key in the objects table, and return it
	 * @param $dc	the dataset (prefix) to create the object in
	 * @param $table	which table is the object originally from? (minus dataset prefix)
	 * @param $uuid  (optional) : override the auto-generated uuid with this one.
	 */
	public static function makeObjectId($dc, $table, $uuid=null) {
		# Sorta Exploiting internals, because -hey- we're internal
		# don't try this at home kids. 
		# probably this would be tidier if the non-static method called
		# the static one, or something. We only really need
		# create_key(), so only filling in the data that that method needs.
		$objectCopier=new ObjectCopier(null, $dc, null);
		$objectCopier->setTableName($table);
		return $objectCopier->create_key($uuid);
	}

	/** Duplicate thds object ientry in the destination (dc2) dataset
	 */
	public function dup() {
		if (is_null($this->id)) {
			if ($this->autovivify) {
				$this->create_key();
			} else {
				throw new Exception("ObjectCopier: provided id is null");
			}
		}
	
		$this->read();
		if (!CopyTools::sane_key_exists("object_id", $this->object)) {
			if ($this->autovivify) {
				$this->create_key();
			} else {
				$id=$this->id;
				$table=$this->object["table"];
				if (is_null($table)) 
					$table=$this->tableName;
				$dc1=$this->dc1;
				throw new Exception("ObjectCopier: Could not find object information for object with id '$id' stored in `$table` in the objects table with prefix '$dc1'");
			}
		}

		$object2=$this->identical();
		if (CopyTools::sane_key_exists("object_id",$object2)) {
			$this->already_there=true;
			$newid=$object2["object_id"];
		} else {
			$this->already_there=false;
			$newid=$this->write();
		}
		AttributeCopier::copy($this->dc1, $this->dc2, $this->object["object_id"], $newid);
		return $newid;
	}
}


/** obtain an expression definition from the database
 * @param $expression_id	the id of the expression
 * @param $dc1			dataset to READ expression FROM
 */
function expression($expression_id, $dc1) {
	return CopyTools::getRow($dc1, "expression", "WHERE expression_id=$expression_id", true);
}


function getOldSyntrans($dc1, $dmid, $expid) {
	return CopyTools::getRow($dc1, "syntrans", "where defined_meaning_id=$dmid and expression_id=$expid", true);
}

function writeSyntrans($syntrans, $newdmid, $newexpid, $dc2) {
	$syntrans["defined_meaning_id"]=$newdmid;
	$syntrans["expression_id"]=$newexpid;
	CopyTools::dc_insert_assoc($dc2,"syntrans",$syntrans);
}	

function dupSyntrans($dc1, $dc2, $olddmid, $oldexpid, $newdmid, $newexpid) {
	$syntrans=getOldSyntrans($dc1, $olddmid, $oldexpid);
	$copier=new ObjectCopier($syntrans["syntrans_sid"], $dc1, $dc2);
	$newid=$copier->dup();
	if ($copier->already_there()) {
		return;
	}
	$syntrans["syntrans_sid"]=$newid;
	writeSyntrans($syntrans, $newdmid, $newexpid, $dc2);
}

function get_syntranses($dmid, $dc1) {
	return CopyTools::getRows($dc1, "syntrans", "where defined_meaning_id=$dmid",true);
}


/* some coy&paste happening here, might want to tidy even before we
* toss this throwaway code*/
function write_expression($expression, $src_dmid, $dst_dmid, $dc1, $dc2) {

	$copier=new ObjectCopier($expression["expression_id"], $dc1, $dc2);
	$target_expid1=$copier->dup();
	$save_expression=$expression;
	$save_expression["expression_id"]=$target_expid1;
	if  (!($copier->already_there())) {
		CopyTools::dc_insert_assoc($dc2,"expression",$save_expression);
	}
	dupSyntrans(
		$dc1,
		$dc2,
		$src_dmid,
		$expression["expression_id"],
		$dst_dmid,
		$save_expression["expression_id"]
	);
	return $target_expid1;

}

function write_syntranses($syntranses, $src_dmid, $dst_dmid, $dc1, $dc2) {
	foreach ($syntranses as $syntrans) {
		$expression=expression($syntrans["expression_id"],$dc1);
		write_expression($expression, $src_dmid, $dst_dmid, $dc1, $dc2);
		# ^- which incidentally also dups the syntrans
	}
}

function dup_syntranses($src_dmid, $dst_dmid, $dc1, $dc2) {
	$syntranses=get_syntranses($src_dmid, $dc1);
	write_syntranses($syntranses, $src_dmid, $dst_dmid, $dc1, $dc2);
}

function read_translated_content($dc1,$tcid) {
	return CopyTools::getRows($dc1,"translated_content","where translated_content_id=$tcid", true);
}

function write_translated_content($dc1, $dc2, $tcid, $content) { 
	$content["translated_content_id"]=$tcid;
	$content["text_id"]=dup_text($dc1, $dc2, $content["text_id"]);
	CopyTools::dc_insert_assoc($dc2, "translated_content", $content);
}


/**
 * duplicate translated content
 * TODO: actually make a translated content class
 * XXX: Warning: in the case of a tcid of 0 (almost certainly
 *      a bug), this problem is silently dropped, due to 
 *      possible issues with UMLS
 */
function dup_translated_content($dc1, $dc2, $tcid) {
	if (is_null($dc1))
		throw new Exception ("dup_translated_content: dc1 is null");

	if (is_null($dc2))
		throw new Exception ("dup_translated_content: dc2 is null");

	if (is_null($tcid))
		throw new Exception ("dup_translated_content: tcid is null");
	/* XXX UMLS problem? Knewcode tickets #258, #330 
	 *12 oct 2007, wikitestserver
	 * mysql> select count(*) from umls_defined_meaning where meaning_text_tcid=0;
	 * +----------+
	 * | count(*) |
	 * +----------+
	 * |   924247 | 
	 * +----------+
	 * 1 row in set (1.71 sec)
         *
	 * fix-ish below, currently no warning on this.
	 * Note that this DOES introduce the same breakage into the
	 * community dataset. 
	 * TODO: Figure a way to elegantly "heal" data as it is being copied instead.
	 */
	if ($tcid==0) {
		return 0;	
	}

	$translated_content=read_translated_content($dc1, $tcid);
	$copier=new ObjectCopier($tcid, $dc1, $dc2);
	$copier->setTableName("translated_content");
	$new_tcid=$copier->dup();
	# note the issue where translated content is added later:
	# since all translated content for a single dm 
	# shares one UUID, we can't check for that eventuality.
	if ($copier->already_there()) {
		return $new_tcid;
	}
	foreach ($translated_content as $item) {
		write_translated_content($dc1, $dc2, $new_tcid, $item);
	}
	return $new_tcid;
}

function read_text($dc1,$text_id) {
	return CopyTools::getRow($dc1,"text","where text_id=$text_id");
}

function write_text($dc2,$text) {
	unset($text["text_id"]);
	CopyTools::dc_insert_assoc($dc2, "text", $text);
	return mysql_insert_id();
}

function dup_text($dc1, $dc2, $text_id) {
	$text=read_text($dc1, $text_id);
	$id=write_text($dc2, $text);
	return $id;
}

class RelationsCopier extends Copier {

	protected $old_dmid;
	protected $new_dmid;
	protected $dc1;
	protected $dc2;
	protected $tableName="meaning_relations";

	function __construct($dc1, $dc2, $old_dmid, $new_dmid) {
		$this->old_dmid=$old_dmid;
		$this->new_dmid=$new_dmid;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}

	function read() {
		$dc1=$this->dc1;
		$dmid=$this->old_dmid;
		return CopyTools::getRows($dc1,$this->tableName,"where meaning1_mid=$dmid", true);
	}

	function write_single($relation) {
		$new_dmid=$this->new_dmid;

		if ($this->doObject($relation, "relation_id")) 
			return $relation["relation_id"];

		$relation["meaning1_mid"]=$new_dmid;
		$this->doDM($relation,"meaning2_mid");
		$this->doDM($relation,"relationtype_mid");

		$this->doInsert($relation);
		return $relation["relation_id"];
	}

	function dup() {
		$rows=$this->read();
		foreach ($rows as $row) {
			$this->write_single($row);
		}
	}			
}

/** copies collections 
 * TODO:
 * possibly *_definition should actually be in a different class.
 */
class CollectionCopier extends Copier {
	protected $dmid;
	protected $save_dmid;
	protected $dc1;
	protected $dc2;
	protected $already_there=false;
	protected $autovivifyObjects=true;
	protected $tableName="collection_contents";

	public function already_there() {
		return $this->already_there;
	}
	
	public function __construct ($dc1, $dc2, $dmid, $save_dmid) {
		$this->dmid=$dmid;
		$this->save_dmid=$save_dmid;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}

	public function read($dc=Null){
		if (is_null($dc)) {
			$dc=$this->dc1;
		}
		$dmid=$this->dmid;
		return CopyTools::getRows($dc, "collection_contents", "WHERE member_mid=$dmid", true);
	}


	public function read_definition($collection_id) {
		$dc1=$this->dc1;
		return CopyTools::getRow($dc1,"collection","WHERE collection_id=$collection_id", true);
	}

	/** write collection definition (and associated dm) to dc2
	 * if it doesn't already exist.
	 * If it already exists, will only look up the id.
	 * returns the  id for dc2 either way.
	 */
	public function write_definition($definition){
		$dc1=$this->dc1;
		$dc2=$this->dc2;
		
		$objcopier=new ObjectCopier($definition["collection_id"], $dc1, $dc2);
		$definition["collection_id"]=$objcopier->dup();

		if (!$objcopier->already_there()) {
			$dmid= $definition["collection_mid"];
			$dmcopier=new DefinedMeaningCopier($dmid,$dc1,$dc2);
			$definition["collection_mid"]=$dmcopier->dup_stub();

			CopyTools::dc_insert_assoc($dc2, "collection", $definition);

		}
		return $definition["collection_id"];

	}
	
	/** look up the collection definition in %_collection, 
	 * and copy if doesn't already exist in dc2 
	 */
	public function dup_definition($collection_id) {
		$definition=$this->read_definition($collection_id);
		
		return $this->write_definition($definition);
	}


	# we create a mapping and THEN do collections, now we need to prevent ourselves dupping 
	# existing mappings
	# @deprecated
	public function existing_mapping($member_id) {
		$dc2=$this->dc2;
		$query="SELECT ${dc2}_collection_contents.* FROM ${dc2}_collection_contents, ${dc2}_collection
			WHERE ${dc2}_collection_contents.collection_id = ${dc2}_collection.collection_id
			AND collection_type=\"MAPP\" 
			AND internal_member_id=\"${member_id}\"";
		$mapping_here=CopyTools::doQuery($query);

		if ($mapping_here==false)
			return false;
		else
			return true; # if anything is actually returned, we know the score.
	}


	/** write a single collection_contents row,
	 * (if the collection doesn't exist yet), also dup the definition
	 */
	public function write_single($row){
		$srcrow=$row;
		$dc2=$this->dc2;
		$save_dmid=$this->save_dmid;
		$row["collection_id"]=$this->dup_definition($row["collection_id"]);

		if ($this->doObject($row, "object_id")) {
			$this->already_there=true;
			return $row["object_id"];
		}
		
		if (is_null($srcrow["object_id"])) {
			$srcrow["object_id"]=$this->objectCopier->getId();
			$collection_id=$srcrow["collection_id"];
			$member_mid=$srcrow["member_mid"];
			$where="WHERE collection_id=$collection_id AND member_mid=$member_mid";
			CopyTools::dc_update_assoc(
				$this->dc1, 
				$this->tableName, 
				$srcrow, 
				$where);
		}

		$row["member_mid"]=$save_dmid;
		CopyTools::dc_insert_assoc($dc2, $this->tableName, $row);
	}

	public function write($rows){
		foreach ($rows as $row) {
			$this->write_single($row);
		}
	}

	/** writes a duplicate. does *NOT* return ids on return, as there
	 * are multiple ids 
	 */
	public function dup() {
		$rows=$this->read($this->dc1);
		$this->write($rows);
	}
}
	

class DefinedMeaningCopier {

	protected $defined_meaning;
	protected $save_meaning;
	protected $dmid;
	protected $dc1;
	protected $dc2;
	protected $already_there=false;
	
	public function __construct ($dmid, $dc1, $dc2) {
		#echo "D$dmid; ";
		$this->dmid=$dmid;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}
	
	protected function read() {
		$dmid=$this->dmid;
		if (is_null($dmid))
			throw new Exception ("DefinedMeaningCopier: read(): cannot read a dmid that is null");
		if (is_null($this->dc1))
			throw new Exception ("DefinedMeaningCopier: read(): cannot read from dc1: is null. ");
		$this->defined_meaning=CopyTools::getRow($this->dc1,"defined_meaning","where defined_meaning_id=$dmid", true);
		return $this->defined_meaning; # for convenience
	}


	public function getDM() {
		$dm=$this->defined_meaning;
		if (is_null($dm)) {
			$dm=$this->read();
		}
		return $this->defined_meaning;
	}

	public function already_there() {
		return $this->already_there;
	}

	/** duplicate the entire defined meaning, including all relations.
	 * WARNING: relations are also defined meanings, so you can end up with a
	 * runaway recursion. Use the safer dup_stub anywhere you can get away with it.
	 */
	public	function dup() {
		$this->dup_stub();
		$this->dup_rest();
		return $this->save_meaning["defined_meaning_id"];
	}


	/** duplicate a basic defined meaning, translated text, and syntrans
	 * this is relatively old code by now, and can probably be tidied/refactored
	 * use dup_rest to duplicate everything else.
	 *
	 * There is/should be no risk of a stub copy leading to a runaway recursion
	 */
	public function dup_stub (){
		$dmid=$this->dmid;
		$dc1=$this->dc1;
		$dc2=$this->dc2;

		$this->read();

		# bit of exp here too (defnitely need to tidy)
		$defining_expression=expression($this->defined_meaning["expression_id"], $dc1);

		# is it already mapped?

		$target_dmid=$this->getMappedId();

		# no?
		if (!$target_dmid) {
			$copier=new ObjectCopier($this->defined_meaning["defined_meaning_id"], $dc1, $dc2);
			$target_dmid=$copier->dup();
			$this->already_there=$copier->already_there();
		} else { #yes? # and no, we  weren't advertising merging, so you're outta luck :-P
			$this->already_there=true;
		}

		#test code only:
		#$spelling=$defining_expression["spelling"];
		#echo "$spelling, ";
		
		# now something potentially useful?
		#echo "->$dc2:$target_dmid";

		
		#echo".  ";
		#end test code;
		
		$this->save_meaning=$this->defined_meaning;
		$this->save_meaning["defined_meaning_id"]=$target_dmid;

		
		if (!($this->already_there)) {
			$this->save_meaning["expression_id"]=write_expression($defining_expression, $dmid, $target_dmid, $dc1, $dc2);
		}
		$this->save_meaning["meaning_text_tcid"]=dup_translated_content($dc1, $dc2, $this->defined_meaning["meaning_text_tcid"]);
		if (!($this->already_there)) {
			CopyTools::dc_insert_assoc($dc2, "defined_meaning", $this->save_meaning);

			$title_name=$defining_expression["spelling"];
			$title_number=$target_dmid;
			$title=str_replace(" ","_",$title_name)."_(".$title_number.")";
			CopyTools::createPage($title);
		
			$concepts=array(
				$dc1 => $this->defined_meaning["defined_meaning_id"],
				$dc2 => $this->save_meaning["defined_meaning_id"]);
			$uuid_data=createConceptMapping($concepts, getUpdateTransactionId());
			DefinedMeaningCopier::finishConceptMapping($dc1, $uuid_data[$dc1]);
			DefinedMeaningCopier::finishConceptMapping($dc2, $uuid_data[$dc2]);
		}
		
		return $this->save_meaning["defined_meaning_id"];
	}		

	/** if there is an existing conceptmapping for this dm, return the provided id, else return false
	 */
	public function getMappedId() {
		$dmid=$this->dmid;
		$dc1=$this->dc1;
		$dc2=$this->dc2;
		$map=getAssociatedByConcept($dmid,$dc1);
		$dst_dmid=$map[$dc2];

		return ($dst_dmid>0) ? $dst_dmid : null;
	}


	public static function finishConceptMapping($dc, $uuid) {
		if ($uuid==-1){  #CreateConceptMapping did not create a new mapping,
			return; # You can't finish that which was never started.
		}
		$object_id=ObjectCopier::makeObjectID($dc, "collection_contents", $uuid);
		CopyTools::doQuery("	UPDATE ${dc}_collection_contents 
					SET object_id=$object_id
					WHERE internal_member_id=\"$uuid\"
					");
	}

	/** duplicate everything else (that was not yet done by the stub
	 * copy) so that we have a full copy of this defined meaning
	 *
	 * Is only called by dup(), after a call to  dup_stub()
	 * 
	 * it is possible to cause a runaway recursion with this function, 
	 * hence most of Copy.php calls dup_stub() instead of dup() 
	 */
	protected function dup_rest() {
		$dmid=$this->dmid;
		$dc1=$this->dc1;
		$dc2=$this->dc2;

		dup_syntranses(
			$this->defined_meaning["defined_meaning_id"],
			$this->save_meaning["defined_meaning_id"],
			$dc1,
			$dc2
		);
		

		$relationsCopier=new RelationsCopier(
			$dc1, 
			$dc2, 
			$this->defined_meaning["defined_meaning_id"],
			$this->save_meaning["defined_meaning_id"]);
		$relationsCopier->dup();
		
		$collectionCopier=new CollectionCopier(
			$dc1, 
			$dc2, 
			$this->defined_meaning["defined_meaning_id"],
			$this->save_meaning["defined_meaning_id"]);
		$collectionCopier->dup();

		$classMembershipCopier=new ClassMembershipCopier(
			$dc1, 
			$dc2, 
			$this->defined_meaning["defined_meaning_id"],
			$this->save_meaning["defined_meaning_id"]);
		$classMembershipCopier->dup();

		global $wdCopyAltDefinitions;
		if (!$this->already_there && $wdCopyAltDefinitions) {
			$altMeaningTextCopier=new AltMeaningTextCopier(
				$dc1,
				$dc2,
				$this->defined_meaning["defined_meaning_id"],
				$this->save_meaning["defined_meaning_id"]);
			$altMeaningTextCopier->dup();
		}
	}
}
	
/** provide a namespace for copying tools (so we don't clutter up the main namespace with
 * all our utility and tool functions) All functions here are public+static.
 */
class CopyTools {
	/** create a relevant entry in the `page` table. */
	public static function createPage($title) {
		# page is not a Wikidata table, so it needs to be treated differently (yet again :-/)
		$escTitle=mysql_real_escape_string($title);
		$existing_page_data=CopyTools::doQuery("SELECT * FROM page WHERE page_namespace=24 AND page_title=\"$escTitle\"");
		if ($existing_page_data==false) {
			$pagedata=array("page_namespace"=>24, "page_title"=>$title);
			CopyTools::mysql_insert_assoc("page",$pagedata);
		}
	}

	/**
	 * @returns: null if not a stub
	 *           else an array(original_dataset=>..., original_id=>...) 
	 */
	public static function checkIfStub($dataset,$id) {
		$dmcopier=new DefinedMeaningCopier($id, $dataset, null);
		$dm1=$dmCopier->read();
		if (is_null($dm1)) 
			throw new Exception("Could not find a defined meaning with id '$id' in dataset '$dataset'");
		$original_dataset=$dm1["stub"];

		if (is_null($original_dataset))
			return null;

		$obcopier=new ObjectCopier($id, $dataset, $original_dataset);
		$original_id=$obcopier->getIdenticalId();
		
		if (is_null($original_id)) 
			throw new Exception("CopyTools::checkIfStub: Database integrity failed: item marked as stub, but no original entry found.");

		$rv=array();
		$rv["original_dataset"]=$original_dataset;
		$rv["original_id"]=$original_id;
		return $rv;

	}

	/** Times our execution time, nifty! */
	public static function stopwatch(){
	   list($usec, $sec) = explode(" ", microtime());
	   return ((float)$usec + (float)$sec);
	}

	/** start a new copy transaction
	 * Gets a virtual user id from the wikidata_sets table, if available
	 * (else uses user 0)
	 * There's still some issues with transactions  especially wrt with user assignment
	 * where we intersect with the (old) "WikiDataAPI".
	 */
	public static function newCopyTransaction($dc1, $dc2) {

		$datasets=CopyTools::getRow_noDC("wikidata_sets", "WHERE set_prefix=\"$dc1\"");
		if (  $datasets == false  ) {
			throw new Exception("Dataset info for $dc1 not found.");
		}
		
		if (  array_key_exists("virtual_user_id", $datasets)  ) {
			$virtual_user_id=$datasets["virtual_user_id"];
		} else {
			$virtual_user_id=0;
		}
	
		# The id might exist, but still be null. 
		if (is_null($virtual_user_id)) {
			$virtual_user_id=0;
		}

		startNewTransaction(
			$virtual_user_id, 
			"0.0.0.0", 
			"copying from $dc1 to $dc2", 
			$dc2	);
	}

	/** retrieve a single row from the database as an associative array
	 * @param $dc		the dataset prefix we need
	 * @param $table	the name of the table (minus dataset prefix)
	 * @peram $where		the actual WHERE clause we need to uniquely find our row
	 * @returns an associative array, representing our row. \
	 *	keys=column headers, values = row contents
	 */
	public static function getRow($dc, $table, $where, $checkremove=false) {
		$target_table=mysql_real_escape_string("${dc}_${table}");
		$query="SELECT * FROM $target_table ".$where;
		if ($checkremove)
			$query .= " AND remove_transaction_id IS NULL";
		return CopyTools::doQuery($query);
	}

	/** same as getRow, except does not use dataset context
	 * transactioning is only for prefixed tables, so no checkremove..
	 */
	public static function getRow_noDC($table, $where) {
		$target_table=mysql_real_escape_string("${table}");
		$query="SELECT * FROM $target_table ".$where;
		return CopyTools::doQuery($query);
	}

	/** retrieve multiple rows from the database, as an array of associative arrays.
	 * @param $dc		the dataset prefix we need
	 * @param $table	the name of the table (minus dataset prefix)
	 * @peram $where		the actual WHERE clause we need to uniquely find our row
	 * @returns an array of associative arrays, representing our rows.  \
	 *	each associative array is structured with:		\
	 *	keys=column headers, values = row contents
	 */
	public static function getRows($dc, $table, $where, $checkremove=false) {
		$target_table=mysql_real_escape_string("${dc}_${table}");
		$query="SELECT * FROM $target_table ".$where;
		if ($checkremove)
			$query .= " AND remove_transaction_id IS NULL";
		return CopyTools::doMultirowQuery($query);
	}

	/** utility function, maps bootstrapped defined meanings across multiple datasets. 
	 * @param $key_dataset: any dataset which has a known-good bootstrap table. We assume all others are the same.
	 * @param $datasets: an array with the datasets to map (eg: array("uw", "sp", "umls") ).
	*/
	public static function map_bootstraps($key_dataset, $datasets) {
		$bootstrap_raw=CopyTools::getRows($key_dataset,"bootstrapped_defined_meanings","");
		$bootstrap=CopyTools::_table_to_assoc($bootstrap_raw, "name", "defined_meaning_id");
		# only use the keys from the key dataset :-P
		foreach ($bootstrap as $name => $dmid_ignored) {
			$concepts=array();
			foreach ($datasets as $dataset) {
				$other_bootstrap_raw=CopyTools::getRows($dataset,"bootstrapped_defined_meanings","");
				$other_bootstrap=CopyTools::_table_to_assoc($other_bootstrap_raw, "name", "defined_meaning_id");
				$concepts[$dataset]=$other_bootstrap[$name];
			}
			createConceptMapping($concepts);
		}
	}

	/** Takes two 2 columns from getRows, and forms them into an associative array.
	 * @param $table	output from getRows
	 * @param $key_column	string, name of column to use as keys
	 * @param $value_column	string, name of column to use as values
	 * @return an associative array, made from teh 2 columns specified
	 */
	protected static function _table_to_assoc($table, $key_column, $value_column) {
		$assoc=array();
		foreach ($table as $item) {
			$assoc[ $item[$key_column] ]=$item[$value_column];	
		}
		return $assoc;
	}

	/** Performs an arbitrary SQL query and returns an associative array
	 * Assumes that only 1 row can be returned!
	 * @param $query	a valid SQL query
	 * @returns an associative array, representing our row. \
	 *	keys=column headers, values = row contents
	 *
	 */
	public static function doQuery($query) {
		#$start=CopyTools::stopwatch();
		$result = mysql_query($query);

		#echo CopyTools::stopwatch()-$start." "; var_dump($query);
		if (!$result) 
			throw new Exception("Mysql query failed: $query");

		if ($result===true) 
			return null;

		if (mysql_num_rows($result)==0) 
			return null;


		$data= mysql_fetch_assoc($result);
		return $data;
	}
	/** Perform an arbitrary SQL query
	 * 
	 * @param $query	a valid SQL query
	 * @returns an array of associative arrays, representing our rows.  \
	 *	each associative array is structured with:		\
	 *	keys=column headers, values = row contents
	 */

	public static function doMultirowQuery($query) {
		#$start=CopyTools::stopwatch();
		$result = mysql_query($query);
		if (!$result) 
			throw new Exception("Mysql query failed: $query");
		
		if ($result===true)
			return array();

		if (mysql_num_rows($result)==0) 
			return array();

		$items=array();
		while ($nextexp=mysql_fetch_assoc($result)) {
			$items[]=$nextexp;
		}
		#echo CopyTools::stopwatch()-$start." "; var_dump($query);
		return $items;
	}

	/** identical to the php function array_key_exists(), but eats dirtier input
	 * returns false (rather than an error) on somewhat invalid input. 
	 * (Namely, if either $key or $array is either null or false)
	 */
	public static function sane_key_exists($key, $array) {
		if (is_null($key) or $key==false){
			return false;
		}
		if (is_null($array) or $array==false) {
			return false;
		}
		return array_key_exists($key, $array);
	}

	/**
	 * inverse of mysql_fetch_assoc
	 * takes an associative array as parameter, and inserts data
	 * into table as a single row (keys=column names, values = data to be inserted)
	/* see: http://www.php.net/mysql_fetch_assoc (Comment by R. Bradly, 14-Sep-2006)
	 */
	public static function mysql_insert_assoc ($my_table, $my_array) {
		$start=CopyTools::stopwatch();
		
		// Find all the keys (column names) from the array $my_array

		// We compose the query
		$sql = "insert into `$my_table` set";
		// implode the column names, inserting "\", \"" between each (but not after the last one)
		// we add the enclosing quotes at the same time
		$sql_comma=$sql;
		foreach($my_array as $key=>$value) {
			$sql=$sql_comma;
			if (is_null($value)) {
				$value="DEFAULT";
			} else {
				$value='"'.mysql_real_escape_string($value).'"';
			}
			$sql.=" `$key`=$value";
			$sql_comma=$sql.",";
		}

		global $wdCopyDryRunOnly;	#skip writing to db
		if ($wdCopyDryRunOnly)
			return true;

		$result = mysql_query($sql);
		if (!$result) 
			throw new Exception("Mysql query failed: $sql , with error message: ".mysql_error());

		#echo CopyTools::stopwatch()-$start." "; var_dump($sql);
		if ($result)
			return true;
		else
			return false;
	}

	/** similar to mysql_insert_assoc, except now we do an update (naturally) */
	public static function mysql_update_assoc ($my_table, $my_array, $where) {

		#$start=CopyTools::stopwatch();
		// Find all the keys (column names) from the array $my_array

		// We compose the query
		$sql = "update `$my_table` set";
		// implode the column names, inserting "\", \"" between each (but not after the last one)
		// we add the enclosing quotes at the same time
		$sql_comma=$sql;
		foreach($my_array as $key=>$value) {
			if (!is_null($value)) {
				$sql=$sql_comma;
				$value='"'.mysql_real_escape_string($value).'"';
				$sql.=" `$key`=$value";
				$sql_comma=$sql.",";
			}
		}
		$sql .= " ".$where;

		global $wdCopyDryRunOnly;	#skip writing to db
		if ($wdCopyDryRunOnly)
			return true;

		$result = mysql_query($sql);

		if (!$result) 
			throw new Exception("Mysql query failed: $query , with error message: ".mysql_error());

		#echo CopyTools::stopwatch()-$start." "; var_dump($sql);
		if ($result)
			return true;
		else
			return false;
	}


	/**convenience wrapper around mysql_insert_assoc
	 * like mysql_insert_assoc, but allows you to specify dc prefix+table name separately
	 * Also transparently handles the internal transaction (WHICH MUST ALREADY BE OPEN!)
	 */
	public static function dc_insert_assoc($dc, $table_name, $array) {
		$target_table=mysql_real_escape_string("${dc}_${table_name}");
		if (CopyTools::sane_key_exists("add_transaction_id", $array)) {
			$array["add_transaction_id"]=getUpdateTransactionId();
		}
		return CopyTools::mysql_insert_assoc($target_table, $array);
	}
	
	public static function dc_update_assoc($dc, $table_name, $array, $where) {
		$target_table=mysql_real_escape_string("${dc}_${table_name}");
		if (CopyTools::sane_key_exists("add_transaction_id", $array)) {
			$array["add_transaction_id"]=getUpdateTransactionId();
		}
		return CopyTools::mysql_update_assoc($target_table, $array, $where);
	}

}

/**Copying uw_class_membership*/
class ClassMembershipCopier extends Copier{

	protected $old_class_member_mid;
	protected $new_class_member_mid;
	protected $dc1;
	protected $dc2;
	protected $tableName="class_membership";

	/** coming from the defined meaning(dm) we don't know the membership id,
	 * but we do have the dmid (defined meaning id) for the class member, so let's use that
	 */
	public function __construct($dc1, $dc2, $old_class_member_mid, $new_class_member_mid) {
		$this->old_class_member_mid=$old_class_member_mid;
		$this->new_class_member_mid=$new_class_member_mid;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}

	public function dup() {
		$memberships=$this->read();
		$this->write($memberships);
		
		return;
	}
		
	/** read all class memberships associated with the dmid */
	public function read() {
		$dc1=$this->dc1;
		$class_member_mid=$this->old_class_member_mid;
		return CopyTools::getRows($dc1, "class_membership", "WHERE class_member_mid=$class_member_mid", true);
	}

	public function write($memberships) {
		foreach ($memberships as $membership) {
			$this->write_single($membership);
		}
	}

	public function write_single($membership) { 
		$dc1=$this->dc1;
		$dc2=$this->dc2;
		$new_class_member_mid=$this->new_class_member_mid;
	
		$copier = new ObjectCopier($membership["class_membership_id"], $dc1, $dc2);
		$newid=$copier->dup();
		if ($copier->already_there()) {
			return $newid;
		}
		$membership["class_membership_id"]=$newid;
		$membership["class_member_mid"]=$new_class_member_mid;
		$oldmid=$membership["class_mid"];
		$this->doDM($membership,"class_mid", true);
		$newmid=$membership["class_mid"];
		$classAttributesCopier=new ClassAttributesCopier($oldmid, $newmid, $dc1, $dc2); 
		$classAttributesCopier->dup();
		CopyTools::dc_insert_assoc($dc2, "class_membership", $membership);
		return $newid;
	}

}

/** copying stuff in the %_class_attributes table actually
 * TODO: Actually I'm keying on class_mid atm, while I could be using the object_id-s
 * instead, the same way as the other AttributesCopiers.
 * I didn't realise this upfront. See ClassAttributesCopier2
 */
class ClassAttributesCopier extends Copier {
	
	protected $src_class_mid;
	protected $dst_class_mid;
	protected $dc1;
	protected $dc2;
	protected $tableName="class_attributes";

	/** you saw that right, class_mid, not class_id, there's no such thing :-/
	 */
	public function __construct($src_class_mid, $dst_class_mid, $dc1, $dc2) {
		$this->src_class_mid=$src_class_mid;
		$this->dst_class_mid=$dst_class_mid;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}

	/** unchracteristically, returns the new class_mid, rather than object_id
	 * because in this case, the class_mid is the key characteristic
	 */
	public function dup() {
		if (is_null($this->src_class_mid))
			throw new Exception ("ClassAttributesCopier: Can't copy class; is null!");
		$attributes=$this->read();
		$this->write($attributes);
		return $this->dst_class_mid; # XXX currently broken:  actually it'll return the src_class_mid...
	}
	
	public function read() {
		$dc1=$this->dc1;
		$class_mid=$this->src_class_mid;
		return CopyTools::getRows($dc1, "class_attributes", "WHERE class_mid=$class_mid", true);
	}

	public function write($attributes) {
		foreach ($attributes as $attribute) {
			$this->write_single($attribute);
		}
	}

	
	public function write_single($attribute) {
		$dc1=$this->dc1;
		$dc2=$this->dc2;
		$class_mid=$this->src_class_mid;


		if ($this->doObject($attribute,"object_id")) 
			return $attribute["object_id"];

		$attribute["class_mid"]=$this->dst_class_mid;
		$this->doDM($attribute,"level_mid");
		$this->doDM($attribute,"attribute_mid");

		CopyTools::dc_insert_assoc($dc2, "class_attributes", $attribute);

		return $attribute["object_id"];
	}

}

/** copying stuff in the %_class_attributes table 
 * This version keys on attribute_id (which is the object_id in the objects table)
 */
class ClassAttributesCopier2 extends Copier {
	
	protected $object_id;
	protected $dc1;
	protected $dc2;
	protected $tableName="class_attributes";

	/** you saw that right, class_mid, not class_id, there's no such thing :-/
	 */
	public function __construct($object_id, $dc1, $dc2) {
		$this->object_id=$object_id;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}

	/** unchracteristically, returns the new class_mid, rather than object_id
	 * because in this case, the class_mid is the key characteristic
	 */
	public function dup() {
		if (is_null($this->object_id))
			throw new Exception ("ClassAttributesCopier2: Can't copy class by object_id: is null!");
		$attributes=$this->read();
		return $this->write($attributes);
	}
	
	# refactor candidate?
	public function read() {
		$dc1=$this->dc1;
		$object_id=$this->object_id;
		return CopyTools::getRows($dc1, $this->tableName, "WHERE object_id=$object_id", true);
	}

	#refactor_candidate
	public function write($attributes) {
		$latest=null;
		foreach ($attributes as $attribute) {
			$latest=$this->write_single($attribute);
		}
		return $latest;
	}

	
	public function write_single($attribute) {
		$dc1=$this->dc1;
		$dc2=$this->dc2;
		
		# TODO: Check: Is *this* actually safe?
		if ($this->doObject($attribute,"object_id")) 
			return $attribute["object_id"];

		$this->doDM($attribute, "class_mid"); #safe to do here, though not in the first ver.
		$this->doDM($attribute, "level_mid");
		$this->doDM($attribute, "attribute_mid");

		CopyTools::dc_insert_assoc($dc2, "class_attributes", $attribute);

		return $attribute["object_id"];
	}

}




/** abstract superclass for copiers
 *  will gradually be implemented anywhere I create, refactor, or 
 */
abstract class Copier {

	protected $dc1; // Source dataset
	protected $dc2; // Destination dataset
	protected $tableName; 	//Name of the table this class operates on.
				// if multiple tables, name of whatever principle table.
	protected $autovivifyObjects=false; 	// false: throw an error if we find 
						// 	  null references to the objects table
						// true: instead, create a valid
						// 	entry in the objects table and
						//	do the correct referencing
						// see also: ObjectCopier::$autovivify
	protected $already_there=null;	// true:	item was already present in 
					//		destination (dc2) dataset. No copy made.
					// false:	item was not present. Copy made.
					// null:	don't know (yet) / error/ other
					// see also: ObjectCopier::$already_there
	protected $objectCopier;	// an objectCopier associated with this class
					// first gets set when doObject() is called

	/** does the actual copying
	 * @return the unique id for the item we just copied in the destination (dc2) dataset,
	 *         or null, if no such id exists in this case (for instance, if we copied multiple
	 *         items, there is no single unique id)
	 */
	public function dup() {
		$values=$this->read();
		return $this->write($values);
	}
	/** reads row or rows from table in source dataset (dc1) 
	 * @return row or array of rows for table in mysql_read_assoc() format */
	protected abstract function read();

	/** writes row or array of rows in mysql_read_assoc() format
	 * @return the unique id for the item we just copied in the destination (dc2) dataset,
	 *         or null, if no such id exists in this case (for instance, if we copied multiple
	 *         items, there is no single unique id)
	 */
	//public abstract function write();

	/** @returns true if the copied item was already present in the other dataset, false if it wasn't (and we just copied it over) , or null if don't know/error/other.
	 */
	public function already_there(){
		return $this->already_there;
	}

	protected function write($values) {
		$latest=null;
		foreach ($values as $value) {
			$latest=$this->write_single($value);
		}
		return $latest;
	}


	/**
	 * A combination function to handle all the steps needed to check
	 * and copy a Defined Meaning (DM)
	 * So we have a row in the source (dc1) table, which has a column
	 * referring to a defined meaning
	 * Before the row can be stored in the destination dataset, 
	 * we should
	 * - Ensure that at least a stub of this defined meaning exists
	 * - make sure that the row refers to the dmid in the *destination* dataset (dc2),
	 *   instead of the source dataset (dc1).
	 * - returns True if the defined meaning was already_there().
	 * @param &$row : row to operate on, passed by reference
	 * @param $dmid_colum: a column in said row, containing the dmid to operate on
	 * @param $full=false (optional) : if true, does a dup instead of a dup_stub
	 * @return true if the updated dmid already existed in the destination (dc2) dataset before now
	 *	   false if it did not, and we just created it
	 */
	protected function doDM(&$row, $dmid_column, $full=false) {
		if ($row[$dmid_column]==0 or is_null($row[$dmid_column]))
			return true;

		$dmCopier=new DefinedMeaningCopier($row[$dmid_column], $this->dc1, $this->dc2);
		if ($full) {
			$row[$dmid_column]=$dmCopier->dup();
		} else {
			$row[$dmid_column]=$dmCopier->dup_stub();
		}
		return $dmCopier->already_there();
	}

	/** 
	 * performs all the tasks to do with the column associated with
	 * the objects table in one go.
	 * 
	 * Assuming the row originally contains an object_id in the source dataset (dc1)
	 * updates the row(passed by reference) with the relevant object_id in the destination
	 *   dataset (dc2)
	 * 
	 * @param &$row : row to operate on, passed by reference
	 * @param $object_column: a column in said row, containing the object reference to operate on
	 * @returns 	true if examination of the objects table reveals that this particular row should already
	 *			exist in the destination dataset
	 *		false if this particular row does not yet exist in the table in the destination dataset. 
	 *			The objects table, and object reference
	 *			in your array have already been set correctly. Continue by filling in the rest
	 *			of the row data. (Do so before COMMIT).
	 *
	 * behaviour is modified by object properties $this->tableName and $this->autovivifyObjects.
	 */
	protected function doObject(&$row, $object_column) {
		$copier=new ObjectCopier($row[$object_column], $this->dc1, $this->dc2);
		$this->objectCopier=$copier;
		$copier->setTableName($this->tableName);
		$copier->setAutovivify($this->autovivifyObjects);
		$row[$object_column]=$copier->dup();
		$this->already_there=$copier->already_there();
		return $this->already_there;
	}

	protected function doInsert($row) {
		CopyTools::dc_insert_assoc($this->dc2, $this->tableName, $row);
	}

}


abstract class AttributeCopier extends Copier {

	protected $src_object_id=null;
	protected $dst_object_id=null;

	public function __construct($dc1, $dc2, $src_object_id, $dst_object_id){
		$this->dc1=$dc1;
		$this->dc2=$dc2;
		$this->src_object_id=$src_object_id;
		$this->dst_object_id=$dst_object_id;
	}


	public static function copy($dc1, $dc2, $src_object_id, $dst_object_id) {
		if (is_null($src_object_id)) 
			throw new Exception("AttributeCopier: cannot copy: source object_id=null");

		if (is_null($dst_object_id)) 
			throw new Exception("AttributeCopier: cannot copy: destination object_id=null");
		$optionAttributeCopier=new OptionAttributeCopier($dc1, $dc2, $src_object_id, $dst_object_id);
		$optionAttributeCopier->dup();

		$textAttributeCopier=new TextAttributeCopier($dc1, $dc2, $src_object_id, $dst_object_id);
		$textAttributeCopier->dup();

		$translatedContentAttributeCopier=new TranslatedContentAttributeCopier($dc1, $dc2, $src_object_id, $dst_object_id);
		$translatedContentAttributeCopier->dup();

		$urlAttributeCopier=new URLAttributeCopier($dc1, $dc2, $src_object_id, $dst_object_id);
		$urlAttributeCopier->dup();
	}
		
	protected function write($values) {
		$latest=null;
		foreach ($values as $value) {
			$latest=$this->write_single($value);
		}
		return $latest;
	}

	protected abstract function write_single($attribute);

	protected function read() {
		$src_object_id=$this->src_object_id;
		if (is_null($src_object_id)) 
			throw new Exception("*AttributeCopier: cannot read: source object_id is null");

		$tableName=$this->tableName;
		if (is_null($tableName)) 
			throw new Exception("*AttributeCopier: cannot read: table name is null");

		return CopyTools::getRows($this->dc1, $tableName, "WHERE object_id=$src_object_id", true);
	}

	/** slightly different dup interface yet again. 
	 *  (I'm still experimenting. TODO: Settle on one for all.)
	 *  always returns destination object_id of last/arbitrary 
	 *  item dupped. (which means we can use this particular dup functuon 
	 *  for single *or* multi copy)
	 */
	public function dup() {
		$attributes=$this->read();
		return	$this->write($attributes);
	}

}


class OptionAttributeCopier extends AttributeCopier{
	protected $tableName="option_attribute_values"; 	//Name of the table this class operates on.
	
	public function __construct($dc1, $dc2, $src_object_id, $dst_object_id){
		parent::__construct($dc1, $dc2, $src_object_id, $dst_object_id);
	}

	/**
	 * *all attribute_value tables:
	 * **value_id: unique id in objects table
	 * **object_id: object we are referring to
	 * * Unique to option_attribute_values
	 * ** option_id: reference to the option_attribute_options table
	 */
	public function write_single($attribute) {

		if ($this->doObject($attribute, "value_id"))
			return $attribute["value_id"];

		$attribute["object_id"]=$this->dst_object_id;

		$oaocopier=new OptionAttributeOptionsCopier($attribute["option_id"], $this->dc1, $this->dc2);
		$attribute["option_id"]=$oaocopier->dup();

		$this->doInsert($attribute);
		return $attribute["value_id"];
	}
}

/** Yes, there is actually a table called option_attribute_options.
 * These are the actual *options* that go with a particular option attribute
 * extends copier, not AttributeCopier, because oa_options are not themselves attributes.
 *
 * naming: $oao(s) is/are ObjectAtributeOption(s).
 */
class OptionAttributeOptionsCopier extends Copier {
	protected $option_id;
	protected $tableName="option_attribute_options"; //Name of the table this class operates on.

	public function __construct($option_id, $dc1, $dc2) {
		if (is_null($option_id)) 
			throw new Exception("OptionAttributeOptionsCopier: trying to construct with null option_id. No can do compadre.");

		$this->option_id=$option_id;
		$this->dc1=$dc1;
		$this->dc2=$dc2;
	}	

	public function dup() {
		$oaos=$this->read();
		return $this->write($oaos);
	}
	
	public function read(){
		$dc1=$this->dc1;
		$option_id=$this->option_id;
		return CopyTools::getRows($dc1, $tableName, "WHERE option_id=$option_id", true);
	}

	/**
	 * TODO This is a refactor-candidate.
	 */
	public function write($oaos) {
		$latest=null;
		foreach ($oaos as $oao) {
			$latest=$this->write_single($oao);
		}
		return $latest;
	}

	/**
	* option_id: unique/ objects reference
	* attribute_id: reference to class_attributes (we think!)
	* option_mid: dm for this object. 
	* language_id: reference to mediawiki languages table
	*/
	public function write_single($oao) {

		if ($this->doObject($oao, "option_id"))
			return $oao["option_id"];

		$cacopier=new ClassAttributesCopier($oao["attribute_id"], $this->dc1, $this->dc2);
		$oao["attribute_id"]=$cacopier->dup();

		$this->doDM($oao, "option_mid");
		#language_id is mediawiki, not wikidata, so that's ok.

		$this->doInsert($oao);
		return $oao["option_id"];
	}


}

class TextAttributeCopier extends AttributeCopier{
	protected $tableName="text_attribute_values"; 	//Name of the table this class operates on.
	
	public function __construct($dc1, $dc2, $src_object_id, $dst_object_id){
		parent::__construct($dc1, $dc2, $src_object_id, $dst_object_id);
	}

	/**
	 * *all attribute_value tables:
	 * **value_id: unique id in objects table
	 * **object_id: object we are referring to
	 * ** %_transaction_id	wikidata transactioning
	 * * Unique(ish) to text_attribute_values
	 * ** attribute_mid: name of the attribute, I presume
	 * ** text: actual text
	 * Possibly there's more refactor candidates (such as the value_id and object_id)
	 */
	public function write_single($attribute) {

		if ($this->doObject($attribute, "value_id"))
			return $attribute["value_id"];

		$attribute["object_id"]=$this->dst_object_id;
		$this->doDM($attribute, "attribute_mid");
		# text field is unchanged.

		$this->doInsert($attribute);
		return $attribute["value_id"];
	}
}

class URLAttributeCopier extends AttributeCopier{
	protected $tableName="url_attribute_values"; 	//Name of the table this class operates on.
	
	public function __construct($dc1, $dc2, $src_object_id, $dst_object_id){
		parent::__construct($dc1, $dc2, $src_object_id, $dst_object_id);
	}

	/**
	 * *all attribute_value tables:
	 * **value_id: unique id in objects table
	 * **object_id: object we are referring to
	 * ** %_transaction_id	wikidata transactioning
	 * * Unique(ish) to text_attribute_values
	 * ** attribute_mid: name of the attribute, I presume
	 * ** url: arbitrary varchar (255)
	 * ** label: arbitrary varchar (255)
	 * Possibly there's more refactor candidates (such as the value_id and object_id and attribute mid?)
	 */
	public function write_single($attribute) {

		if ($this->doObject($attribute, "value_id"))
			return $attribute["value_id"];

		$attribute["object_id"]=$this->dst_object_id;

		$this->doDM($attribute, "attribute_mid");
		#url is unchanged
		# label is unchanged

		$this->doInsert($attribute);
		return $attribute["value_id"];
	}
}

class TranslatedContentAttributeCopier  extends AttributeCopier{
	protected $tableName="translated_content_attribute_values"; 	//Name of the table this class operates on.
	
	public function __construct($dc1, $dc2, $src_object_id, $dst_object_id){
		parent::__construct($dc1, $dc2, $src_object_id, $dst_object_id);
	}

	/**
	 * *all attribute_value tables:
	 * **value_id: unique id in objects table
	 * **object_id: object we are referring to
	 * ** %_transaction_id	wikidata transactioning
	 * * Unique(ish) to translated_content_attribute_values.
	 * ** attribute_mid: name of the attribute, I presume
	 * ** url: arbitrary varchar (255)
	 * ** label: arbitrary varchar (255)
	 * Possibly there's more refactor candidates (such as the value_id and object_id and attribute mid?)
	 */
	public function write_single($attribute) {

		if ($this->doObject($attribute, "value_id"))
			return $attribute["value_id"];

		$attribute["object_id"]=$this->dst_object_id;

		$this->doDM($attribute,"attribute_mid");
		
		# we need a value_tcid ... ut oh ...
		$attribute["text_id"]=dup_translated_content($this->dc1, $this->dc2, $attribute["text_id"]);

		$this->doInsert($attribute);
		return $attribute["value_id"];
	}
}


/** Copy alternate meanings */
class AltMeaningTextCopier extends Copier{
	protected $src_meaning_mid;
	protected $dst_meaning_mid;
	protected $dc1;
	protected $dc2;
	protected $tableName="alt_meaningtexts";

	/** you saw that right, class_mid, not class_id, there's no such thing :-/
	 */
	public function __construct($dc1, $dc2, $src_meaning_mid, $dst_meaning_mid) {
		$this->dc1=$dc1;
		$this->dc2=$dc2;
		$this->src_meaning_mid=$src_meaning_mid;
		$this->dst_meaning_mid=$dst_meaning_mid;

	}

	/** unchracteristically, returns the new class_mid, rather than object_id
	 * because in this case, the class_mid is the key characteristic
	 */
	
	# refactor candidate?
	public function read() {
		$dc1=$this->dc1;
		$src_meaning_mid=$this->src_meaning_mid;
		return CopyTools::getRows($dc1, $this->tableName, "WHERE meaning_mid=$src_meaning_mid", true);
	}

	
	public function write_single($altmeaning) {
		$dc1=$this->dc1;
		$dc2=$this->dc2;
		
		# No objects table here , rut roh!
		#if ($this->doObject($attribute,"object_id")) 
		#	return $attribute["object_id"];

		$altmeaning["meaning_mid"]=$this->dst_meaning_mid;
		$altmeaning["meaning_text_tcid"]=dup_translated_content($dc1, $dc2, $altmeaning["meaning_text_tcid"]);
		$this->doDM($altmeaning, "source_id");

		$this->doInsert($altmeaning);

		return $altmeaning["meaning_mid"];
	}




}


?>

<?php
if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

// TODO jobqueue: On removing this legacy job, clean up app/maintenance/updateSpecialPages.php
class UpdateSpecialPagesTask extends BatchTask {
	public $mType;
	public $mVisible;
	public $mData;
	public $mParams;
	
	/**
	 * Contructor
	 * 
	 * @access public
         */
	public function  __construct() {
		$this->mType = "update_special_pages";
		$this->mVisible = true;
		parent::__construct();
	}
	/**
	 * execute
	 * 
	 * Main entry point. TaskManagerExecutor runs this method.
	 * 
	 * @param mixed $params the data for a particular task
	 * @return boolean true on success
	 * @access public
	 */
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath;
		$this->mData = $params;
		$this->log( 'UpdateSpecialPagesTask started.' );
		
		$this->mParams = unserialize( $this->mData->task_arguments );
		
		if ( empty( $this->mParams['wikiId'] ) ) {
			$this->log( 'UpdateSpecialPagesTask: empty wikiId.' );
			$this->log( 'UpdateSpecialPagesTask failed.' );
			return false;
		}
		
		$cmd = "SERVER_ID={$this->mParams['wikiId']} php " 
			. "$IP/maintenance/updateSpecialPages.php "
			. "--conf $wgWikiaLocalSettingsPath";
		
		$this->log( "Running: {$cmd}" );
		$out = wfShellExec( $cmd );
		$this->log( $out );
		
		$this->log( 'UpdateSpecialPagesTask completed.' );
		return true;
	}
	/**
	 * getForm
	 * 
	 * Displays the form in Special:TaskManager
	 * 
	 * @access public
	 * @param $title mixed - Title object
	 * @param $data array default null - unserialized arguments for task
	 * @return boolean false
	 */
	public function getForm( $title, $data = null ) {
		return '<form id="task-form" action="'
			. $title->getLocalUrl( 'action=save' )
			. '" method="post">'
			. '<input type="hidden" name="wpType" value="'
			. $this->mType
			. '" /><fieldset>'
			. '<div class="row">'
			. '<label>Wiki to update</label>'
			. '<input type="text" name="task-usp-wiki" id="task-usp-wiki" value="" />'
			. '<div class="hint">Valid wikia domain or subdomain</div>'
			. '</div>'
			. '<legend>Add Rebuild Localisation Cache task</legend>'
			. '<div style="text-align: center;">'
			. '<input type="submit" name="wpSubmit" value="Add task to queue" />'
			. '</div></fieldset></form>';
	}
	/**
	 * getType
	 * 
	 * Returns the type of the task.
	 * 
	 * @return string the type of the task
	 * @access public
	 */
	function getType() {
		return $this->mType;
	}
	/**
	 * isVisible
	 * 
	 * Returns visibility of the task.
	 * 
	 * @return boolean visibility of the task
	 * @access public 
	 */
	function isVisible() {
		return $this->mVisible;
	}
	/**
	 * submitForm
	 * 
	 * Creates the corresponding entry in the TaskManager queue.
	 * 
	 * @return boolean true
	 * @access public
	 */
	function submitForm() {
		global $wgOut, $wgUser, $wgRequest;
		
		$wikiDomain = Wikia::fixDomainName( $wgRequest->getText( 'task-usp-wiki' ) );
		
		// check if the wiki exists
		$dbr = WikiFactory::db( DB_MASTER );
		$oRow = $dbr->selectRow(
			array( 'city_list', 'city_domains' ),
			array( 'city_public', 'city_list.city_id'),
			array(
			    'city_list.city_id = city_domains.city_id',
			    'city_domain' => $wikiDomain
			),
			__METHOD__
		);
		
		if ( empty( $oRow->city_id ) || 1 != $oRow->city_public ) {
			return false;
		}
		
		$wikiId = $oRow->city_id;
		
		if ( !empty($wikiId) ) {
			$this->mTaskID = $this->createTask( array( 'wikiId' => $wikiId ) );
		}
		
		$wgOut->addHTML( Wikia::successbox( 'Task added' ) );
		return true;
        }
};

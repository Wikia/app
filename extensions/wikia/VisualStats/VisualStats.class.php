<?php
class VisualStats extends WikiaObject {
    private $title = null;

    public function __construct(Title $currentTitle = null) {
        parent::__construct();
        $this->title = $currentTitle;
    }
    public function getUserData($name){
        $user = F::build('User', array($name), 'newFromName');
        return array('id' => $user->getId(), 'name' => $name, 'isAnon' => $user->isAnon());
    }
    public function getDatesFromTwoWeeksOn(){
        $date = strtotime($this->getDateTwoWeeksBefore());
        for ($i=0; $i<=14; $i++){
            $arr[$i] = date("d-m-y", ($date + 86400*$i));
        }
        return $arr;

    }
    private function getDateTwoWeeksBefore(){
        $date = date("Ymd");
        $date = date("Ymd", (strtotime($date) - 1209600)); //1209600 seconds = 14 days
        return($date);
    }
    private function getDB(){
        return $this->app->wf->getDB(DB_SLAVE, array(), $this->app->wg->DBname);
    }
    public function performQuery($username){
        $dbr = $this->getDB();
            $newquery = $dbr->select(
                array( 'revision' ),
                array( 'left(rev_timestamp,10)',
                    'count(*)'),
                array( 'left(rev_timestamp,8)>' .  $this->getDateTwoWeeksBefore()),
                __METHOD__,
                array ('GROUP BY' => 'left(rev_timestamp,10)')
            );
            while ($row = $this->getDB()->fetchObject($newquery)){
                $wikiaResult[] = $row;
            };
            $user = $this->getUserData($username);
            $newquery = $dbr->select(
                array( 'revision' ),
                array( 'left(rev_timestamp,10) as date',
                    'count(*) as count'),
                array( 'left(rev_timestamp,8)>' .  $this->getDateTwoWeeksBefore(),
                    'rev_user' => $user['id']),
                __METHOD__,
                array ('GROUP BY' => 'left(rev_timestamp,10)')
            );
            while ($row = $this->getDB()->fetchObject($newquery)){
                $userResult[] = $row;
            };

        return array('wikia' => $wikiaResult, 'user' => $userResult);

    }

}
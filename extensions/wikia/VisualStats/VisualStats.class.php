<?php
class VisualStats extends WikiaObject {
    private $title = null;

    public function __construct(Title $currentTitle = null) {
        parent::__construct();
        $this->title = $currentTitle;
    }
    public function getUserData($name){
  /*  if ($name==''){
        $name = "0";
    }*/
        $user = F::build('User', array($name), 'newFromName');
        return array('id' => $user->getId(), 'name' => $name, 'isAnon' => $user->isAnon());
    }
    public function getDatesFromTwoWeeksOn(){
        $date = strtotime($this->getDateTwoWeeksBefore());
        for ($i=0; $i<=14; $i++){
            $arr[date("d-m-Y", ($date + 86400*$i))] = 0;
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
        $wikiaResult = array();
        $userResult = array();
        $wikiaCommit = $this->getDatesFromTwoWeeksOn();
        $userCommit = $this->getDatesFromTwoWeeksOn();
        $wikiaCommitMax=0;
        $userCommitMax=0;




            $newquery = $dbr->select(
                array( 'revision' ),
                array( 'left(rev_timestamp,10) as date',
                    'count(*) as count'),
                array( 'left(rev_timestamp,8)>' .  $this->getDateTwoWeeksBefore()),
                __METHOD__,
                array ('GROUP BY' => 'left(rev_timestamp,10)')
            );
            while ($row = $this->getDB()->fetchObject($newquery)){

               // $wikiaResult[] = $row;
                $tempDate = date("d-m-Y", strtotime(substr($row->date,0,8)));
                $wikiaResult[] = array('date' => $tempDate, 'hour' => substr($row->date,8,2), 'count' => $row->count);
                $wikiaCommit[$tempDate]+=$row->count;
                if ($wikiaCommit[$tempDate]>$wikiaCommitMax){
                    $wikiaCommitMax=$wikiaCommit[$tempDate];
                }
            };
       // var_dump($wikiaCommitMax);
       // var_dump($wikiaCommit);
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
                $userResult[] = array('date' => date("d-m-Y", strtotime(substr($row->date,0,8))), 'hour' => substr($row->date,8,2), 'count' => $row->count);
                $userCommit[date("d-m-Y", strtotime(substr($row->date,0,8)))]+=$row->count;
            };

        return array('wikiaCommit' => array('data' => $wikiaCommit, 'max' =>$wikiaCommitMax), 'userCommit' => $userCommit);

    }
/*
 * Utworzyć struktury danych w stylu
 * data, ilość
 * max
 *
 *
 *
 */







}
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
    public function getDatesFromTwoWeeksOn($hours){
        $date = strtotime($this->getDateTwoWeeksBefore());
        if ($hours){
            for($hour = 0; $hour <= 23; $hour++){
                    $arr2[$hour] = 0;
                }
            for ($i = 14; $i >= 0; $i--){
                    $arr[date("d-m-Y", ($date + 86400 * $i))] = $arr2;
            }
        }
        else{
            for ($i = 0; $i <= 14; $i++){
                $arr[date("d-m-Y", ($date + 86400 * $i))] = 0;
            }
        }
        return $arr;

    }
    private function getDateTwoWeeksBefore(){
        $date = date("Ymd");
        $date = date("Ymd", (strtotime($date) - 1209600)); //1209600 seconds = 14 days
        return $date;
    }
    private function getDB(){
        return $this->app->wf->getDB(DB_SLAVE, array(), $this->app->wg->DBname);
    }

    private function performQuery($username){
        $this->app->wf->profileIn( __METHOD__ );

            $dbr = $this->getDB();
            $userQuery = array();

                $wikiaQuery = $dbr->select(
                    array( 'revision' ),
                    array( 'left(rev_timestamp,10) as date',
                        'count(*) as count'),
                    array( 'left(rev_timestamp,8)>' .  $this->getDateTwoWeeksBefore()),
                    __METHOD__,
                    array ('GROUP BY' => 'left(rev_timestamp,10)')
                );


            if ($username != "0"){
                $user = $this->getUserData($username);
                $userQuery = $dbr->select(
                    array( 'revision' ),
                    array( 'left(rev_timestamp,10) as date',
                        'count(*) as count'),
                    array( 'left(rev_timestamp,8)>' .  $this->getDateTwoWeeksBefore(),
                        'rev_user' => $user['id']),
                    __METHOD__,
                    array ('GROUP BY' => 'left(rev_timestamp,10)')
                );

            }
            $out = array('wikia' =>$wikiaQuery, 'user' =>$userQuery, 'db' => $dbr);

        $this->app->wf->profileOut( __METHOD__ );

        return $out;

    }
    public function getDataForCommitActivity($username){
        $this->app->wf->profileIn( __METHOD__ );

        $key = $this->app->wf->MemcKey('VisualStats', 'commitActivity', $username );
        $data = $this->app->wg->memc->get($key);
        if (is_array($data)){
            $out = $data;
        }
        else
        {
            $result = $this->performQuery($username);
            $dbr = $result['db'];
            $userData = $result['user'];
            $wikiaData = $result['wikia'];

            $wikiaCommit = $this->getDatesFromTwoWeeksOn(false);
            $userCommit = $wikiaCommit;
            $wikiaCommitMax = 0;
            $userCommitMax = 0;

            while ($row = $dbr->fetchObject($wikiaData)){

                $tempDate = date("d-m-Y", strtotime(substr($row->date, 0, 8)));
                $wikiaCommit[$tempDate]+= $row->count;
                if ($wikiaCommit[$tempDate] > $wikiaCommitMax){
                    $wikiaCommitMax = $wikiaCommit[$tempDate];
                }
            };
            if ($username != "0"){
            while ($row = $dbr->fetchObject($userData)){
                $tempDate = date("d-m-Y", strtotime(substr($row->date, 0, 8)));
                $userCommit[$tempDate]+= $row->count;
                if ($userCommit[$tempDate] > $userCommitMax){
                    $userCommitMax = $userCommit[$tempDate];
                }
                };
            }
            $out = array('wikiaCommit' => array('data' => $wikiaCommit, 'max' =>$wikiaCommitMax), 'userCommit' => array('data' => $userCommit, 'max' =>$userCommitMax));
            $this->app->wg->memc->set($key, $out, 600);
        }
        $this->app->wf->profileOut( __METHOD__ );

        return $out;

    }
    public function getDataForPunchcard($username){
        $this->app->wf->profileIn( __METHOD__ );

        $key = $this->app->wf->MemcKey('VisualStats', 'punchcard', $username );
        $data = $this->app->wg->memc->get($key);
        if (is_array($data)){
            $out = $data;
        }
        else
        {
            $result = $this->performQuery($username);
            $dbr = $result['db'];
            $userData = $result['user'];
            $wikiaData = $result['wikia'];

            $wikiaPunchcard = $this->getDatesFromTwoWeeksOn(true);
            $userPunchcard = $wikiaPunchcard;
            $wikiaPunchcardMax = 0;
            $userPunchcardMax = 0;

            while ($row = $dbr->fetchObject($wikiaData)){

                $tempDate = date("d-m-Y", strtotime(substr($row->date, 0, 8)));
                $tempHour = substr($row->date, 8, 2);
                if ($tempHour[0]=='0') $tempHour = (int)$tempHour[1];
                $wikiaPunchcard[$tempDate][$tempHour]+= $row->count;
                if ($wikiaPunchcard[$tempDate][$tempHour] > $wikiaPunchcardMax){
                    $wikiaPunchcardMax = $wikiaPunchcard[$tempDate][$tempHour];
                }
            };
            if ($username != "0"){
                while ($row = $dbr->fetchObject($userData)){
                    $tempDate = date("d-m-Y", strtotime(substr($row->date, 0, 8)));
                    $tempHour = substr($row->date, 8, 2);
                    if ($tempHour[0]=='0') $tempHour = (int)$tempHour[1];
                    $userPunchcard[$tempDate][$tempHour]+= $row->count;
                    if ($userPunchcard[$tempDate][$tempHour] > $userPunchcardMax){
                        $userPunchcardMax = $userPunchcard[$tempDate][$tempHour];
                    }
                };
            }
            $out = array('wikiaPunchcard' => array('data' => $wikiaPunchcard, 'max' =>$wikiaPunchcardMax), 'userPunchcard' => array('data' => $userPunchcard, 'max' =>$userPunchcardMax));
            $this->app->wg->memc->set($key, $out, 600);
        }
        $this->app->wf->profileOut( __METHOD__ );

        return $out;

    }
}
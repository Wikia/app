<?php
class VisualStats extends WikiaObject {
    private $title = null;

    public function __construct(Title $currentTitle = null) {
        parent::__construct();
        $this->title = $currentTitle;
    }

    public function getColorForPunchcard(){
        $result = SassUtil::getOasisSettings();
        return $result['color-buttons'];
    }

    public function getColorForLabels(){
        $result = SassUtil::getOasisSettings();
        return $result['color-links'];
    }

    private function getUserData($name){
        $user = User::newFromName($name);
        return array('id' => $user->getId(), 'name' => $name, 'isAnon' => $user->isAnon());
    }

    public function getDatesFromTwoWeeksOn($hours){

        $arr = array(); 
        $date = strtotime($this->getDateTwoWeeksBefore());
        if ($hours){
            $arr2 = array();
            for($hour = 0; $hour <= 23; $hour++){
                $arr2[$hour] = 0;
                }
            for ($i = 14; $i >= 0; $i--){
                $arr[$this->app->wg->lang->date(date("Ymdhis", ($date + 86400 * $i)))] = $arr2;
            }
        }
        else{
            for ($i = 0; $i <= 14; $i++){
                $arr[$this->app->wg->lang->date(date("Ymdhis", ($date + 86400 * $i)))] = 0;
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
        return wfgetDB(DB_SLAVE, array(), $this->app->wg->DBname);
    }

    private function performQuery($username){
        wfProfileIn( __METHOD__ );

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

        wfProfileOut( __METHOD__ );

        return $out;

    }

    public function getDataForCommitActivity($username){
        wfProfileIn( __METHOD__ );

        $key = wfMemcKey('VisualStats', 'commitActivity', $this->app->wg->lang->getCode(), $username );
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
            $wikiaCommitAll = 0;
            $userCommitAll = 0;

            while ($row = $dbr->fetchObject($wikiaData)){
                $tempDate = substr($row->date, 0, 8) . "000000";
                $tempDate = $this->app->wg->lang->date($tempDate);
                $wikiaCommit[$tempDate]+= $row->count;
                $wikiaCommitAll+= $row->count;
                if ($wikiaCommit[$tempDate] > $wikiaCommitMax){
                    $wikiaCommitMax = $wikiaCommit[$tempDate];
                }
            };
            if ($username != "0"){
            while ($row = $dbr->fetchObject($userData)){
                $tempDate = substr($row->date, 0, 8) . "000000";
                $tempDate = $this->app->wg->lang->date($tempDate);
                $userCommit[$tempDate]+= $row->count;
                $userCommitAll+= $row->count;
                if ($userCommit[$tempDate] > $userCommitMax){
                    $userCommitMax = $userCommit[$tempDate];
                }
                };
            }
            $out = array(
                'wikiaCommit' => array(
                    'data' => $wikiaCommit,
                    'max' =>$wikiaCommitMax,
                    'all' =>$wikiaCommitAll),
                'userCommit' => array(
                    'data' => $userCommit,
                    'max' =>$userCommitMax,
                    'all' =>$userCommitAll));

            $this->app->wg->memc->set($key, $out, 600);
        }
        wfProfileOut( __METHOD__ );

        return $out;

    }

    public function getDataForPunchcard($username){
        wfProfileIn( __METHOD__ );

        $key = wfMemcKey('VisualStats', 'punchcard', $this->app->wg->lang->getCode(), $username );
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
            $wikiaPunchcardAll = 0;
            $userPunchcardAll = 0;

            while ($row = $dbr->fetchObject($wikiaData)){
                $tempDate = substr($row->date, 0, 8) . "000000";
                $tempDate = $this->app->wg->lang->date($tempDate);
                $tempHour = substr($row->date, 8, 2);
                if ($tempHour[0]=='0') $tempHour = (int)$tempHour[1];
                $wikiaPunchcard[$tempDate][$tempHour]+= $row->count;
                $wikiaPunchcardAll+= $row->count;
                if ($wikiaPunchcard[$tempDate][$tempHour] > $wikiaPunchcardMax){
                    $wikiaPunchcardMax = $wikiaPunchcard[$tempDate][$tempHour];
                }
            };
            if ($username != "0"){
                while ($row = $dbr->fetchObject($userData)){
                    $tempDate = substr($row->date, 0, 8) . "000000";
                    $tempDate = $this->app->wg->lang->date($tempDate);
                    $tempHour = substr($row->date, 8, 2);
                    if ($tempHour[0]=='0') $tempHour = (int)$tempHour[1];
                    $userPunchcard[$tempDate][$tempHour]+= $row->count;
                    $userPunchcardAll+= $row->count;
                    if ($userPunchcard[$tempDate][$tempHour] > $userPunchcardMax){
                        $userPunchcardMax = $userPunchcard[$tempDate][$tempHour];
                    }
                };
            }
            $out = array(
                'wikiaPunchcard' => array(
                    'data' => $wikiaPunchcard,
                    'max' =>$wikiaPunchcardMax,
                    'all' =>$wikiaPunchcardAll),
                'userPunchcard' => array(
                    'data' => $userPunchcard,
                    'max' =>$userPunchcardMax,
                    'all' =>$userPunchcardAll));

            $this->app->wg->memc->set($key, $out, 600);
        }
        wfProfileOut( __METHOD__ );

        return $out;

    }

    public function getDataForHistogram($username){
        wfProfileIn( __METHOD__ );

        $key = wfMemcKey('VisualStats', 'histogram', $this->app->wg->lang->getCode(), $username );
        $data = $this->app->wg->memc->get($key);
        if (is_array($data)){
            $out = $data;
        }
        else
        {
            $userHistogram = array();
            $wikiaHistogram = array();
            $result = $this->performQuery($username);
            $dbr = $result['db'];
            $userData = $result['user'];
            $wikiaData = $result['wikia'];

            for ($i = 0; $i <= 23; $i++){
                $wikiaHistogram[$i] = 0;
                $userHistogram[$i] = 0;
            }

            $wikiaHistogramMax = 0;
            $userHistogramMax = 0;
            $wikiaHistogramAll = 0;
            $userHistogramAll = 0;

            while ($row = $dbr->fetchObject($wikiaData)){

                $tempHour = substr($row->date, 8, 2);
                if ($tempHour[0]=='0') $tempHour = (int)$tempHour[1];
                $wikiaHistogram[$tempHour]+= $row->count;
                $wikiaHistogramAll+= $row->count;
                if ($wikiaHistogram[$tempHour] > $wikiaHistogramMax){
                    $wikiaHistogramMax = $wikiaHistogram[$tempHour];
                }
            };
            if ($username != "0"){
                while ($row = $dbr->fetchObject($userData)){
                    $tempHour = substr($row->date, 8, 2);
                    if ($tempHour[0]=='0') $tempHour = (int)$tempHour[1];
                    $userHistogram[$tempHour]+= $row->count;
                    $userHistogramAll+= $row->count;
                    if ($userHistogram[$tempHour] > $userHistogramMax){
                        $userHistogramMax = $userHistogram[$tempHour];
                    }
                };
            }
            $out = array(
                'wikiaHistogram' => array(
                    'data' => $wikiaHistogram,
                    'max' =>$wikiaHistogramMax,
                    'all' => $wikiaHistogramAll),
                'userHistogram' => array(
                    'data' => $userHistogram,
                    'max' =>$userHistogramMax,
                    'all' => $userHistogramAll));
            $this->app->wg->memc->set($key, $out, 600);
        }
        wfProfileOut( __METHOD__ );

        return $out;

    }
    public function getDataForCodeFrequency($username){
        wfProfileIn( __METHOD__ );

        $key = wfMemcKey('VisualStats', 'codeFrequency', $this->app->wg->lang->getCode(), $username );
        $data = $this->app->wg->memc->get($key);
        if (is_array($data)){
            $out = $data;
        }
        else
        {

            $dbr = $this->getDB();
            $wikiaResult = $this->getDatesFromTwoWeeksOn(false);
            foreach($wikiaResult as &$item){
                $item = array ('added' => 0, 'deleted' => 0);
            }
            $userResult = $wikiaResult;
            $wikiaTotal = 0;
            $userTotal = 0;
            $wikiaMax = 0;
            $userMax = 0;
            $wikiaMin = 0;
            $userMin = 0;
            $userCount = array('added' => 0, 'deleted' => 0);
            $wikiaCount = array('added' => 0, 'deleted' => 0);

            $wikiaQuery = $dbr->select(
                array( 'recentchanges' ),
                array( 'left(rc_timestamp,8) as date',
                    'rc_old_len',
                    'rc_new_len'),
                array( 'left(rc_timestamp,8)>' .  $this->getDateTwoWeeksBefore()),
                __METHOD__,
                array ()
            );

            while ($row = $dbr->fetchObject($wikiaQuery)){
                $tempDate = $row->date . "000000";
                $tempDate = $this->app->wg->lang->date($tempDate);
                $diff = $row->rc_new_len - $row->rc_old_len;
                $wikiaTotal++;
                if ($diff > 0){
                    $wikiaResult[$tempDate]['added']+= $diff;
                    $wikiaCount['added']+= $diff;
                    if ($wikiaResult[$tempDate]['added'] > $wikiaMax){
                        $wikiaMax = $wikiaResult[$tempDate]['added'];
                    }
                }
                else{
                    $wikiaResult[$tempDate]['deleted']+= abs($diff);
                    $wikiaCount['deleted']+= abs($diff);
                    if ($wikiaResult[$tempDate]['deleted'] > $wikiaMin){
                        $wikiaMin = $wikiaResult[$tempDate]['deleted'];
                    }
                }
            }

            $wikiFunction = array();
            $userFunction = array();
            $maxUserFunction = 0;
            $minUserFunction = 0;
            $actualChars = 0;
            foreach ($wikiaResult as $item){
                $actualChars+= $item['added'] - $item['deleted'];
                $wikiFunction[] = $actualChars;
            }

            if ($username != "0"){
                $user = $this->getUserData($username);
                $userQuery = $dbr->select(
                    array( 'recentchanges' ),
                    array( 'left(rc_timestamp,8) as date',
                        'rc_old_len',
                        'rc_new_len'),
                    array( 'left(rc_timestamp,8)>' .  $this->getDateTwoWeeksBefore(),
                        'rc_user' => $user['id']),
                    __METHOD__,
                    array ()
                );

                while ($row = $dbr->fetchObject($userQuery)){
                    $tempDate = $row->date . "000000";
                    $tempDate = $this->app->wg->lang->date($tempDate);
                    $diff = $row->rc_new_len - $row->rc_old_len;
                    $userTotal++;
                    if ($diff > 0){
                        $userResult[$tempDate]['added']+= $diff;
                        $userCount['added']+= $diff;
                        if ($userResult[$tempDate]['added'] > $userMax){
                            $userMax = $userResult[$tempDate]['added'];
                        }
                    }
                    else{
                        $userResult[$tempDate]['deleted']+= abs($diff);
                        $userCount['deleted']+= abs($diff);
                        if ($userResult[$tempDate]['deleted'] > $userMin){
                            $userMin = $userResult[$tempDate]['deleted'];
                        }
                    }
                }
                $actualChars = 0;
                foreach ($userResult as $item){
                    $actualChars+= $item['added'] - $item['deleted'];
                    $userFunction[] = $actualChars;
                }
                $maxUserFunction = max($userFunction);
                $minUserFunction = min($userFunction);

            }
            $out = array(
                'wikiaFrequency' => array(
                    'data' => $wikiaResult,
                    'total' => $wikiaTotal,
                    'max' => $wikiaMax,
                    'min' => $wikiaMin,
                    'count' => $wikiaCount),
                'wikiaLine' => array(
                    'nodes' => $wikiFunction,
                    'max' => max($wikiFunction),
                    'min' => min($wikiFunction)),
                'userFrequency' => array(
                    'data' => $userResult,
                    'total' => $userTotal,
                    'max' => $userMax,
                    'min' => $userMin,
                    'count' => $userCount),
                'userLine' => array(
                    'nodes' => $userFunction,
                    'max' => $maxUserFunction,
                    'min' => $minUserFunction));
            $this->app->wg->memc->set($key, $out, 600);

        }

        wfProfileOut( __METHOD__ );

        return $out;

    }
}

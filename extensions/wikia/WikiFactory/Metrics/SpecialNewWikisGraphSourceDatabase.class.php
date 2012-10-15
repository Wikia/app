<?php
class SpecialNewWikisGraphSourceDatabase extends SponsorshipDashboardSourceDatabase {
    
    public function setStartDate( $date ) {
        $this->startDate = $date;
    }
    
    public function setEndDate( $date ) {
        $this->endDate = $date;
    }
    
    public function getData() {
        $this->loadData();
    }
    
    protected function getResults() {
        
        $sql = sprintf( $this->sQuery, $this->startDate, $this->endDate );

        $dbr = $this->getDatabase();
        $res = $dbr->query( $sql, __METHOD__ );

        while ( $row = $res->fetchObject( $res ) ) {
            $sDate = $row->creation_date;
            $sDate = $this->frequency->formatDateByString( $sDate );
            $this->dataAll[ $sDate ][ 'date' ] = $sDate;
            $this->dataAll[ $sDate ][ 'a'.md5( $this->serieName ) ] = $row->number;
        }
        
        $this->dataTitles[ 'a'.md5( $this->serieName ) ] = $this->serieName;
        
        $numberOfRecords = count( $this->dataAll );
    }
}
<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "CentralNotice extension\n";
        exit( 1 ); 
}

class CentralNoticeDB {

        /* Functions */

        function CentralNoticeDB() {
                // Register special page
                SpecialPage::SpecialPage( 'CentralNotice' );

                // Internationalization
                wfLoadExtensionMessages( 'CentralNotice' );
        }

        /*
         * Return notices in the system within given constraints
         * Optional: return both enabled and disabled notices
         */
        public function getNotices( $project = false, $language = false , $date = false , $enabled = true, $preferred = false ) {
                // Database setup
                $dbr = wfGetDB( DB_SLAVE );

                // Use whatever conditional arguments got passed in
                if ( $project ) 
                    $conds[] = "not_project =" . $dbr->addQuotes( $project );
                if ( $language ) 
                    $conds[] = "not_language =" . $dbr->addQuotes( $language );
                if ( $preferred )
                    $conds[] = "not_preferred = 1";
                if ( !$date ) 
                    $date = wfTimestamp( TS_MW );

                $conds[] = ( $date ) ? "not_start <= ". $dbr->addQuotes( $date ) : "not_start <= " . $dbr->addQuotes( $dbr->timestamp( $date ) );
                $conds[] = ( $date ) ? "not_end >= " . $dbr->addQuotes( $date ) : "not_end >= " . $dbr->addQuotes( $dbr->timestamp( $date ) );
                $conds[] = ( $enabled ) ? "not_enabled = " . $dbr->addQuotes( $enabled ) : "not_enabled = " . $dbr->addQuotes( 1 );

                // Pull db data
                $res = $dbr->select(
                    array( 
                             'cn_notices',
                    ),
                    array(
                            'not_name',
                            'not_project',
                            'not_language',
                            'not_locked',
                            'not_enabled',
                            'not_preferred',
                    ),
                    $conds,
                    __METHOD__
                );
                
                if ( $dbr->numRows( $res ) < 1 ) {
                        return;
                }

                $notices = array();
                // Loop through result set and return attributes
                while ( $row = $dbr->fetchObject( $res ) ) {
                    $notice = $row->not_name;
                    $notices[$notice]['project'] = $row->not_project;
                    $notices[$notice]['language'] = $row->not_language;
                    $notices[$notice]['preferred'] = $row->not_preferred;
                    $notices[$notice]['locked'] = $row->not_locked;
                    $notices[$notice]['enabled'] = $row->not_enabled;
                }     
                
                return $notices;
        }

        /*
         * Given a notice return all templates bound to it
         */ 
        public function selectTemplatesAssigned( $notice ) {
                $dbr = wfGetDB( DB_SLAVE );

                // Pull templates based on join with assignments
                $res = $dbr->select(
                        array(
                                'cn_notices',
                                'cn_assignments',
                                'cn_templates'
                        ),
                        array(
                                'cn_templates.tmp_name',
                                'SUM(tmp_weight) AS total_weight',
                        ),
                        array(
                                'cn_notices.not_name' => $notice,
                                'cn_notices.not_id = cn_assignments.not_id',
                                'cn_assignments.tmp_id = cn_templates.tmp_id'
                        ),
                        __METHOD__,
                        array( 
                            'GROUP BY' => 'tmp_name' )
                );
                $templateWeights = array();
                foreach ( $res as $row ) {
                        $name = $row->tmp_name;
                        $weight = intval( $row->total_weight );
                        $templateWeights[$name] = $weight;
                }
                return $templateWeights;
        }

        public function updatePreferred( $notice, $preferred ) {
            $dbw = wfGetDB( DB_MASTER );
            $dbw->begin();

            $res = $dbw->update( 'cn_notices',
                array(     
                        'not_preferred' => $preferred,
                 ),
                array( 
                        'not_name' => $notice
                )
            );
            $dbw->commit();
            return $res;
        }
}

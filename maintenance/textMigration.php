<?php

require_once 'Maintenance.php';
        
class TextMigration extends Maintenance {
                
  public function __construct() {
    parent::__construct();
  }
        
  public function execute() {
        $this->output("Migrating the fields archive.ar_text and  archive.ar_flags from archive table to text table\n"); 
        $dbw = wfGetDB( DB_MASTER );
        $result = $dbw ->select( 'archive',
                array( 'ar_id','ar_text', 'ar_flags' ),
                NULL,   
                __METHOD__);
	$count = 0 ;
        foreach( $result as $row) {
		$count++;
                $dbw->insert( 'text',
                                array('old_id'=>$row->ar_id,'old_text'=>$row->ar_text,'old_flags'=>$row->ar_flags),
                                __METHOD__,
                                '');
        }                       
        $this->output( "Successfully migrated $count number of rows \n") ;
  }                             
}                       
                                
$maintClass = "TextMigration";
require_once RUN_MAINTENANCE_IF_MAIN;

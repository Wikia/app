
<!-- FogBugzDiagrams - template file -->

	<div class = "description"><?php echo wfMsg( 'brief' ) ?></div>
	    
	<h1><?php echo wfMsg( 'bugs-age' ) ?></h1>            
    <div class = "diagram" id = "bugs_age"></div>
    <div class = "legend" id = "bugs_age_legend"></div>
    <div class = "description"><?php echo wfMsg( 'description-bugs-age' ) ?></div>
    
   	<h1><?php echo wfMsg( 'accumulated-by-priority' ) ?></h1>
   	<div class = "diagram" id = "bugs_accumulated_by_priority"></div>
    <div class = "legend" id = "bugs_accumulated_by_priority_legend"></div>
    <div class = "description"><?php echo wfMsg( 'description-accumulated-by-current-priority' ) ?></div>
        
    <h1><?php echo wfMsg( 'created-by-priority' ) ?></h1>
    <div class = "diagram" id = "bugs_created_by_priority"></div>
    <div class = "legend" id = "bugs_created_by_priority_legend"></div>
    <div class = "description"><?php echo wfMsg( 'description-created-by-current-priority' ) ?></div>
    
    <h1><?php echo wfMsg( 'created-p1-p2-p3' ) ?></h1>
    <div class = "diagram" id = "p1_p2_p3_bugs_created"></div>
    <div class = "legend" id = "created_p1_p2_p3_legend"></div>
    <div class = "description"><?php echo wfMsg( 'description-created-p1-p2-p3-by-current-priority' ) ?></div>
    
    <h1><?php echo wfMsg( 'resolved-minus-created' ) ?></h1>
    <div class = "diagram" id = "bugs_resolved_opened_diff"></div>
    <div class = "legend" id = "resolved_minus_created_legend"></div> 
    <div class = "description"><?php echo wfMsg( 'description-difference-resolved-created' ) ?></div>

<script type="text/javascript">	
    var data = <?php echo json_encode( $this->getResponse()->getData() ); ?>;
</script>

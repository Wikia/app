
<ul class="tabs">
	<?php foreach($searchProfiles as $profileId => $profile): ?>
		<?php $tooltipParam = isset( $profile['namespace-messages'] ) ? $wg->Lang->commaList( $profile['namespace-messages'] ) : null; ?>
		<li class="<?=($activeTab == $profileId) ? 'selected' : 'normal';?>">
			<?= $app->renderView( 'WikiaSearch', 'advancedTabLink', array(
				'term' => $bareterm,
				'namespaces' => $profile['namespaces'],
				'label' => wfMsg( $profile['message'] ),
				'tooltip' => wfMsg( $profile['tooltip'], $tooltipParam ),
				'redirs' => $redirs,
				'params' => isset( $profile['parameters'] ) ? $profile['parameters'] + array('fulltext'=>'Search') : array('fulltext'=>'Search') ) );
			?>
		</li>
	<?php endforeach; ?>
</ul>


<?php if($advanced): ?>
	<?php
		// Groups namespaces into rows according to subject
		$rows = array();
		foreach( $searchableNamespaces as $namespace => $name ) {
			$subject = MWNamespace::getSubject( $namespace );

			if( !array_key_exists( $subject, $rows ) ) {
				$rows[$subject] = "";
			}
			$name = str_replace( '_', ' ', $name );
			if( $name == '' ) {
				$name = wfMsg( 'blanknamespace' );
			}

			$checked = in_array( $namespace, $namespaces ) ? 'checked="checked"': '';
			$rows[$subject] .= '<label for="mw-search-ns'.$namespace.'"><input name="ns'.$namespace.'" type="checkbox" value="1" id="mw-search-ns'.$namespace.'" '.$checked.' /> '.$name.'</label>';
		}
		$rows = array_values( $rows );
		$numRows = count( $rows );


		$hidden = '<input type="hidden" name="advanced" value="'.$advanced.'" />';
	?>

	<section class="AdvancedSearch">
		<h3><?=wfMsg('wikiasearch2-advanced-search');?></h3>
		
		<?php for( $i = 0; $i < $numRows; $i++ ) {
			echo $rows[$i];
		} ?>
		<?= $hidden; ?>
	</section>

<?php endif; // advanced ?>


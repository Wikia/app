
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
			$rows[$subject] .= '<label for="mw-search-ns'.$namespace.'"><input name="ns'.$namespace.'" type="checkbox" value="1" id="mw-search-ns'.$namespace.'" '.$checked.' />'.$name.'</label>';
		}
		$rows = array_values( $rows );
		$numRows = count( $rows );


		$hidden = '<input type="hidden" name="advanced" value="'.$advanced.'" />';
	?>

	<section id="AdvancedSearch" class="AdvancedSearch<? if(!$advanced){ ?> hidden<? } ?>">
		<h3><?=wfMsg('wikiasearch2-advanced-search');?></h3>
		
		<?php for( $i = 0; $i < $numRows; $i++ ) {
			echo $rows[$i];
		}
		?><label for="mw-search-select-all"><input type="checkbox" id="mw-search-select-all" /><?=wfMsg('wikiasearch2-advanced-select-all')?></label>
		<?= $hidden; ?>
	</section>




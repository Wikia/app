
<div class="mw-search-formheader">
	<div class="search-types">
		<ul>
			<?php foreach($searchProfiles as $profileId => $profile): ?>
				<?php $tooltipParam = isset( $profile['namespace-messages'] ) ? $wg->Lang->commaList( $profile['namespace-messages'] ) : null; ?>
				<li class="<?=($activeTab == $profileId) ? 'current' : 'normal';?>">
					<?= $app->renderView( 'WikiaSearch', 'advancedTabLink', array(
						'term' => $bareterm,
						'namespaces' => $profile['namespaces'],
						'label' => wfMsg( $profile['message'] ),
						'tooltip' => wfMsg( $profile['tooltip'], $tooltipParam ),
						'redirs' => $redirs,
						'params' => isset( $profile['parameters'] ) ? $profile['parameters'] : array() ) );
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<div style="clear: both"></div>

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
			$rows[$subject] .= '<td style="white-space: nowrap;"><input name="ns'.$namespace.'" type="checkbox" value="1" id="mw-search-ns'.$namespace.'" '.$checked.' />&nbsp;<label for="mw-search-ns'.$namespace.'">'.$name.'</label></td>';
		}
		$rows = array_values( $rows );
		$numRows = count( $rows );

		// Lays out namespaces in multiple floating two-column tables so they'll
		// be arranged nicely while still accommodating different screen widths
		$namespaceTables = '';
		for( $i = 0; $i < $numRows; $i += 4 ) {
			$namespaceTables .= '<table cellpadding="0" cellspacing="0" border="0">';
			for( $j = $i; $j < $i + 4 && $j < $numRows; $j++ ) {
				$namespaceTables .= '<tr>'.$rows[$j].'</tr>';
			}
			$namespaceTables .= '</table>';
		}

		// Show redirects check only if backend supports it
		$redirects = '<input name="redirs" type="checkbox" value="1" '.(!empty($redirs)?'checked="checked"':'').' id="redirs" /><label for="redirs">'.wfMsg( 'powersearch-redir' ).'</label>';
		$hidden = '<input type="hidden" name="advanced" value="'.$advanced.'" />';
	?>

	<fieldset id="mw-searchoptions" style="margin:0em;">
		<legend><?=wfMsg('powersearch-legend');?></legend>
		<h4><?=wfMsgExt( 'powersearch-ns', array( 'parseinline' ) );?></h4>
		<div id="mw-search-togglebox">
			<label for="mw-search-togglelabel"><?=wfMsg( 'powersearch-togglelabel' );?></label>
			<input type="button" id="mw-search-toggleall" onclick="mwToggleSearchCheckboxes('all');" value="<?=wfMsg( 'powersearch-toggleall' );?>" />
			<input type="button" id="mw-search-togglenone" onclick="mwToggleSearchCheckboxes('none');" value="<?=wfMsg( 'powersearch-togglenone' );?>" />
		</div>
		<div class="divider"></div>
		<?=$namespaceTables;?>
		<div class="divider"></div>
		<?=$redirects.$hidden;?>
	</fieldset>

<?php endif; // advanced ?>


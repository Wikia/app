<ul class="search-tabs grid-1 alpha">
	<?php foreach($searchProfiles as $profileId => $profile): ?>
		<? if( $profileId == SEARCH_PROFILE_ADVANCED) {
			continue;
		} ?>
		<?php $tooltipParam = isset( $profile['namespace-messages'] ) ? $wg->Lang->commaList( $profile['namespace-messages'] ) : null; ?>
		<li class="<?=($activeTab == $profileId) ? 'selected' : 'normal';?>">
			<?= $app->renderView( 'WikiaSearch', 'advancedTabLink', array(
				'term' => $bareterm,
				'namespaces' => $profile['namespaces'],
				'label' => wfMsg( $profile['message'] ),
				'tooltip' => wfMsg( $profile['tooltip'], $tooltipParam ),
				'params' => isset( $profile['parameters'] ) ? $profile['parameters'] + array('fulltext'=>'Search') : array('fulltext'=>'Search') ) );
			?>
			<? // Image/Video tab options ?>
			<? if( $activeTab == $profileId && $profile['namespaces'][0] == NS_FILE ): ?>

				<div class="search-filter-sort" id="file-search-filter-sort">
					<div class="search-filter-sort-overlay"></div>
					<p><?= wfMessage('wikiasearch2-filter-options-label') ?>:</p>
					<ul class="search-sort">
						<li>
							<label><input type="radio" name="filters[]" value="no_filter" <? if($form['no_filter']){ ?>checked<? } ?> /><?= wfMessage('wikiasearch2-filter-all') ?></label>
						</li>
						<li>
							<label><input type="radio" name="filters[]" value="is_image" <? if($form['is_image']){ ?>checked<? } ?> /><?= wfMessage('wikiasearch2-filter-photos') ?></label>
						</li>
						<li>
							<label><input type="radio" name="filters[]" value="is_video" <? if($form['is_video']){ ?>checked<? } ?> id="filter-is-video" /><?= wfMessage('wikiasearch2-filter-videos') ?></label>
							<ul class="video-filters <? if(!$form['is_video']){ ?>hidden <? } ?>">
								<li>
									<label><input type="checkbox" name="filters[]" value="is_hd" <? if($form['is_hd']){ ?>checked<? } ?> /><?= wfMessage('wikiasearch2-filter-hd') ?></label>
								</li>
								<? if($is_video_wiki) { ?>
									<li>
										<label><input type="checkbox" name="by_category" value="1" <? if($form['by_category']){ ?>checked<? } ?> id="filter-by-category" /><?= wfMessage('wikiasearch2-filter-category') ?></label>
										<select name="filters[]" <? if(!$form['by_category']){ ?>disabled<? } ?>>
											<option value="" ><?= wfMessage('wikiasearch2-choose-category') ?></option>
											<option value="cat_videogames" <? if($form['cat_videogames']){ ?>selected<? } ?>><?= wfMessage('hub-Gaming') ?></option>
											<option value="cat_entertainment" <? if($form['cat_entertainment']){ ?>selected<? } ?>><?= wfMessage('hub-Entertainment') ?></option>
											<option value="cat_lifestyle" <? if($form['cat_lifestyle']){ ?>selected<? } ?>><?= wfMessage('hub-Lifestyle') ?></option>
										</select>
									</li>
								<? } ?>
							</ul>
						</li>
					</ul>
					<p><?= wfMessage('wikiasearch2-sort-options-label') ?>:</p>
					<select name="rank">
						<option value="default" <? if($form['sort_default']){ ?>selected<? } ?>><?= wfMessage('wikiasearch2-sort-relevancy') ?></option>
						<option value="newest" <? if($form['sort_newest']){ ?>selected<? } ?>><?= wfMessage('wikiasearch2-sort-publish-date') ?></option>
						<? if ( isset($form['is_video']) && $form['is_video']==true ) { ?>
							<option value="longest" <? if($form['sort_longest']){ ?>selected<? } ?>><?= wfMessage('wikiasearch2-sort-duration') ?></option>
						<? } ?>
					</select>

				</div>

			<? endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

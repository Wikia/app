<?php

class SpecialAbTestingController extends WikiaSpecialPageController {

	const FLAG_FIELD_PREFIX = 'flag_';

	protected $abData;
	protected $abTesting;

	public function __construct() {
		parent::__construct('AbTesting', 'abtestpanel', false);
	}

	public function index() {
		if ( !$this->wg->User->isAllowed( 'abtestpanel' ) ) {
			$this->skipRendering();
			throw new PermissionsError( 'abtestpanel' );
		}

		$abData = $this->getAbData();
		$this->getResponse()->addModuleStyles('wikia.ext.abtesting.edit.styles');
		$this->getResponse()->addModules('wikia.ext.abtesting.edit');

		$this->setHeaders();
		$experiments = $abData->getAll();
		foreach ($experiments as &$exp) {
			$this->addActions($exp);
		}
		$this->setVal( 'experiments', $experiments );

		$actions = array();
		$actions[] = array(
			'cmd' => 'add-experiment',
			'class' => 'add sprite-small',
			'text' => wfMsg('abtesting-create-experiment'),
		);
		$this->setVal( 'actions', $actions );
	}

	public function modal() {
		$this->checkPermissions();

		$abTesting = $this->getAbTesting();

		$id = $this->getVal('id',0);
		$type = $this->getVal('type','add');
		$experiment = $this->getExperiment($id,true);
		$info = $this->getExperimentInfo($experiment);
		$lastVersion = $info['lastVersion'];
		$hasStarted = $info['hasStarted'];
		$formId = 'AbTestingEditForm';
		$fields = array();
		$groups = array();
		$lastFlags = $lastVersion ? $lastVersion['flags'] : AbTesting::DEFAULT_FLAGS;

		$fields['id'] = array(
			'type' => 'hidden',
			'name' => 'id',
			'value' => $experiment['id'],
		);

		$fields['name'] = array(
			'type' => $hasStarted ? 'display' : 'text',
			'name' => 'name',
			'label' => wfMsg('abtesting-heading-name'),
			'value' => $experiment['name'],
		);

		$fields['description'] = array(
			'type' => 'textarea',
			'class' => 'fullwidth',
			'name' => 'description',
			'label' => wfMsg('abtesting-heading-description'),
			'value' => $experiment['description'],
		);

		$fields['version_id'] = array(
			'type' => 'hidden',
			'name' => 'version_id',
			'value' => $lastVersion ? $lastVersion['id'] : '',
		);

		$fields['start_time'] = array(
			'type' => 'text',
			'name' => 'start_time',
			'class' => 'datepicker',
			'label' => wfMsg('abtesting-heading-start-time'),
			'value' => $lastVersion ? $lastVersion['start_time'] : '',
		);

		$fields['end_time'] = array(
			'type' => 'text',
			'name' => 'end_time',
			'class' => 'datepicker',
			'label' => wfMsg('abtesting-heading-end-time'),
			'value' => $lastVersion ? $lastVersion['end_time'] : '',
		);

		$fields['ga_slot'] = array(
			'type' => 'text',
			'name' => 'ga_slot',
			'label' => wfMsg('abtesting-heading-ga-slot'),
			'value' => $lastVersion ? $lastVersion['ga_slot'] : '',
		);

		$fields['flags_before'] = array(
			'type' => 'raw',
			'output' => '<div class="input-group">'
		);

		foreach (AbTesting::$flags as $flag => $name) {
			$flagFieldConf = array(
				'type' => 'checkbox',
				'name' => self::FLAG_FIELD_PREFIX.$name,
				'label' => wfMsg('abtesting-heading-long-flag-'.$name),
			);
			if ( $abTesting->getFlagState($lastFlags,$flag) ) {
				$flagFieldConf['attributes']['checked'] = 'checked';
			}
			$fields[self::FLAG_FIELD_PREFIX.$name] = $flagFieldConf;
		}

		$fields['flags_after'] = array(
			'type' => 'raw',
			'output' => '</div>'
		);

		// Treatment Groups
		$rangesInfo = wfMsg( 'abtesting-ranges-info' );
		foreach ($experiment['groups'] as $group) {
			$ranges = '';
			$styles = '';
			$scripts = '';
			$groupId = $group['id'];

			if ($lastVersion && !empty($lastVersion['group_ranges'][$groupId])) {
				$ranges = $lastVersion['group_ranges'][$groupId]['ranges'];
				$styles = $lastVersion['group_ranges'][$groupId]['styles'];
				$scripts = $lastVersion['group_ranges'][$groupId]['scripts'];
			}

			$groups[] = array(
				'type' => 'hidden',
				'name' => 'groups[]',
				'value' => $group['name'],
				'attributes' => array(
					'data-id' => $group['id']
				)
			);

			$groups[] = array(
				'type' => 'text',
				'name' => 'ranges[]',
				'class' => 'ranges',
				'label' => $group['name'] . ' ' . $rangesInfo,
				'value' => $ranges,
			);

			$groups[] = $this->getPopupButtonField('Styles','group-styles','styles[]',$styles);
			$groups[] = $this->getPopupButtonField('Scripts','group-scripts','scripts[]',$scripts);

		}

		$groups[] = array(
			'type' => 'button',
			'name' => 'addTreatmentGroup',
			'content' => wfMsg('abtesting-add-treatment-group'),
		);

		$fields[] = array(
			'type' => 'nirvanaview',
			'class' => 'experiment-groups',
			'controller' => 'WikiaStyleGuideForm',
			'view' => 'index',
			'params' => array(
				'form' => array(
					'inputs' => $groups,
					'legend' => wfMsg('abtesting-heading-treatment-groups')
				)
			),
		);

		$form = array(
			'class' => $formId . ' ' . $type,
			'id' => $formId,
			'inputs' => $fields,
			'submits' => array(
				array(
					'value' => wfMsg('abtesting-save-button'),
				)
			)
		);

		$this->setVal('id', $id);
		$this->setVal('type', $type);
		$this->setVal('html', $this->app->renderPartial('WikiaStyleGuideForm','index',array('form'=>$form)));
	}

	public function save() {
		$data = $this->request->getParams();

		$id = $data['id'];
		$this->packFlags($data);
		$experiment = $this->getExperiment($id, true);
		if ( empty($experiment) ) {
			return $this->error('The experiment has not been found');
		}

		/** @var $status Status */
		$status = $this->doSave( $experiment, $data );
		// Set the ID again in case this was a new experiment
		$id = $experiment['id'];

		if ( $status->isGood() ) {
			$experiment = $this->getAbData()->getById($id, true);
			$this->addActions($experiment);
			$this->setVal('status',true);
			$this->setVal('id',$id);
			$this->setVal('html',$this->app->renderPartial('SpecialAbTesting','experiment',array('experiment'=>$experiment)));
		} else {
			$this->setVal('status',false);
			$this->setVal('errors',$status->getErrorsArray());
		}
	}

	protected function addActions( &$exp ) {
		$exp['actions'] = array();
		// add "Edit experiment" button
		$exp['actions'][] = array(
			'cmd' => 'edit-experiment',
			'class' => 'edit-pencil sprite',
			'text' => wfMsg('abtesting-edit-button'),
		);
	}

	protected function packFlags( &$data ) {
		$flags = 0;
		foreach (AbTesting::$flags as $flag => $name) {
			$field =  self::FLAG_FIELD_PREFIX.$name ;
			if ( !empty($data[ $field ]) ) {
				$flags |= $flag;
			}
			unset( $data[ $field ] );
		}
		$data['flags'] = $flags;
		return $flags;
	}

	protected function checkValueChanged( $old, $new, &$changed = false ) {
		if ( $old === null || $old === '' ) {
			if ( $new !== null && $new !== '' ) {
				$changed = true;
			}
		} else {
			if ( $old !== $new ) {
				$changed = true;
			}
		}
		return $changed;
	}

	protected function doSave( &$exp, $data ) {
		$abTesting = $this->getAbTesting();
		$status = Status::newGood();
		$info = $this->getExperimentInfo($exp);
		$nowPlusCache = $info['nowPlusCache'];
		$versionChanged = false;
		$hasFutureVersion = $info['hasFutureVersion'];
		$experimentChanged = false;

		// set default values
		$data = $data + array(
			'groups' => array(),
			'ranges' => array(),
		);

		// create index of existing groups (normalized name => id)
		$existingGroups = array();
		foreach ($exp['groups'] as $grp) {
			$normalizedName = $abTesting->normalizeName($grp['name']);
			$existingGroups[$normalizedName] = $grp['id'];
		}

		if ( empty($exp['id']) ) {
			$experimentChanged = true;
			// name is mandatory when creating new experiment
			if ( empty($data['name'] ) ) {
				$status->error('Name is required');
			}
		}
		// name can be changed only if experiment hasn't started yet
		if ( $info['hasStarted'] && !empty($data['name']) && $exp['name'] !== $data['name'] ) {
			$status->error('Could not change name of experiment that is already running');
		}
		// if name was changed
		if ( !empty($data['name']) ) {
			$exp['name'] = $data['name'];
			$experimentChanged = true;
		}
		// if description was changed
		if ( !empty($data['description']) && $data['description'] !== $exp['description'] ) {
			$exp['description'] = $data['description'];
			$experimentChanged = true;
		}

		$newGroups = array();
		$groups = array();
		foreach ($data['groups'] as $i => $groupName) {
			$ranges = $data['ranges'][$i];
			$styles = $data['styles'][$i];
			$scripts = $data['scripts'][$i];

			if ( empty( $groupName ) && empty( $ranges ) && empty( $styles ) && empty( $scripts ) ) {
				continue;
			}

			// check if the normalized name collides with any other group name
			$normalizedName = $abTesting->normalizeName($groupName);
			if ( isset( $groups[$normalizedName] ) ) {
				$prevGroupName = $groups[$normalizedName]['name'];
				$status->error("These group names resolve to the same identifier: \"{$prevGroupName}\", \"{$groupName}\"");
			}

			// Save the original name in case we need it for error reporting
			$groups[$normalizedName]['name'] = $groupName;

			// check if provided ranges can be parsed
			if ( $abTesting->parseRanges($ranges, true) === false ) {
				$status->error("Range for group \"{$groupName}\" is invalid");
			}

			// save group-to-range assignment in a more helpful way
			$groups[$normalizedName]['ranges'] = $ranges;
			$groups[$normalizedName]['styles'] = $styles;
			$groups[$normalizedName]['scripts'] = $scripts;

			// if group doesn't exist schedule it for adding
			if ( !isset($existingGroups[$normalizedName] ) ) {
				$newGroups[$normalizedName] = array(
					'name' => $groupName,
					'description' => '',
				);
				$this->checkValueChanged(null,$ranges,$versionChanged);
			} else {
				$grpId = $existingGroups[$normalizedName];
				$this->checkValueChanged(@$info['lastVersion']['group_ranges'][$grpId]['ranges'],$ranges,$versionChanged);
				$this->checkValueChanged(@$info['lastVersion']['group_ranges'][$grpId]['styles'],$styles,$versionChanged);
				$this->checkValueChanged(@$info['lastVersion']['group_ranges'][$grpId]['scripts'],$scripts,$versionChanged);
			}

		}

		$this->checkValueChanged(@$info['lastVersion']['start_time'],$data['start_time'],$versionChanged);
		$this->checkValueChanged(@$info['lastVersion']['end_time'],$data['end_time'],$versionChanged);
		$this->checkValueChanged(@$info['lastVersion']['ga_slot'],$data['ga_slot'],$versionChanged);
		$this->checkValueChanged(@$info['lastVersion']['flags'],$data['flags'],$versionChanged);

		$startTime = null;
		$endTime = null;
		if ( $versionChanged ) {
			$startTime = $abTesting->getTimestampForUTCDate($data['start_time']);
			$endTime = $abTesting->getTimestampForUTCDate($data['end_time']);

			if ( $startTime < $nowPlusCache ) {
				$status->error("Start time must be at least 15 minutes in the future");
			}

			if ( $startTime >= $endTime ) {
				$status->error('End time must be after start time');
			}
		}

		// if no problem found proceed with saving
		if ( $status->isGood() ) {
			$abData = $this->getAbData();
			// first save the experiment in case you create new one (we need ID)
			if ( $experimentChanged ) {
				$abData->saveExperiment($exp);
			}
			$expId = $exp['id'];
			// save new groups
			foreach ($newGroups as $normalizedName => $grp) {
				$grp['experiment_id'] = $expId;
				$abData->saveGroup($grp);
				$existingGroups[$normalizedName] = $grp['id'];
			}

			// if ranges configuration has changed
			if ( $versionChanged ) {

				// find previous and current versions
				$versions = array_slice($exp['versions'],-2);
				if ( !$hasFutureVersion ) {
					if (count($versions) > 1) {
						array_shift($versions);
					}
					array_push($versions,$abData->newVersion());
				}

				if ( count( $versions ) == 2 ) {
					$previous = $versions[0];
					$current = $versions[1];
				} else {
					$previous = null;
					$current = $versions[0];
				}
				// adjust end_time of the previous group
				if ( !empty($previous) ) {
					$prevEndTime = $abTesting->getTimestampForUTCDate($previous['end_time']);
					// cannot edit group that end within the cache time
					if ( $prevEndTime > $nowPlusCache ) {
						// experiment must have existed so no need to set experiment_id
						$previous['end_time'] = $data['start_time'];
						$abData->saveVersion($previous);
					}
				}
				// save the current version of experiment
				$current = array_merge( $current, array(
					'experiment_id' => $expId,
					'start_time' => $data['start_time'],
					'end_time' => $data['end_time'],
					'ga_slot' => $data['ga_slot'],
					'flags' => $data['flags'],
				) );
				$abData->saveVersion($current);
				$verId = $current['id'];
				// save group ranges
				foreach ($groups as $normalizedName => $info) {
					$ranges = $info['ranges'];
					$styles = $info['styles'];
					$scripts = $info['scripts'];
					$grpId = $existingGroups[$normalizedName];
					$grn = array(
						'group_id' => $grpId,
						'version_id' => $verId,
						'ranges' => $ranges,
						'styles' => $styles ? $styles : null,
						'scripts' => $scripts ? $scripts : null,
					);
					$abData->saveGroupRange($grn);
				}
				$abData->updateModifiedTime();
				$abTesting->invalidateCache();
			}
		}

		return $status;
	}

	protected function error( $errors ) {
		$this->setVal('status',false);
		$this->setVal('errors',(array)$errors);
	}

	/**
	 * @return AbTestingData
	 */
	protected function getAbData() {
		if ( !$this->abData ) {
			$this->abData = new AbTestingData();
		}
		return $this->abData;
	}

	/**
	 * @return AbTesting
	 */
	protected function getAbTesting() {
		if ( !$this->abTesting ) {
			$this->abTesting = AbTesting::getInstance();
		}
		return $this->abTesting;
	}

	protected function getExperiment( $id, $createIfEmpty = false ) {
		$experiment = null;
		if ( !empty($id) ) {
			$experiment = $this->getAbData()->getById($id);
		} else if ($createIfEmpty) {
			$experiment = $this->getAbData()->newExperiment();
		}
		return $experiment;
	}

	protected function getExperimentInfo( $exp ) {
		$now = time();
		$nowPlusCache = $now + AbTesting::VARNISH_CACHE_TIME;

		$info = array(
			'hasStarted' => false,
			'firstVersion' => false,
			'lastVersion' => false,
			'hasFutureVersion' => false,
			'now' => $now,
			'nowPlusCache' => $nowPlusCache,
		);

		if ( !empty( $exp['versions'] ) ) {
			$firstId = min( array_keys( $exp['versions'] ) );
			$info['firstVersion'] = $exp['versions'][$firstId];
			$lastId = max( array_keys( $exp['versions'] ) );
			$info['lastVersion'] = $exp['versions'][$lastId];
			$info['hasStarted'] = strtotime($info['firstVersion']['start_time']) < $nowPlusCache;
			$info['hasFutureVersion'] = strtotime($info['lastVersion']['start_time']) > $nowPlusCache;
		}

		return $info;
	}

	protected function getPopupButtonField( $caption, $class, $name, $value ) {
		return array(
			'type' => 'custom',
			'class' => 'value-dialog ' . $class . (!empty( $value ) ? ' value-active' : ''),
			'output' =>
				"<input name=\"".htmlspecialchars($name)."\" type=\"hidden\" value=\"".htmlspecialchars($value)."\" />".
				"<span>$caption: <span class=\"value-empty-text\">(none)</span><span class=\"value-present-text\">(present)</span> <a class=\"wikia-button value-edit\">Edit</a></span>",
		);
	}

}

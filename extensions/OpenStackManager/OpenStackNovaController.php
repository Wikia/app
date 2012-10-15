<?php

# TODO: Make this an abstract class, and make the EC2 API a subclass
class OpenStackNovaController {

	var $credentials;
	var $novaConnection;
	var $instances, $images, $keypairs, $availabilityZones;
	var $addresses, $securityGroups;
	var $instanceTypes;
	var $volumes;

	/**
	 * @param  $credentials
	 */
	function __construct( $credentials, $project='' ) {
		$this->credentials = $credentials;
		$this->configureConnection( $project );
		$this->instances = array();
	}

	/**
	 * @param  $project
	 * @return null
	 */
	function configureConnection( $project='' ) {
		global $wgOpenStackManagerNovaDisableSSL, $wgOpenStackManagerNovaServerName,
			$wgOpenStackManagerNovaPort, $wgOpenStackManagerNovaResourcePrefix,
			$wgOpenStackManagerNovaDefaultProject;

		if ( $project == '' ) {
			$project = $wgOpenStackManagerNovaDefaultProject;
		}
		$this->novaConnection = new AmazonEC2( $this->credentials['accessKey'] . ':' . $project, $this->credentials['secretKey'] );
		$this->novaConnection->disable_ssl( $wgOpenStackManagerNovaDisableSSL );
		$this->novaConnection->set_hostname( $wgOpenStackManagerNovaServerName, $wgOpenStackManagerNovaPort );
		$this->novaConnection->set_resource_prefix( $wgOpenStackManagerNovaResourcePrefix );
		$this->novaConnection->allow_hostname_override(false);
	}

	/**
	 * @param  $ip
	 * @return null
	 */
	function getAddress( $ip ) {
		$this->getAddresses();
		if ( isset( $this->addresses["$ip"] ) ) {
			return $this->addresses["$ip"];
		} else {
			return null;
		}
	}

	/**
	 * @return
	 */
	function getAddresses() {
		$this->addresses = array();
		$response = $this->novaConnection->describe_addresses();
		$addresses = $response->body->addressesSet->item;
		foreach ( $addresses as $address ) {
			$address = new OpenStackNovaAddress( $address );
			$ip = $address->getPublicIp();
			$this->addresses["$ip"] = $address;
		}
		return $this->addresses;
	}

	/**
	 * @param  $instanceId
	 * @return null|OpenStackNovaInstance
	 */
	function getInstance( $instanceId ) {
		$this->getInstances();
		if ( isset( $this->instances["$instanceId"] ) ) {
			return $this->instances["$instanceId"];
		} else {
			return null;
		}
	}

	/**
	 * @return array
	 */
	function getInstances() {
		$this->instances = array();
		$response = $this->novaConnection->describe_instances();
		$instances = $response->body->reservationSet->item;
		foreach ( $instances as $instance ) {
			$instance = new OpenStackNovaInstance( $instance, true );
			$instanceId = $instance->getInstanceId();
			$this->instances["$instanceId"] = $instance;
		}
		return $this->instances;
	}

	/**
	 * @return OpenStackNovaInstanceType
	 */
	function getInstanceType( $instanceType ) {
		$this->getInstanceTypes( false );
		if ( isset( $this->instanceTypes["$instanceType"] ) ) {
			return $this->instanceTypes["$instanceType"];
		} else {
			return null;
		}
	}

	/**
	 * @param  $sort
	 * @return array
	 */
	function getInstanceTypes( $sort = true ) {
		global $wgOpenStackManagerNovaResourcePrefix;
		global $wgOpenStackManagerNovaAdminResourcePrefix;

		$this->novaConnection->set_resource_prefix( $wgOpenStackManagerNovaAdminResourcePrefix );
		$response = $this->novaConnection->authenticate( 'DescribeInstanceTypes', array(), $this->novaConnection->hostname );
		$instanceTypes = $response->body->instanceTypeSet->item;
		foreach ( $instanceTypes as $instanceType ) {
			$instanceType = new OpenStackNovaInstanceType( $instanceType );
			$instanceTypeName = $instanceType->getInstanceTypeName();
			$this->instanceTypes["$instanceTypeName"] = $instanceType;
		}
		$this->novaConnection->set_resource_prefix( $wgOpenStackManagerNovaResourcePrefix );
		if ( $sort ) {
			OpenStackNovaInstanceType::sort( $this->instanceTypes );
		}
		return $this->instanceTypes;
	}

	/**
	 * @return
	 */
	function getImages() {
		$this->images = array();
		$images = $this->novaConnection->describe_images();
		$images = $images->body->imagesSet->item;
		foreach ( $images as $image ) {
			$image = new OpenStackNovaImage( $image );
			$imageId = $image->getImageId();
			$this->images["$imageId"] = $image;
		}
		return $this->images;
	}

	# TODO: make this user specific
	/**
	 * @return
	 */
	function getKeypairs() {
		$this->keypairs = array();
		$response = $this->novaConnection->describe_key_pairs();
		$keypairs = $response->body->keypairsSet->item;
		foreach ( $keypairs as $keypair ) {
			$keypair = new OpenStackNovaKeypair( $keypair );
			$keyname = $keypair->getKeyName();
			$this->keypairs["$keyname"] = $keypair;
		}
		return $this->keypairs;
	}

	/**
	 * @return
	 */
	function getAvailabilityZones() {
		$this->availabilityZones = array();
		$zones = $this->novaConnection->describe_availability_zones();
		$zones = $zones->body->availabilityZoneInfo->item;
		foreach ( $zones as $zone ) {
			if ( $zone->zoneState == "available" ) {
				$this->availabilityZones["$zone->zoneName"] = $zone;
			}
		}
		return $this->availabilityZones;
	}

	/**
	 * @param  $groupname
	 * @return OpenStackNovaSecurityGroup
	 */
	function getSecurityGroup( $groupname, $project ) {
		$this->getSecurityGroups();
		if ( isset( $this->securityGroups["$project-$groupname"] ) ) {
			return $this->securityGroups["$project-$groupname"];
		} else {
			return null;
		}
	}

	/**
	 * @return
	 */
	function getSecurityGroups() {
		$this->securityGroups = array();
		$securityGroups = $this->novaConnection->describe_security_groups();
		$securityGroups = $securityGroups->body->securityGroupInfo->item;
		foreach ( $securityGroups as $securityGroup ) {
			$securityGroup = new OpenStackNovaSecurityGroup( $securityGroup );
			$project = $securityGroup->getOwner();
			$groupname = $securityGroup->getGroupName();
			$this->securityGroups["$project-$groupname"] = $securityGroup;
		}
		return $this->securityGroups;
	}

	/**
	 * Get the console output of an instance
	 *
	 * @param $instanceid string
	 * @return string
	 */
	function getConsoleOutput( $instanceid ) {
		$consoleOutput = $this->novaConnection->get_console_output( $instanceid, array() );
		return (string)$consoleOutput->body->output;
	}

	/**
	 * @param  $volumeId
	 * @return null|OpenStackNovaVolume
	 */
	function getVolume( $volumeId ) {
		$this->getVolumes();
		if ( isset( $this->volumes["$volumeId"] ) ) {
			return $this->volumes["$volumeId"];
		} else {
			return null;
		}
	}

	/**
	 * Get all volumes
	 *
	 * @return array
	 */
	function getVolumes() {
		$this->volumes = array();
		$volumes = $this->novaConnection->describe_volumes();
		$volumes = $volumes->body->volumeSet->item;
		foreach ( $volumes as $volume ) {
			$volume = new OpenStackNovaVolume( $volume );
			$volumeId = $volume->getVolumeId();
			$this->volumes["$volumeId"] = $volume;
		}
		return $this->volumes;
	}

	/**
	 * @param  $instanceName
	 * @param  $image
	 * @param  $key
	 * @param  $instanceType
	 * @param  $availabilityZone
	 * @param  $groups
	 * @return null|OpenStackNovaInstance
	 */
	function createInstance( $instanceName, $image, $key, $instanceType, $availabilityZone, $groups ) {
		global $wgOpenStackManagerInstanceUserData;

		$options = array();
		if ( $key ) {
			$options['KeyName'] = $key;
		}
		$options['InstanceType'] = $instanceType;
		$options['Placement.AvailabilityZone'] = $availabilityZone;
		$options['DisplayName'] = $instanceName;
		if ( $wgOpenStackManagerInstanceUserData ) {
			$random_hash = md5(date('r', time()));
			$endl = $this->getLineEnding();
			$boundary = '===============' . $random_hash .'==';
			$userdata = 'Content-Type: multipart/mixed; boundary="' . $boundary .'"' . $endl;
			$userdata .= 'MIME-Version: 1.0' . $endl;
			$boundary = '--' . $boundary;
			$userdata .= $endl;
			$userdata .= $boundary;
			if ( $wgOpenStackManagerInstanceUserData['cloud-config'] ) {
				$userdata .= $endl . $this->getAttachmentMime( Spyc::YAMLDump( $wgOpenStackManagerInstanceUserData['cloud-config'] ), 'text/cloud-config', 'cloud-config.txt' );
				$userdata .= $endl . $boundary;
			}
			if ( $wgOpenStackManagerInstanceUserData['scripts'] ) {
				foreach ( $wgOpenStackManagerInstanceUserData['scripts'] as $scriptname => $script ) {
					wfSuppressWarnings();
					$stat = stat( $script );
					wfRestoreWarnings();
					if ( ! $stat ) {
						continue;
					}
					$scripttext = file_get_contents( $script );
					$userdata .= $endl . $this->getAttachmentMime( $scripttext, 'text/x-shellscript', $scriptname );
					$userdata .= $endl . $boundary;
				}
			}
			if ( $wgOpenStackManagerInstanceUserData['upstarts'] ) {
				foreach ( $wgOpenStackManagerInstanceUserData['upstarts'] as $upstartname => $upstart ) {
					wfSuppressWarnings();
					$stat = stat( $upstart );
					wfRestoreWarnings();
					if ( ! $stat ) {
						continue;
					}
					$upstarttext = file_get_contents( $upstart );
					$userdata .= $endl . $this->getAttachmentMime( $upstarttext, 'text/upstart-job', $upstartname );
					$userdata .= $endl . $boundary;
				}
			}
			$userdata .= '--';
			$options['UserData'] = base64_encode( $userdata );
		}
		if ( count( $groups ) > 1 ) {
			$options['SecurityGroup'] = $groups;
		} elseif ( count( $groups ) == 1 ) {
			$options['SecurityGroup'] = $groups[0];
		}
		# 1, 1 is min and max number of instances to create.
		# We never want to make more than one at a time.
		$response = $this->novaConnection->run_instances( $image, 1, 1, $options );
		if ( ! $response->isOK() ) {
			return null;
		}
		$instance = new OpenStackNovaInstance( $response->body );
		$instanceId = $instance->getInstanceId();
		$this->instances["$instanceId"] = $instance;

		return $instance;
	}

	function getAttachmentMime( $attachmenttext, $mimetype, $filename ) {
			$endl = $this->getLineEnding();
			$attachment = 'Content-Type: ' . $mimetype . '; charset="us-ascii"'. $endl;
			$attachment .= 'MIME-Version: 1.0' . $endl;
			$attachment .= 'Content-Transfer-Encoding: 7bit' . $endl;
			$attachment .= 'Content-Disposition: attachment; filename="' . $filename . '"' . $endl;
			$attachment .= $endl;
			$attachment .= $attachmenttext;
			return $attachment;
	}

	function getLineEnding() {
		if ( wfIsWindows() ) {
			return "\r\n";
		} else {
			return "\n";
		}
	}

	/**
	 * @param  $instanceId
	 * @return
	 */
	function terminateInstance( $instanceId ) {
		$this->getAddresses();
		foreach ( $this->addresses as $address ) {
			if ( $address->getInstanceId() == $instanceId ) {
				$this->disassociateAddress( $address->getPublicIP() );
			}
		}
		$response = $this->novaConnection->terminate_instances( $instanceId );

		return $response->isOK();
	}

	/**
	 * @param  $groupname
	 * @param  $description
	 * @return null|OpenStackNovaSecurityGroup
	 */
	function createSecurityGroup( $groupname, $description ) {
		$response = $this->novaConnection->create_security_group( $groupname, $description );
		if ( ! $response->isOK() ) {
			return null;
		}
		$securityGroup = new OpenStackNovaSecurityGroup( $response->body->securityGroupSet->item );
		$groupname = $securityGroup->getGroupName();
		$this->securityGroups["$groupname"] = $securityGroup;

		return $securityGroup;
	}

	/**
	 * @param  $groupname
	 * @return
	 */
	function deleteSecurityGroup( $groupname ) {
		$response = $this->novaConnection->delete_security_group( $groupname );

		return $response->isOK();
	}

	/**
	 * @param  $groupname
	 * @param string $fromport
	 * @param string $toport
	 * @param string $protocol
	 * @param array $ranges
	 * @param array $groups
	 * @return
	 */
	function addSecurityGroupRule( $groupname, $fromport='', $toport='', $protocol='', $ranges=array(), $groups=array() ) {
		# TODO: Currently this method had commented out sections that use the AWS SDK
		# recommended method of adding security group rules. When lp704645 is fixed, switch
		# to using this method.
		$rule = array();
		$rule['GroupName'] = $groupname;
		if ( $fromport ) {
			$rule['FromPort'] = $fromport;
		}
		if ( $toport ) {
			$rule['ToPort'] = $toport;
		}
		if ( $protocol ) {
			$rule['IpProtocol'] = $protocol;
		}
		if ( $ranges ) {
			foreach ( $ranges as $range ) {
				#$rule['IpRanges'][] = array( 'CidrIp' => $range );
				$rule['CidrIp'] = $range;
			}
		}
		if ( $groups ) {
			foreach ( $groups as $group ) {
				#$rule['Groups'][] = array( 'GroupName' => $group['groupname'], 'UserId' => $group['project'] );
				$rule['SourceSecurityGroupName'] = $group['groupname'];
				$rule['SourceSecurityGroupOwnerId'] = $group['project'];
			}
		}
		#$permissions = array( 'IpPermissions' => array( $rule ) );
		#$response = $this->novaConnection->authorize_security_group_ingress( $permissions );
		$response = $this->novaConnection->authorize_security_group_ingress( $rule );

		return $response->isOK();
	}

	/**
	 * @param  $groupname
	 * @param string $fromport
	 * @param string $toport
	 * @param string $protocol
	 * @param array $ranges
	 * @param array $groups
	 * @return
	 */
	function removeSecurityGroupRule( $groupname, $fromport='', $toport='', $protocol='', $ranges=array(), $groups=array() ) {
		# TODO: Currently this method had commented out sections that use the AWS SDK
		# recommended method of removing security group rules. When lp704645 is fixed, switch
		# to using this method.
		$rule = array();
		$rule['GroupName'] = $groupname;
		if ( $fromport ) {
			$rule['FromPort'] = $fromport;
		}
		if ( $toport ) {
			$rule['ToPort'] = $toport;
		}
		if ( $protocol ) {
			$rule['IpProtocol'] = $protocol;
		}
		if ( $ranges ) {
			foreach ( $ranges as $range ) {
				#$rule['IpRanges'][] = array( 'CidrIp' => $range );
				$rule['CidrIp'] = $range;
			}
		}
		if ( $groups ) {
			foreach ( $groups as $group ) {
				#$rule['Groups'][] = array( 'GroupName' => $group['groupname'], 'UserId' => $group['project'] );
				$rule['SourceSecurityGroupName'] = $group['groupname'];
				$rule['SourceSecurityGroupOwnerId'] = $group['project'];
			}
		}
		#$permissions = array( 'IpPermissions' => array( $rule ) );
		#$response = $this->novaConnection->revoke_security_group_ingress( $permissions );
		$response = $this->novaConnection->revoke_security_group_ingress( $rule );
		return $response->isOK();
	}

	/**
	 * @param  $keyName
	 * @param  $key
	 * @return OpenStackNovaKeypair
	 */
	function importKeyPair( $keyName, $key ) {
		$response = $this->novaConnection->import_key_pair( $keyName, $key );

		$keypair = new OpenStackNovaKeypair( $response->body );
		$keyName = $keypair->getKeyName();
		$this->keypairs["$keyName"] = $keypair;

		return $keypair;
	}

	/**
	 * @return null|OpenStackNovaAddress
	 */
	function allocateAddress() {
		$response = $this->novaConnection->allocate_address();
		if ( ! $response->isOK() ) {
			return null;
		} else {
			$address = new OpenStackNovaAddress( $response->body );
			$ip = $address->getPublicIP();
			$this->addresses["$ip"] = $address;
			return $address;
		}
	}

	/**
	 * @param  $ip
	 * @return
	 */
	function releaseAddress( $ip ) {
		$response = $this->novaConnection->release_address( array( 'PublicIp' => $ip ) );

		return $response->isOK();
	}

	/**
	 * @param  $instanceid
	 * @param  $ip
	 * @return null|OpenStackNovaAddress
	 */
	function associateAddress( $instanceid, $ip ) {
		$response = $this->novaConnection->associate_address( $instanceid, $ip );
		if ( ! $response->isOK() ) {
			return null;
		} else {
			$address = new OpenStackNovaAddress( $response->body->addressSet->item );
			$this->addresses["$ip"] = $address;
			return $address;
		}
	}

	/**
	 * @param  $ip
	 * @return
	 */
	function disassociateAddress( $ip ) {
		$response = $this->novaConnection->disassociate_address( $ip );

		return $response->isOK();
	}

	/**
	 * Create a Nova volume
	 *
	 * @param  $zone
	 * @param  $size
	 * @param  $name
	 * @param  $description
	 * @return OpenStackNovaVolume
	 */
	function createVolume( $zone, $size, $name, $description ) {
		$response = $this->novaConnection->createVolume( $zone, array(
			'Size' => (int)$size,
			'DisplayName' => $name,
			'DisplayDescription' => $description,
		));
		if ( ! $response->isOK() ) {
			return null;
		} else {
			$volume = new OpenStackNovaVolume( $response->body->volumeSet->item );
			$id = $volume->getVolumeId();
			$this->volumes["$id"] = $volume;
			return $volume;
		}
	}

	/**
	 * Delete a Nova volume
	 *
	 * @param  $volumeid
	 * @return boolean
	 */
	function deleteVolume( $volumeid ) {
		$response = $this->novaConnection->deleteVolume( $volumeid );

		return $response->isOK();
	}

	/**
	 * Attach a nova volume to the specified device on an instance
	 *
	 * @param volumeid
	 * @param instanceid
	 * @param device
	 * @return boolean
	 */
	function attachVolume( $volumeid, $instanceid, $device ) {
		$response = $this->novaConnection->attachVolume( $volumeid, $instanceid, $device );

		return $response->isOK();
	}

	/**
	 * Detaches a nova volume from an instance
	 *
	 * @param volumeid
	 * @param force
	 * @return boolean
	 */
	function detachVolume( $volumeid, $force ) {
		$opt = Array();
		if ( $force ) {
			$opt["Force"] = $force;
		}
		$response = $this->novaConnection->detachVolume( $volumeid, $opt );

		return $response->isOK();
	}

	/**
	 * Reboots an instance
	 *
	 * @param instanceid
	 * @return boolean
	 */
	function rebootInstance( $instanceid ) {
		$response = $this->novaConnection->rebootInstances( $instanceid );

		return $response->isOK();
	}

}

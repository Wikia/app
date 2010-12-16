<?php
    /**
    * Calculate
    * Handling of the SST continue blocks is complicated by the need to include an
    * additional continuation byte depending on whether the string is split between
    * blocks or whether it starts at the beginning of the block. (There are also
    * additional complications that will arise later when/if Rich Strings are
    * supported).
    *
    * @access private
    */
    function _calculateSharedStringsSizes()
    {
        /* Iterate through the strings to calculate the CONTINUE block sizes.
           For simplicity we use the same size for the SST and CONTINUE records:
           8228 : Maximum Excel97 block size
             -4 : Length of block header
             -8 : Length of additional SST header information
		     -8 : Arbitrary number to keep within _add_continue() limit
         = 8208
        */
        $continue_limit     = 8208;
        $block_length       = 0;
        $written            = 0;
        $this->_block_sizes = array();
        $continue           = 0;

        foreach (array_keys($this->_str_table) as $string) {
            $string_length = strlen($string);
			$headerinfo    = unpack("vlength/Cencoding", $string);
			$encoding      = $headerinfo["encoding"];
			$split_string  = 0;

            // Block length is the total length of the strings that will be
            // written out in a single SST or CONTINUE block.
            $block_length += $string_length;

            // We can write the string if it doesn't cross a CONTINUE boundary
            if ($block_length < $continue_limit) {
                $written      += $string_length;
                continue;
            }

            // Deal with the cases where the next string to be written will exceed
            // the CONTINUE boundary. If the string is very long it may need to be
            // written in more than one CONTINUE record.
            while ($block_length >= $continue_limit) {

                // We need to avoid the case where a string is continued in the first
                // n bytes that contain the string header information.
                $header_length   = 3; // Min string + header size -1
                $space_remaining = $continue_limit - $written - $continue;


                /* TODO: Unicode data should only be split on char (2 byte)
                boundaries. Therefore, in some cases we need to reduce the
                amount of available
                */
				$align = 0;

				# Only applies to Unicode strings
				if ($encoding == 1) {
					# Min string + header size -1
					$header_length = 4;

					if ($space_remaining > $header_length) {
						# String contains 3 byte header => split on odd boundary
						if (!$split_string && $space_remaining % 2 != 1) {
							$space_remaining--;
							$align = 1;
						}
						# Split section without header => split on even boundary
						else if ($split_string && $space_remaining % 2 == 1) {
							$space_remaining--;
							$align = 1;
						}

						$split_string = 1;
					}
				}


                if ($space_remaining > $header_length) {
                    // Write as much as possible of the string in the current block
                    $written      += $space_remaining;

                    // Reduce the current block length by the amount written
                    $block_length -= $continue_limit - $continue - $align;

                    // Store the max size for this block
                    $this->_block_sizes[] = $continue_limit - $align;

                    // If the current string was split then the next CONTINUE block
                    // should have the string continue flag (grbit) set unless the
                    // split string fits exactly into the remaining space.
                    if ($block_length > 0) {
                        $continue = 1;
                    } else {
                        $continue = 0;
                    }
                } else {
                    // Store the max size for this block
                    $this->_block_sizes[] = $written + $continue;

                    // Not enough space to start the string in the current block
                    $block_length -= $continue_limit - $space_remaining - $continue;
                    $continue = 0;

                }

                // If the string (or substr) is small enough we can write it in the
                // new CONTINUE block. Else, go through the loop again to write it in
                // one or more CONTINUE blocks
                if ($block_length < $continue_limit) {
                    $written = $block_length;
                } else {
                    $written = 0;
                }
            }
        }

        // Store the max size for the last block unless it is empty
        if ($written + $continue) {
            $this->_block_sizes[] = $written + $continue;
        }


        /* Calculate the total length of the SST and associated CONTINUEs (if any).
         The SST record will have a length even if it contains no strings.
         This length is required to set the offsets in the BOUNDSHEET records since
         they must be written before the SST records
        */

		$tmp_block_sizes = array();
		$tmp_block_sizes = $this->_block_sizes;

		$length  = 12;
		if (!empty($tmp_block_sizes)) {
			$length += array_shift($tmp_block_sizes); # SST
		}
		while (!empty($tmp_block_sizes)) {
			$length += 4 + array_shift($tmp_block_sizes); # CONTINUEs
		}

		return $length;
    }

    /**
    * Write all of the workbooks strings into an indexed array.
    * See the comments in _calculate_shared_string_sizes() for more information.
    *
    * The Excel documentation says that the SST record should be followed by an
    * EXTSST record. The EXTSST record is a hash table that is used to optimise
    * access to SST. However, despite the documentation it doesn't seem to be
    * required so we will ignore it.
    *
    * @access private
    */
    function _storeSharedStringsTable()
    {
        $record  = 0x00fc;  // Record identifier
		$length  = 0x0008;  // Number of bytes to follow
		$total   = 0x0000;

        // Iterate through the strings to calculate the CONTINUE block sizes
        $continue_limit = 8208;
        $block_length   = 0;
        $written        = 0;
        $continue       = 0;

        // sizes are upside down
		$tmp_block_sizes = $this->_block_sizes;
//        $tmp_block_sizes = array_reverse($this->_block_sizes);

		# The SST record is required even if it contains no strings. Thus we will
		# always have a length
		#
		if (!empty($tmp_block_sizes)) {
			$length = 8 + array_shift($tmp_block_sizes);
		}
		else {
			# No strings
			$length = 8;
		}



        // Write the SST block header information
        $header      = pack("vv", $record, $length);
        $data        = pack("VV", $this->_str_total, $this->_str_unique);
        $this->_append($header . $data);




        /* TODO: not good for performance */
        foreach (array_keys($this->_str_table) as $string) {

            $string_length = strlen($string);
			$headerinfo    = unpack("vlength/Cencoding", $string);
			$encoding      = $headerinfo["encoding"];
            $split_string  = 0;

            // Block length is the total length of the strings that will be
            // written out in a single SST or CONTINUE block.
            //
            $block_length += $string_length;


            // We can write the string if it doesn't cross a CONTINUE boundary
            if ($block_length < $continue_limit) {
                $this->_append($string);
                $written += $string_length;
                continue;
            }

            // Deal with the cases where the next string to be written will exceed
            // the CONTINUE boundary. If the string is very long it may need to be
            // written in more than one CONTINUE record.
            //
            while ($block_length >= $continue_limit) {

                // We need to avoid the case where a string is continued in the first
                // n bytes that contain the string header information.
                //
                $header_length   = 3; // Min string + header size -1
                $space_remaining = $continue_limit - $written - $continue;


                // Unicode data should only be split on char (2 byte) boundaries.
                // Therefore, in some cases we need to reduce the amount of available
	            // space by 1 byte to ensure the correct alignment.
    	        $align = 0;

				// Only applies to Unicode strings
				if ($encoding == 1) {
					// Min string + header size -1
					$header_length = 4;

					if ($space_remaining > $header_length) {
						// String contains 3 byte header => split on odd boundary
						if (!$split_string && $space_remaining % 2 != 1) {
							$space_remaining--;
							$align = 1;
						}
						// Split section without header => split on even boundary
						else if ($split_string && $space_remaining % 2 == 1) {
							$space_remaining--;
							$align = 1;
						}

						$split_string = 1;
					}
				}


                if ($space_remaining > $header_length) {
                    // Write as much as possible of the string in the current block
                    $tmp = substr($string, 0, $space_remaining);
                    $this->_append($tmp);

                    // The remainder will be written in the next block(s)
                    $string = substr($string, $space_remaining);

                    // Reduce the current block length by the amount written
                    $block_length -= $continue_limit - $continue - $align;

                    // If the current string was split then the next CONTINUE block
                    // should have the string continue flag (grbit) set unless the
                    // split string fits exactly into the remaining space.
                    //
                    if ($block_length > 0) {
                        $continue = 1;
                    } else {
                        $continue = 0;
                    }
                } else {
                    // Not enough space to start the string in the current block
                    $block_length -= $continue_limit - $space_remaining - $continue;
                    $continue = 0;
                }

                // Write the CONTINUE block header
                if (!empty($this->_block_sizes)) {
                    $record  = 0x003C;
                    $length  = array_shift($tmp_block_sizes);

                    $header  = pack('vv', $record, $length);
                    if ($continue) {
                        $header .= pack('C', $encoding);
                    }
                    $this->_append($header);
                }

                // If the string (or substr) is small enough we can write it in the
                // new CONTINUE block. Else, go through the loop again to write it in
                // one or more CONTINUE blocks
                //
                if ($block_length < $continue_limit) {
                    $this->_append($string);
                    $written = $block_length;
                } else {
                    $written = 0;
                }
            }
        }
    }
  
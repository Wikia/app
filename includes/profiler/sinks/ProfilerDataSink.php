<?php

interface ProfilerDataSink {

	public function send( ProfilerData $data );

}
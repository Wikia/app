<?php

class ActionBox extends SpecialPage {
        function __construct() {
                parent::__construct('ActionBox');
        }

        function execute() {
                global $wgRequest, $wgHooks, $wgOut;
                $this->setHeaders();
        }



<?php

abstract class layoutWidgetBoxe {
    abstract protected function renderForEditor();
    abstract protected function renderForForm();
    abstract protected function renderResult();

    abstract protected function getOptions();

    public function serializa() {

    }

    public function unserializa() {

    }
}

?>
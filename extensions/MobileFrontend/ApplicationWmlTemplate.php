<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class ApplicationWmlTemplate extends MobileFrontendTemplate {

	public function getHTML() {
		$mainPageUrl = $this->data['mainPageUrl'];
		$randomPageUrl = $this->data['randomPageUrl'];
		$dir = $this->data['dir'];
		$code = $this->data['code'];

		$applicationHtml = <<<HTML
		<?xml version='1.0' encoding='utf-8' ?>
			<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.3//EN"
			"http://www.wapforum.org/DTD/wml13.dtd">
			<wml xml:lang="{$code}" dir="{$dir}">
			<template>
			<do name="home" type="options" label="{$this->data['homeButton']}" >
			 <go href="{$mainPageUrl}"/>
			</do>
			<do name="random" type="options" label="{$this->data['randomButton']}">
			 <go href="{$randomPageUrl}"/>
			</do>
			</template>
			{$this->data['contentHtml']}
			</wml>
HTML;
		return $applicationHtml;
	}
}

<?php
class SpecialDiagnosis extends SpecialPage {
		function __construct() {
				parent::__construct( 'Diagnosis', 'diagnosis-access' );
		}
		function execute( $par ) {
				global $wgRequest, $wgOut, $wgShellLocale, $wgImageMagickConvertCommand ,$wgSVGConverterPath, $wgSVGConverters;

				$this->setHeaders();

				$wgOut->addHTML( '<table class=wikitable>' );
				$wgOut->addHTML( '<tr>' );
				$wgOut->addHTML( '<th>Parameter</th>' );
				$wgOut->addHTML( '<th>Current Value</th>' );
				$wgOut->addHTML( '<th>Expected Value</th>' );
				$wgOut->addHTML( '<th>Description</th>' );
				$wgOut->addHTML( '<th>Status</th>' );
				$wgOut->addHTML( '</tr>' );
				### System locals ###
				$wgOut->addHTML( '<tr>' );
				$wgOut->addHTML( '<td>System Locals</td>' );
				$sdSystemLocale = explode(" ",shell_exec('locale -a'));
				$wgOut->addHTML( '<td>' );
				foreach ($sdSystemLocale as $value) { 
					$wgOut->addHTML($value . '<br/>');
					} 
				$wgOut->addHTML('</td>' );
				$wgOut->addHTML( '<td>' . $wgShellLocale . '</td>' );
				$wgOut->addHTML( '<td> To make ShellLocale work it must be installed on the system </td>' );
				if ( in_array($wgShellLocale, $sdSystemLocale) ) {
					$sdSystemLocaleStatus='OK';
					} 
					else {
					$sdSystemLocaleStatus='ERROR';
					}
				$wgOut->addHTML( '<td>' . $sdSystemLocaleStatus . '</td>' );
				$wgOut->addHTML( '</tr>' );
				### ImageMagick ###
				$wgOut->addHTML( '<tr>' );
				$wgOut->addHTML( '<td>ImageMagick</td>' );
				$sdConvertPath = shell_exec('which convert');
				$wgOut->addHTML( '<td>' . $sdConvertPath . '</td>' );
				$wgOut->addHTML( '<td>' . $wgImageMagickConvertCommand . '</td>' );
				$wgOut->addHTML( '<td> Check if the command for converting Images is correct </td>' );
				if ( $sdConvertPath === $wgImageMagickConvertCommand ) {
					$sdConvertPathStatus='OK';
					} 
					else {
					$sdConvertPathStatus='ERROR';
					}
				$wgOut->addHTML( '<td>' . $sdConvertPathStatus . '</td>' );
				$wgOut->addHTML( '</tr>' );
				### RSVG ###
				$wgOut->addHTML( '<tr>' );
				$wgOut->addHTML( '<td>RSVG</td>' );
				$sdSVGPath = shell_exec('which rsvg');
				$wgOut->addHTML( '<td>' . $sdSVGPath . '</td>' );
				$wgOut->addHTML( '<td>' . $wgSVGConverterPath . '<br/>' . $wgSVGConverters['rsvg'] . '</td>' );
				$wgOut->addHTML( '<td> Check if the command for converting SVG is correct </td>' );
				if ( $sdSVGPath === $wgSVGConverterPath ) {
					$sdSVGPathStatus='OK';
					} 
					else {
					$sdSVGPathStatus='ERROR';
					}
				$wgOut->addHTML( '<td>' . $sdSVGPathStatus . '</td>' );
				$wgOut->addHTML( '</tr>' );
				### PHP Extensions ###
				$wgOut->addHTML( '<tr>' );
				$wgOut->addHTML( '<td>PHP Extensions</td>' );
				$sdPHPExtensions = get_loaded_extensions();
				$wgOut->addHTML( '<td>' );
				foreach ($sdPHPExtensions as $value) { 
					$wgOut->addHTML($value . '<br/>');
					} 
				$wgOut->addHTML('</td>' );
				$wgOut->addHTML( '<td> Minimum:<br/>SPL<br/>pcre</td>' );
				$wgOut->addHTML( '<td> Loaded PHP Extensions </td>' );
				if ( in_array('SPL',$sdPHPExtensions) ) {
					$sdSPL = true;
				}
				else {
					$sdSPL = false;
				}
				if ( in_array('pcre',$sdPHPExtensions) ) {
					$sdpcre = true;
				}
				else {
					$sdpcre = false;
				}
				if ( $sdpcre and $sdSPL ) {
					$sdPHPStatus='OK';
					} 
					else {
					$sdPHPStatus='ERROR';
					}
				$wgOut->addHTML( '<td>' . $sdPHPStatus . '</td>' );
				$wgOut->addHTML( '</tr>' );
				
				
				### End Table ###
				$wgOut->addHTML( '</table>' );
		}
}
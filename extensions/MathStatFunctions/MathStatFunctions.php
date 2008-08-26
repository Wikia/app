<?php

if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'MathStatFunctions',
        'version' => '1.1',
        'author' => 'Carl Fürstenberg (AzaToth)',
        'description' => 'A collection of mathematical and statistical functions',
        'descriptionmsg' => 'msfunc_desc',
        'url' => 'http://www.mediawiki.org/wiki/Extension:MathStatFunctions',
);

$wgExtensionMessagesFiles['MathStatFunctions'] = dirname(__FILE__) . '/MathStatFunctions.i18n.php';
$wgExtensionFunctions[] = 'wfSetupMathStatFunctions';
$wgHooks['LanguageGetMagic'][]       = 'wfMathStatFunctionsLanguageGetMagic';

/**
 * \brief Exception class identifying that ParserFunctions is not available
 */
class ParserFunctionsNotFoundException extends Exception {
        public function __construct(){
                $this->message = "<span style=\"color: red; font-size: large;\">ERROR: ParserFunctions was not found</span>";
        }
}

class ExtMathStatFunctions {

        public function __construct() {
                if(!class_exists('ExtParserFunctions'))
                        throw new ParserFunctionsNotFoundException;
		# FIXME: Strict Standards: Non-static method ExtParserFunctions::getExprParser() should not be called statically, assuming $this from incompatible context in MathStatFunctions.php on line 34
                $this->exprParser = ExtParserFunctions::getExprParser();
        }

        public function constHook(&$parser, $key=''){
                switch($key){
                case 'pi':
                        return '3.14159265358979323846';
                        break;
                case 'pi/2':
                        return '1.57079632679489661923';
                        break;
                case 'pi/4':
                        return '0.78539816339744830962';
                        break;
                case '1/pi':
                        return '0.31830988618379067154';
                        break;
                case '2/pi':
                        return '0.63661977236758134308';
                        break;
                case 'sqrt(pi)':
                        return '1.77245385090551602729';
                        break;
                case '2/sqrt(pi)':
                        return '1.12837916709551257390';
                        break;
                case 'e':
                        return '2.7182818284590452354';
                        break;
                case 'log_2(e)':
                        return '1.4426950408889634074';
                        break;
                case 'log_10(e)':
                        return '0.43429448190325182765';
                        break;
                case 'ln(2)':
                        return '0.69314718055994530942';
                        break;
                case 'ln(10)':
                        return '2.30258509299404568402';
                        break;
                case 'sqrt(2)':
                        return '1.41421356237309504880';
                        break;
                case 'sqrt(3)':
                        return '1.73205080756887729352';
                        break;
                case '1/sqrt(2)':
                case 'sqrt(1/2)':
                        return '0.70710678118654752440';
                        break;
                case 'ln(pi)':
                        return '1.14472988584940017414';
                        break;
                case 'euler':
                        return '0.57721566490153286061';
                        break;
                case 'brion':
                        return '6'; //Brions constant
                        break;
                default:
                        return '';
                }
        }

        public function medianHook(&$parser) {
                $args = func_get_args();
                array_shift( $args );

                try{
                        foreach($args as $expr){
                                $res = $this->exprParser->doExpression($expr);
                                $values[] = $res;
                        }
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                sort($values);
                $nbr_values = count($values);
                if($nbr_values % 2 == 1){ // odd number of values
                        return $values[$nbr_values / 2];
                } else { // even number of values
                        return ($values[$nbr_values / 2 -1] + $values[$nbr_values / 2]) / 2;
                }
        }

        public function meanHook(&$parser) {
                $args = func_get_args();
                array_shift( $args );
                try{
                        foreach($args as $expr){
                                $res = $this->exprParser->doExpression($expr);
                                $values[] = $res;
                        }
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                return array_sum($values)/count($values);
        }

        public function expHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = exp($res);
                return $this->check($result);
        }

        public function lnHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = log($res);

                return $this->check($result);
        }

        public function logHook(&$parser, $expr = '' , $base = 10) {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = log($res,$base);
                return $this->check(log($res,$base));
        }

        public function tanHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = tan($res);
                return $this->check($result);
        }

        public function atanHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = atan($res);
                return $this->check($result);
        }

        public function tanhHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = tanh($res);
                return $this->check($result);
        }

        public function cosHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = cos($res);
                return $this->check($result);
        }

        public function acosHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = acos($res);
                return $this->check($result);
        }

        public function coshHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = cosh($res);
                return $this->check($result);
        }

        public function sinHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = sin($res);
                return $this->check($result);
        }

        public function asinHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = asin($res);
                return $this->check($result);
        }

        public function sinhHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = sinh($res);
                return $this->check($result);
        }

        public function atanhHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                if(function_exists('atanh')){
                        $result = atanh($res);
                } else {
                        $result = log(sqrt(1-$res^2)/(1-$res));
                }
                return $this->check($result);
        }

        public function acoshHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                if(function_exists('acosh')){
                        $result = acosh($res);
                } else {
                        $result = log($res + abs(sqrt($res^2+1))); //may be wrong
                }
                return $this->check($result);
        }

        public function asinhHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                if(function_exists('asinh')){
                        $result = asinh($res);
                } else {
                        $result = log($res + sqrt($res^2+1));
                }
                $result = asinh($res);
                return $this->check($result);
        }

        public function cotHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $tmp = tan($res);
                if($tmp == 0){
			wfLoadExtensionMessages( 'MathStatFunctions' );
                        return wfMsg('msfunc_div_zero');
                }
                $result = 1/$tmp;
                return $this->check($result);
        }

        public function secHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $tmp = cos($res);
                if($tmp == 0){
			wfLoadExtensionMessages( 'MathStatFunctions' );
                        return wfMsg('msfunc_div_zero');
                }

                $result = 1/$tmp;
                return $this->check($result);
        }

        public function cscHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $tmp = sin($res);
                if($tmp == 0){
			wfLoadExtensionMessages( 'MathStatFunctions' );
                        return wfMsg('msfunc_div_zero');
                }
                $result = 1/$tmp;
                return $this->check($result);
        }

        public function acscHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = asin(pow($res,-1));
                return $this->check($result);
        }

        public function asecHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = acos(pow($res,-1));
                return $this->check($result);
        }

        public function acotHook(&$parser, $expr = '') {
                try{
                        $res = $this->exprParser->doExpression($expr);
                } catch (ExprError $e){
                        return $e->getMessage();
                }
                $result = M_PI2 - atan($res);
                return $this->check($result);
        }

        // Private

        private $exprParser;

        private function check($value) {
                if(is_nan($value)){
			wfLoadExtensionMessages( 'MathStatFunctions' );
                        return wfMsg('msfunc_nan');
                } elseif(is_infinite($value) and false){
			wfLoadExtensionMessages( 'MathStatFunctions' );
                        return wfMsg('msfunc_inf').($value < 0 ? '-' : '+');
                } else {
                        return $value;
                }
        }
}

function wfSetupMathStatFunctions() {
        global $wgParser, $wgExtMathStatFunctions;

        try {
                $wgExtMathStatFunctions = new ExtMathStatFunctions;
        } catch (ParserFunctionsNotFoundException $e) {
                throw new FatalError('in '.$e->getFile().' on line '.$e->getLine().': '.$e->getMessage());
        }

        $wgParser->setFunctionHook( 'const', array( &$wgExtMathStatFunctions, 'constHook' ) );
        $wgParser->setFunctionHook( 'median',        array( &$wgExtMathStatFunctions, 'medianHook' ) );
        $wgParser->setFunctionHook( 'mean',          array( &$wgExtMathStatFunctions, 'meanHook' ) );
        $wgParser->setFunctionHook( 'exp',           array( &$wgExtMathStatFunctions, 'expHook' ) );
        $wgParser->setFunctionHook( 'log',           array( &$wgExtMathStatFunctions, 'logHook' ) );
        $wgParser->setFunctionHook( 'ln',            array( &$wgExtMathStatFunctions, 'lnHook' ) );
        $wgParser->setFunctionHook( 'tan',           array( &$wgExtMathStatFunctions, 'tanHook' ) );
        $wgParser->setFunctionHook( 'atan',          array( &$wgExtMathStatFunctions, 'atanHook' ) );
        $wgParser->setFunctionHook( 'tanh',          array( &$wgExtMathStatFunctions, 'tanhHook' ) );
        $wgParser->setFunctionHook( 'atanh', array( &$wgExtMathStatFunctions, 'atanhHook' ) );
        $wgParser->setFunctionHook( 'cot',           array( &$wgExtMathStatFunctions, 'cotHook' ) );
        $wgParser->setFunctionHook( 'acot',          array( &$wgExtMathStatFunctions, 'acotHook' ) );
        $wgParser->setFunctionHook( 'cos',           array( &$wgExtMathStatFunctions, 'cosHook' ) );
        $wgParser->setFunctionHook( 'acos',          array( &$wgExtMathStatFunctions, 'acosHook' ) );
        $wgParser->setFunctionHook( 'cosh',          array( &$wgExtMathStatFunctions, 'coshHook' ) );
        $wgParser->setFunctionHook( 'acosh', array( &$wgExtMathStatFunctions, 'acoshHook' ) );
        $wgParser->setFunctionHook( 'sec',           array( &$wgExtMathStatFunctions, 'secHook' ) );
        $wgParser->setFunctionHook( 'asec',          array( &$wgExtMathStatFunctions, 'asecHook' ) );
        $wgParser->setFunctionHook( 'sin',           array( &$wgExtMathStatFunctions, 'sinHook' ) );
        $wgParser->setFunctionHook( 'asin',          array( &$wgExtMathStatFunctions, 'asinHook' ) );
        $wgParser->setFunctionHook( 'sinh',          array( &$wgExtMathStatFunctions, 'sinhHook' ) );
        $wgParser->setFunctionHook( 'asinh', array( &$wgExtMathStatFunctions, 'asinhHook' ) );
        $wgParser->setFunctionHook( 'csc',           array( &$wgExtMathStatFunctions, 'cscHook' ) );
        $wgParser->setFunctionHook( 'acsc',          array( &$wgExtMathStatFunctions, 'acscHook' ) );

        return true;
}

function wfMathStatFunctionsLanguageGetMagic( &$magicWords, $langCode ) {
        global $wgMathStatFunctionsMagic;
	require_once( dirname(__FILE__) . '/MathStatFunctions.i18n.magic.php' );

        if(!in_array($langCode,$wgMathStatFunctionsMagic)) $langCode = 'en';
        $magicWords = array_merge($magicWords, $wgMathStatFunctionsMagic[$langCode]);
        return true;
}

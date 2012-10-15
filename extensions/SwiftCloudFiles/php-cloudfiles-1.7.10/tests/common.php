<?php
if ( php_sapi_name() !== 'cli' ) {
	die( "This is not a valid web entry point." );
}
if (empty($_ENV)) {
    $_ENV = $_SERVER;
}

require_once 'cloudfiles_ini.php';
set_include_path(get_include_path() . PATH_SEPARATOR . "../");
require_once 'cloudfiles.php';

error_reporting(E_ALL);

function read_callback_test($bytes)
{
    if (VERBOSE)
        print "=> read_callback_test: transferred " . $bytes . " bytes\n";
}

function write_callback_test($bytes)
{
    if (VERBOSE)
        print "=> write_callback_test: transferred " . $bytes . " bytes\n";
}

# common test utility functions
#

# re-implementation of PECL's http_date
#
function httpDate($ts=NULL)
{
    if (!$ts) {
        return gmdate("D, j M Y h:i:s T");
    } else {
        return gmdate("D, j M Y h:i:s T", $ts);
    }
}


# Specify a word length and any characters to exlude and return
# a valid UTF-8 string (within the ASCII range)
#
function genUTF8($len=10, $excludes=array())
{
    $r = "";
    while (strlen($r) < $len) {
        $c = rand(32,127); # chr() only works with ASCII (0-127)
        if (in_array($c, $excludes)) { continue; }
        $r .= chr($c); # chr() only works with ASCII (0-127)
    }
    return utf8_encode($r);
}

# generate a big string
#
function big_string($length)
{
    $r = array();
    for ($i=0; $i < $length; $i++) {
        $r[] = "a";
    }
    return join("", $r);
}

# To be used with $UTF8_TEXT return the len of $length_string of char
#  contained in $utf8_array
#
function random_utf8_string($length_string, $utf8_array)
{
    $bigtext = "";
    $random_string = "";

    foreach( $utf8_array as $lang => $text )
    {
        $bigtext .= $text;
    }

    for ($i = 0; $i < $length_string; $i++)
    {
        $random_pick = mt_rand(1, strlen($bigtext));
        $random_char=NULL;
        $random_char = trim($bigtext[$random_pick-1]);
        $random_string .= $random_char;
    }
    return utf8_encode($random_string);
}

# Some real world UTF8-TEXT
$UTF8_TEXT = 
       array("greek" =>
              "
  Σὲ γνωρίζω ἀπὸ τὴν κόψη
  τοῦ σπαθιοῦ τὴν τρομερή,
  σὲ γνωρίζω ἀπὸ τὴν ὄψη
  ποὺ μὲ βία μετράει τὴ γῆ.

  ᾿Απ᾿ τὰ κόκκαλα βγαλμένη
  τῶν ῾Ελλήνων τὰ ἱερά
  καὶ σὰν πρῶτα ἀνδρειωμένη
  χαῖρε, ὦ χαῖρε, ᾿Ελευθεριά!
",
                          "georgian"=> "
გთხოვთ ახლავე გაიაროთ რეგისტრაცია Unicode-ის მეათე საერთაშორისო
კონფერენციაზე დასასწრებად, რომელიც გაიმართება 10-12 მარტს,
ქ. მაინცში, გერმანიაში. კონფერენცია შეჰკრებს ერთად მსოფლიოს
ექსპერტებს ისეთ დარგებში როგორიცაა ინტერნეტი და Unicode-ი,
ინტერნაციონალიზაცია და ლოკალიზაცია, Unicode-ის გამოყენება
ოპერაციულ სისტემებსა, და გამოყენებით პროგრამებში, შრიფტებში,
ტექსტების დამუშავებასა და მრავალენოვან კომპიუტერულ სისტემებში.
",
                          
                          "thai" => "
 ๏ แผ่นดินฮั่นเสื่อมโทรมแสนสังเวช  พระปกเกศกองบู๊กู้ขึ้นใหม่
  สิบสองกษัตริย์ก่อนหน้าแลถัดไป       สององค์ไซร้โง่เขลาเบาปัญญา
    ทรงนับถือขันทีเป็นที่พึ่ง           บ้านเมืองจึงวิปริตเป็นนักหนา
  โฮจิ๋นเรียกทัพทั่วหัวเมืองมา         หมายจะฆ่ามดชั่วตัวสำคัญ
    เหมือนขับไสไล่เสือจากเคหา      รับหมาป่าเข้ามาเลยอาสัญ
  ฝ่ายอ้องอุ้นยุแยกให้แตกกัน          ใช้สาวนั้นเป็นชนวนชื่นชวนใจ
    พลันลิฉุยกุยกีกลับก่อเหตุ          ช่างอาเพศจริงหนาฟ้าร้องไห้
  ต้องรบราฆ่าฟันจนบรรลัย           ฤๅหาใครค้ำชูกู้บรรลังก์ ฯ
",
                          "ethiopian" => "
  ሰማይ አይታረስ ንጉሥ አይከሰስ።
  ብላ ካለኝ እንደአባቴ በቆመጠኝ።
  ጌጥ ያለቤቱ ቁምጥና ነው።
  ደሀ በሕልሙ ቅቤ ባይጠጣ ንጣት በገደለው።
  የአፍ ወለምታ በቅቤ አይታሽም።
  አይጥ በበላ ዳዋ ተመታ።
  ሲተረጉሙ ይደረግሙ።
  ቀስ በቀስ፥ ዕንቁላል በእግሩ ይሄዳል።
  ድር ቢያብር አንበሳ ያስር።
  ሰው እንደቤቱ እንጅ እንደ ጉረቤቱ አይተዳደርም።
  እግዜር የከፈተውን ጉሮሮ ሳይዘጋው አይድርም።
  የጎረቤት ሌባ፥ ቢያዩት ይስቅ ባያዩት ያጠልቅ።
  ሥራ ከመፍታት ልጄን ላፋታት።
  ዓባይ ማደሪያ የለው፥ ግንድ ይዞ ይዞራል።
  የእስላም አገሩ መካ የአሞራ አገሩ ዋርካ።
  ተንጋሎ ቢተፉ ተመልሶ ባፉ።
  ወዳጅህ ማር ቢሆን ጨርስህ አትላሰው።
  እግርህን በፍራሽህ ልክ ዘርጋ።
",
             "yidish" => "איך קען עסן גלאָז און עס טוט מיר נישט װײ",
             "braille" => "⠊⠀⠉⠁⠝⠀⠑⠁⠞⠀⠛⠇⠁⠎⠎⠀⠁⠝⠙⠀⠊⠞⠀⠙⠕⠑⠎⠝⠞⠀⠓⠥⠗⠞⠀⠍⠑",
             "chinese" => "
大云寺赞公房四首 (一)
心在水精域
衣沾春雨时
洞门尽徐步
深院果幽期
到扉开复闭
撞钟斋及兹
醍醐长发性
饮食过扶衰
把臂有多日
开怀无愧辞
黄鹂度结构
紫鸽下罘罳
愚意会所适
花边行自迟
汤休起我病
微笑索题诗
",
             "japanese" => "
射ハ兵器ノ長なり。
三才ニ法レリ。
孔子曰ク射ハ君子似有乎。
正鵠失諸　反テ其身ニ諸求。
",
           );

function debug($texto){
    file_put_contents('/tmp/quick-cf-api.log',date('d/m/Y H:i:s').' - '.$texto."\n",FILE_APPEND);
}

/**
   * Get the temporary directory abstracted of the OS
   *
   */
function get_tmpdir() {
    if (isset($_ENV['TMP']))
        return realpath($_ENV['TMP']);
    if (isset($_ENV['TMPDIR']))
        return realpath( $_ENV['TMPDIR']);
    if (isset($_ENV['TEMP']))
        return realpath( $_ENV['TEMP']);

    $tempfile=tempnam(uniqid(rand(),TRUE),'');
    if (file_exists($tempfile)) 
        unlink($tempfile);
    return realpath(dirname($tempfile));
}

?>

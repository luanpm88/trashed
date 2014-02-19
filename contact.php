<?php
/**
 *      [PHPB2B] Copyright (C) 2007-2099, Ualink Inc. All Rights Reserved.
 *      The contents of this file are subject to the License; you may not use this file except in compliance with the License. 
 *
 *      @version $Revision: 2258 $
 */
session_start();
define('CURSCRIPT', 'register');
require("libraries/common.inc.php");
require("share.inc.php");
require(PHPB2B_ROOT."libraries/sendmail.inc.php");
require(LIB_PATH.'passport.class.php');
require(CACHE_LANG_PATH."lang_emails.php");

global $G;


//echo $G["service_email"];

if(isset($_POST['send']))
{
    
    setvar("sender_name", $_POST['sender_name']);
    setvar("sender_email", $_POST['sender_email']);
    setvar("message", $_POST['letter_text']);    
    $sended = pb_sendmail(array("xperiathinh@gmail.com", "Liên hệ"), $_POST['letter_subject'], "contact");
    
    if($sended)
    {
        setvar("success", 1);
    }
}

$tpl_file = "contact";
render($tpl_file);
<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'].'/include/AccountManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/Constants.php';


function saveLoginDataInACookie(){
    $cookie_life_time_seconds=365*24*60*60;
    setcookie(DBContract::$Users_RememberMe, isset($_POST[DBContract::$Users_RememberMe]),time()+$cookie_life_time_seconds,'/','',false,true);
    setcookie(DBContract::$Users_RememberMe_Email,$_POST[DBContract::$Users_Col_Email],time()+$cookie_life_time_seconds,'/','',false,true);
    setcookie(AccountManager::IS_ADMIN_KEY,isset($_POST[AccountManager::IS_ADMIN_KEY]),time()+$cookie_life_time_seconds,'/','',false,true);
    setcookie(DBContract::$Users_RememberMe_Pass,$_POST[DBContract::$Users_Password],time()+$cookie_life_time_seconds,'/','',false,true);

}
function deleteLoginDataInCookie(){
    setcookie(DBContract::$Users_RememberMe,'',time()-10);
    setcookie(DBContract::$Users_RememberMe_Email,'',time()-10);
    setcookie(AccountManager::IS_ADMIN_KEY,'',time()-10);
    setcookie(DBContract::$Users_RememberMe_Pass,'',time()-10);

}
function loadLoggingDataFromACookie(){
    $GLOBALS[DBContract::$Users_RememberMe_Email]=$_COOKIE[DBContract::$Users_RememberMe_Email]??null;
    $GLOBALS[DBContract::$Users_RememberMe_Pass]=$_COOKIE[DBContract::$Users_RememberMe_Pass]??null;
    $GLOBALS[DBContract::$Users_RememberMe]=$_COOKIE[DBContract::$Users_RememberMe]??false;
    $GLOBALS[AccountManager::IS_ADMIN_KEY]=$_COOKIE[AccountManager::IS_ADMIN_KEY]??null;
}
function printMessageIfexists($optionalCssClassForTheAlert=''){
    if(isset($_GET[MESSAGE_TXT_KEY])){?>
        <div class="alert alert-<?=
        (isset($_GET[MESSAGE_TYPE_KEY]) ?($_GET[MESSAGE_TYPE_KEY]==MESSAGE_TYPE_SUCCESS?'success':'danger'):'warning').' '.$optionalCssClassForTheAlert ?>">
            <?= $_GET[MESSAGE_TXT_KEY] ?? ''?>
        </div>
        <?php
    }
}
function redirectWithMessage($url,$messageType,$message){
    header("location:$url".(strpos($url,'?')!==false?'&':'?').MESSAGE_TXT_KEY.'='.$message.'&'.MESSAGE_TYPE_KEY.'='.$messageType);
    exit();
}
function getUrlFor($url_relative_to_root):string{
    return "http://" . $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$url_relative_to_root;
}

<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/include/Constants.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/AccountManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/DBManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/InputValidator.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/utils.php';

header('Content-Type: application/json; charset=utf-8');
$response=array();

function setResponseMainInfo($msg, $responseCode){
    global $response;
    http_response_code($responseCode);
    $response[Constants::API_MSG_KEY]=$msg;
}

$am=AccountManager::getInstance();
$db_manager=DBManager::getInstance();
if(!isset($_GET[Constants::ACTION_KEY])){
    setResponseMainInfo('Please specify an action',400);
    exit(json_encode($response));
}
/*
 * TODO:: uncomment this later to allow login protection
if(!$am->isLoggedIn()){
    setResponseMainInfo('you are not logged in',400);
    exit(json_encode($response));
}*/
if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_SIGNUP) {
    //processing submitted data
    if (AreAllStudentSignUpFieldsSet()
        and InputValidator::validatePasswordsMatch($_POST[Constants::Users_Password], $_POST[Constants::Users_Password2])
        and InputValidator::validateUserNameExists($_POST[Constants::Users_Col_UserName])
    ) {
        http_response_code(200);
        //TODO:: insert the user in database based on the supplied data
        $response[Constants::API_MSG_KEY]='account created successfully';
    }else{
        $response[Constants::API_MSG_KEY]='failed to crate your account';
    }
}else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_LOGIN){
    //let's login
}else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_ADD_CONTACT){
    //let's add a contact
}else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_UPDATE_CONTACT){
    //let's update a contact
}else{
    setResponseMainInfo("action not supported!",402);
}
//if there are any validation errors they will be added to the response or nothing is added otherwise
if(isset($_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS]))
    $response[InputValidator::INPUT_VALIDATOR_ERRORS]=$_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS];
exit(json_encode($response));



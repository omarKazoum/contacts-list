<?php
require_once $_SERVER['DOCUMENT_ROOT']."/autoloader.php";
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
    if (InputValidator::areAllFieldsSet(array(
            Constants::Users_Password,
            Constants::Users_Col_UserName,
            Constants::Users_Password2,
        ),'POST')
        AND InputValidator::validatePasswordsMatch($_POST[Constants::Users_Password], $_POST[Constants::Users_Password2],Constants::Users_Password)
        AND InputValidator::validateUserNameDoesNotExist($_POST[Constants::Users_Col_UserName],Constants::Users_Col_UserName)
        AND InputValidator::validateUserName($_POST[Constants::Users_Col_UserName],Constants::Users_Col_UserName)
    ) {
            $user=new User();
            $user->setUserName($_POST[Constants::Users_Col_UserName]);
            $user->setPassword($_POST[Constants::Users_Password]);
            $user->save();
            AccountManager::getInstance()->login($user->getId());
            setResponseMainInfo('account created successfully',200);
    }else{
            setResponseMainInfo('failed to crate your account',400);
        }


} else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_LOGIN){
    //let's login
    if(InputValidator::validateLoginParamsSet([Constants::Users_Col_UserName,Constants::Users_Password],
        "POST",
        ['the user name','the password'])){
        $user=User::getByName($_POST[Constants::Users_Col_UserName]);
        if($user && password_verify($_POST[Constants::Users_Password],$user->getPasswordHash())){
            AccountManager::getInstance()->login($user->getId());
            setResponseMainInfo('Login successfully',200);
        }else{
            setResponseMainInfo('Failed to login',400);
            InputValidator::appendError(Constants::Users_Col_UserName,"invalid user name");
            InputValidator::appendError(Constants::Users_Password,"invalid password");
        }
    };
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



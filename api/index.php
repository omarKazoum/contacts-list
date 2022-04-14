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
if(!$am->isLoggedIn() AND !$_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_SIGNUP AND $_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_LOGIN){
    setResponseMainInfo('you are not logged in',400);
    exit(json_encode($response));
}
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


}
else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_LOGIN){
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
}
else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_ADD_CONTACT){
    //let's add a contact
    if(InputValidator::areAllFieldsSet([
        Constants::Contacts_Col_Phone,
        Constants::Contacts_Col_Email,
        Constants::Contacts_Col_Name],'POST')
       AND InputValidator::validatePhone($_POST[Constants::Contacts_Col_Phone] , Constants::Contacts_Col_Phone)
        AND InputValidator::validateEmail($_POST[Constants::Contacts_Col_Email] , Constants::Contacts_Col_Email)
        AND InputValidator::validateUserName($_POST[Constants::Contacts_Col_Name] , Constants::Contacts_Col_Name))
    {
        // so the submitted data is valid
        $contact=new Contact();
        $contact->setUserId($am->getLoggedInUserId());
        $contact->setAdress($_POST[Constants::Contacts_Col_Address]??'');
        $contact->setPhone($_POST[Constants::Contacts_Col_Phone]);
        $contact->setEmail($_POST[Constants::Contacts_Col_Email]);
        $contact->setName($_POST[Constants::Contacts_Col_Name]);
        $contact->save();
        $response[Constants::Contacts_Affected_Contact_Key]=$contact->getAsArray();
        setResponseMainInfo("Contact added successfully",200);

    }else{
        setResponseMainInfo("Unable to add contact",400);
    }
}
else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_UPDATE_CONTACT){
    //let's update a contact
    if(InputValidator::areAllFieldsSet([
        Constants::Contacts_Col_Phone,
        Constants::Contacts_Col_Email,
        Constants::Contacts_Col_Name],'POST')
    AND
        InputValidator::validatePhone($_POST[Constants::Contacts_Col_Phone] , Constants::Contacts_Col_Phone)
        AND InputValidator::validateEmail($_POST[Constants::Contacts_Col_Email] , Constants::Contacts_Col_Email)
        AND InputValidator::validateUserName($_POST[Constants::Contacts_Col_Name] , Constants::Contacts_Col_Name)
        AND isset($_POST[Constants::Contacts_Col_Id]))
    {
        // so the submitted data is valid
        $contact=Contact::getById($_POST[Constants::Contacts_Col_Id]);
        if($contact && $contact->getUserId()==$am->getLoggedInUserId()){
            // so our contact to be updated exists and it belongs to the logged in user
            $contact->setAdress($_POST[Constants::Contacts_Col_Address]??'');
            $contact->setPhone($_POST[Constants::Contacts_Col_Phone]);
            $contact->setEmail($_POST[Constants::Contacts_Col_Email]);
            $contact->setName($_POST[Constants::Contacts_Col_Name]);
            $contact->save();
            $response[Constants::Contacts_Affected_Contact_Key]=$contact->getAsArray();
            setResponseMainInfo("Contact updated successfully",200);
        }else{
            setResponseMainInfo("Unable to update contact",400);
        }
    }else{
        setResponseMainInfo("Unable to update contact",400);
    }
}
else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_LIST_CONTACTS){
    foreach(Contact::getAllByUserId($am->getLoggedInUserId()) as $contact)
    $response[Constants::ApiDataKey][]=$contact->getAsArray();
    setResponseMainInfo("request successful",200);
}
else if($_GET[Constants::ACTION_KEY]==Constants::ACTION_TYPE_DELETE_CONTACT){
        if(isset($_POST[Constants::Contacts_Col_Id])) {
            $contact = Contact::getById($_POST[Constants::Contacts_Col_Id]);
            if ($contact && $contact->getUserId() == $am->getLoggedInUserId()) {
                // so the contact is found and it belongs to this user
                $contact->delete();
                setResponseMainInfo("Contact deleted successfully!", 200);
            } else {
                setResponseMainInfo("Contact does not exist!", 400);
            }
        }else
            setResponseMainInfo("Contact id not set!", 400);
}
else{
    setResponseMainInfo("action not supported!",402);
}
//if there are any validation errors they will be added to the response or nothing is added otherwise
if(isset($_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS]))
    $response[InputValidator::INPUT_VALIDATOR_ERRORS]=$_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS];
exit(json_encode($response));



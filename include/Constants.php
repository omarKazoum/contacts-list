<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/ModelBase.php';
class Constants
{

    //for users table
    const Users_TableName='users';
    const Users_Col_Id=ModelBase::ID_KEY;
    const Users_Col_UserName='name';
    const Users_Col_PasswordHash='pass_hash';
    const Users_Col_RegisterDate='register_date';
    const Users_Password='pass';
    //not stored
    const Users_Password2='pass2';


    // for contacts table
    const Contacts_TableName='contacts';
    const Contacts_Col_Id=ModelBase::ID_KEY;
    const Contacts_Col_Name='nom';
    const Contacts_Col_Phone='phone';
    const Contacts_Col_Email='email';
    const Contacts_Col_Address='adress';
    const Contacts_Col_UserId ="user_id" ;

    const Contacts_Affected_Contact_Key="affected";


    //for remember me option
    const Session_RememberMe='rememberme';
    const Session_RememberMe_Email='rememberme_email';
    const Session_RememberMe_Pass='rememberme_pass';

    //for the api
    const ACTION_KEY='action';
    const ACTION_TYPE_SIGNUP="SIGNUP";
    const ACTION_TYPE_LOGIN="LOGIN";
    const ACTION_TYPE_ADD_CONTACT="ADD_CONTACT";
    const ACTION_TYPE_UPDATE_CONTACT="UPDATE_CONTACT";
    const ACTION_TYPE_LIST_CONTACTS="LIST_CONTACTS";
    const ACTION_TYPE_DELETE_CONTACT="DELETE_CONTACTS";


    const API_MSG_KEY='message';
    const ApiDataKey="data";
}
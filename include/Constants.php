<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
class Constants
{
    //for users table
    public const Users_TableName='comptes';
    public const Users_Col_Id='id';
    public const Users_Col_Email='email';
    public const Users_Col_UserName='name';
    public const Users_Col_PasswordHash='pass_hash';
    public const Users_Password='pass';
    //not stored
    public const Users_Password2='pass2';

    //for remember me option
    public const Session_RememberMe='rememberme';
    public const Session_RememberMe_Email='rememberme_email';
    public const Session_RememberMe_Pass='rememberme_pass';
}
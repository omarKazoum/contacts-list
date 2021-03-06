<?php
require_once $_SERVER['DOCUMENT_ROOT']."/autoloader.php";
class InputValidator
{
    public  const INPUT_VALIDATOR_ERRORS='errors';
    public  const PASSWORD_ERROR_KEY='password';
    public  const EMAIL_ERROR_KEY='email';
    public  const PASSWORD_PATTERN='/^.{8,100}$/';
    public  const EMAIL_PATTERN='/^\w+@\w+(\.\w+)+$/';
    public  const PHONE_PATTERN='/^\+{0,1}(212)|0[658]\d{8}$/';
    public  const NAME_PATTERN='/^([a-zA-Z0-9]{3,}\s?)+$/';
    public  const PHONE_ERROR_KEY ='phone' ;


    public static function flushErrors(){
            unset($_SESSION[self::INPUT_VALIDATOR_ERRORS]);
    }
    /**
     * validates the password against this criteria:
     * <ul>
     *  <li>can contain at least one lower case character a-z</li>
     *  <li>can contain at least one upper case character A-Z</li>
     *  <li>can contain at least one number 0-9 </li>
     *  <li>can contain at least a special character .<b>.</b>,@,&lt;,>,/,\,$ </li>
     * </ul>
     * <b>In Regex: <code>/^[\w\*\$@\+\.\,]{8,}$/</code></b>
     * @param  $password
     * @return bool
     */
    public static function validatePassword( $password,$key):bool{
        $res=preg_match(self::PASSWORD_PATTERN,$password);
        if(!$res){
            self::appendError($key,"Password must be at least 8 characters long");
        }
        return $res;
    }
    /**
     * validates the password against this criteria:
     * <ul>
     *  <li>must be a valide email adress</li>
     * </ul>
     * <b>Regex used <code>^([\w]{1,30})@([\w]{1,20})\.([\w]{1,20})$</code></b>
     * @param  $email
     * @return bool
     */
    public static function validateEmail($email,$key):bool{
        $res=preg_match(self::EMAIL_PATTERN,$email);
        if(!$res){
            self::appendError($key,'Invalid email address');
        }
        return $res;
    }
    public static function validatePasswordsMatch( $password1, $password2,$key){
        $isPasswordValid=self::validatePassword($password1,$key);
        $isPasswordsMatch=$password1==$password2 ;
        if(!$isPasswordsMatch){
           self::appendError($key,"Passwords must match");
        }
        return $isPasswordsMatch AND $isPasswordValid;
    }
    public static function validatePhone($phoneNbr,$key){
        $isPhoneValid=preg_match(self::PHONE_PATTERN,$phoneNbr);;
        if(!$isPhoneValid)
            self::appendError($key,"Invalid phone number:must start with 212 or 0 and then 6,5 or 8 followed by 8 numbers");
        return $isPhoneValid;
    }
    public static function error( $input_key){
        return $_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS][$input_key]??false;
    }
    public static function validateUserNameDoesNotExist( $userName,$key)
    {
        $exists=User::getByName($userName);
        if($exists)
            self::appendError($key,"User name already taken");
        return !$exists;
    }
    static function AreAllSignUpFieldsSet():bool{
        $userFields=array(
            Constants::Users_Password,
            Constants::Users_Col_UserName,
            Constants::Users_Password2,
        );
        return self::areAllFieldsSet($userFields,'POST');
    }
    static function areAllFieldsSet(array $fields, $method,array $fieldsCustomNames=[]) :bool{
        $isAllSet=true;
        foreach ($fields as $key=> $field){
            if(($method =='GET' and !isset($_GET[$field])) or ($method =='POST' and !isset($_POST[$field]) )) {
                $isAllSet = false;
                self::appendError($field, ($fieldsCustomNames[$key] ?? $field) . ' is required');
            }
        }
        return $isAllSet;
    }
    public static function validateUserName($userName, $key)
    {
        $valid=preg_match(self::NAME_PATTERN,$userName);
        if(!$valid)
            $_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS][$key]="User name must be 3 letters long and contain only alphanumeric characters";
        return $valid;
    }
     static function appendError($key,$message){
        if(!isset($_SESSION[self::INPUT_VALIDATOR_ERRORS][$key]))
            $_SESSION[self::INPUT_VALIDATOR_ERRORS][$key]="$message";
        else
            $_SESSION[self::INPUT_VALIDATOR_ERRORS][$key].="\<br\>$message";
    }

    public static function validateLoginParamsSet(array $fields, $method, array $fieldsCustomNames=[]):bool{
    {
        $isAllSet=true;
        foreach ($fields as $key=> $field){
            if(($method =='GET' and !isset($_GET[$field])) or ($method =='POST' and !isset($_POST[$field]) )) {
                $isAllSet = false;
                self::appendError($field, 'invalid '.($fieldsCustomNames[$key] ?? $field) );
            }
        }
        return $isAllSet;
    }
    }
}
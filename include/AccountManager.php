<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/DBManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/Constants.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/InputValidator.php';
class AccountManager
{
    private const  CONNECTED_USER_ID_KEY='connected_user_id';
    private  string $connectedUserId='';
    private  bool $logged_in=false;
    private static ?AccountManager $instance=null;
    private function __construct()
    {
        global $session_time_out_minutes;
        //this line has no effect as it's not taken into account by the server
        ini_set('session.gc_maxlifetime', 60*$session_time_out_minutes);
        // each client should remember their session id for for a certain number of seconds
        session_set_cookie_params(60*$session_time_out_minutes);
        session_start();
        InputValidator::flushErrors();
        $this->logged_in=isset($_SESSION[self::CONNECTED_USER_ID_KEY]) AND !empty($_SESSION[self::CONNECTED_USER_ID_KEY]);
        if($this->logged_in){
            $this->connectedUserId=$_SESSION[self::CONNECTED_USER_ID_KEY];
        }
    }
    /**
     * helps you log in
     * @param string $userId
     * @return void
     *
     */
    public function login(string $userId){
        global $session_time_out_minutes;
        // server should keep session data for a certain number of seconds
        $_SESSION[self::CONNECTED_USER_ID_KEY]=$userId;
    }
    public function logOut(){
        session_unset();
        session_destroy();
    }
    public function isLoggedIn():bool{
        return $this->logged_in;
    }

    /**
     * returns the id of the current logged in user
     * @return mixed|string
     */
    public function getLoggedInUserId(){
        return $this->connectedUserId;
    }  /**
     * creates a new instance and stores it in the $instance static variable
     * @return AccountManager
     */
    public static function getInstance():AccountManager{
        if(!AccountManager::$instance)
            AccountManager::$instance=new AccountManager();
        return AccountManager::$instance;
    }
    public function getLoggedInUser():User{
        $db_manager=DBManager::getInstance();
        return  $db_manager->getUserById($this->connectedUserId);
    }
}
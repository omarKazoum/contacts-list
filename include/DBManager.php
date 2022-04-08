<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
    ini_set('display_errors', !PRODUCTION);
    ini_set('display_startup_errors', !PRODUCTION);
    error_reporting(!PRODUCTION ?E_ALL:E_ERROR);

class DBManager
{
    private static ?DBManager $instance=null;
    private static $db_connection=null;
    private static $server_connection=null;

    private function __construct()
    {

    }
    public static function getInstance(){
         if(!DBManager::$instance){
            DBManager::$instance=new DBManager();
         }
        DBManager::$instance->install();
        return DBManager::$instance;
    }
    /**
     * connect to database and stores a link object in DBManager::$db_connection
     * @return void
     */
    private function connectToDb(){
        DBManager::$db_connection = new mysqli($GLOBALS['db_host_name'] ,
            $GLOBALS['db_user_name'],
            $GLOBALS['db_password'],
            $GLOBALS['db_name']
        );
        if(DBManager::$db_connection->connect_error)
            die(DBManager::$db_connection->connect_error);
        /*else
            echo 'the connection with db '.(DBManager::$db_connection!=null?'established ':'failed').'';
        */
    }
    private function connectToServer(){
        DBManager::$server_connection = new mysqli($GLOBALS['db_host_name'] ,
            $GLOBALS['db_user_name'],
            $GLOBALS['db_password']);
        if(DBManager::$server_connection->connect_error && !PRODUCTION)
            die(DBManager::$server_connection->connect_error);
        /*else
            echo 'the connection with db '.(DBManager::$server_connection!=null?'established ':'failed');
        */

    }
    /** creates the database
     * @return void
     */
    private function createDB(){
         $result=DBManager::$server_connection->query('CREATE DATABASE '.$GLOBALS['db_name']);
        DBManager::$server_connection->close();
         return $result;
    }

    /**
     * create the required tables
     * @return bool
     */
    private function createTables(){
        //TODO:: remove the email form the user attributes
            $users_table_query='CREATE TABLE '.Constants::Users_TableName.'('
                    .Constants::Users_Col_Id.' INT AUTO_INCREMENT PRIMARY KEY,'
                    .Constants::Users_Col_Email.' VARCHAR(40),'
                    .Constants::Users_Col_UserName.' VARCHAR(30),'
                    .Constants::Users_Col_PasswordHash.' TEXT'
                .')';
            $r1=DBManager::$db_connection->query($students_table_query);
            $r2=DBManager::$db_connection->query($payments_table_query);
            $r3=DBManager::$db_connection->query($courses_table_query);
            $r4=DBManager::$db_connection->query($users_table_query);
            return $r1 && $r2 && $r3;
        }

    /**
     * should only be called once in the lifetime of the app at first use
     * create the database and all the required tables
     * @return void
     */
    private function install(){
        $this->connectToServer();
        DBManager::$instance->createDB();
        $this->connectToDb();
        DBManager::$instance->createTables();
    }

    /**
     * @param int $userId the user id in users table to be found if exists
     * @return false|User returns an object of type user or false if none is found
     */
    public function getUserById(int $userId)
    {
        //TODO change the query to fit the new data structure
        $sql='SELECT * FROM '.Constants::Users_TableName.' WHERE '.Constants::Users_Col_Id.'='.$userId;
        $res=DBManager::$db_connection->query($sql)->fetch_assoc();
        if($res) {
            $user = new User();
            $user->setId($userId);
            $user->setEmail($res[Constants::Users_Col_Email]);
            $user->setPasswordHash($res[Constants::Users_Col_PasswordHash]);
            $user->setUserName($res[Constants::Users_Col_UserName]);
            return $user;
        }else{
            return null;
        }
    }
    /**
     * unused
     * @return DBManager|null
     */
    private function connect(){
        $this->connectToDb();
        return DBManager::$instance;
    }
    /**
     * close all connections when they are no longer needed
     */
    public function __destruct()
    {
           //mysqli_close(DBManager::$server_connection);
           mysqli_close(DBManager::$db_connection);

    }

}
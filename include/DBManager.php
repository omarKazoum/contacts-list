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
            $students_table_query='CREATE TABLE '.DBContract::$Students_TableName.'('
                .DBContract::$Students_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                .DBContract::$Students_Col_Name.' VARCHAR(20),'
                .DBContract::$Students_Col_Image.' TEXT,'
                .DBContract::$Students_Col_Email.' TEXT ,'
                .DBContract::$Students_Col_Phone.' VARCHAR(12) ,'
                .DBContract::$Students_Col_EnrollNbr.' TEXT ,'
                .DBContract::$Students_Col_DateAdmission.' DATE '
                .DBContract::$Students_Col_PasswordHash.' TEXT'
            .')';
            $payments_table_query='CREATE TABLE '.DBContract::$PaymentDetails_TableName.'('
                        .DBContract::$PaymentDetails_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                        .DBContract::$PaymentDetails_Col_Name.' VARCHAR(20),'
                        .DBContract::$PaymentDetails_Col_PaymentSchechule.' INT,'
                        .DBContract::$PaymentDetails_Col_BillNbr.' VARCHAR(30),'
                        .DBContract::$PaymentDetails_Col_AmountPaid.' FLOAT(10),'
                        .DBContract::$PaymentDetails_Col_BalanceAmount.' FLOAT(10),'
                        .DBContract::$PaymentDetails_Col_Date.' DATE'.
                    ')';

            $courses_table_query='CREATE TABLE '.DBContract::$Courses_TableName.'('
                .DBContract::$Courses_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                .DBContract::$Courses_Col_Title.' VARCHAR(30),'
                .DBContract::$Courses_Col_MentorName.' VARCHAR(20),'
                .DBContract::$Courses_Col_Date.' DATETIME,'
                .DBContract::$Courses_Col_Duration.' TIME'
            .')';
            $users_table_query='CREATE TABLE '.DBContract::$Users_TableName.'('
                    .DBContract::$Users_Col_Id.' INT AUTO_INCREMENT PRIMARY KEY,'
                    .DBContract::$Users_Col_Email.' VARCHAR(40),'
                    .DBContract::$Users_Col_UserName.' VARCHAR(30),'
                    .DBContract::$Users_Col_PasswordHash.' TEXT'
                .')';
            ;
            //echo '<br>user table query is: '.$users_table_query.'</br>';
            //echo '<br>payments table query : '.$payments_table_query;
            //echo '<br>courses table query : '.$courses_table_query;
            $r1=DBManager::$db_connection->query($students_table_query);
            $r2=DBManager::$db_connection->query($payments_table_query);
            $r3=DBManager::$db_connection->query($courses_table_query);
            $r4=DBManager::$db_connection->query($users_table_query);
            return $r1 && $r2 && $r3;
        }

    /**
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
        $sql='SELECT * FROM '.DBContract::$Users_TableName.' WHERE '.DBContract::$Users_Col_Id.'='.$userId;
        $res=DBManager::$db_connection->query($sql)->fetch_assoc();
        if($res) {
            $user = new User();
            $user->setId($userId);
            $user->setEmail($res[DBContract::$Users_Col_Email]);
            $user->setPasswordHash($res[DBContract::$Users_Col_PasswordHash]);
            $user->setUserName($res[DBContract::$Users_Col_UserName]);
            return $user;
        }else{
            return null;
        }


    }
    public function getUserByEmail(string $userEmail){
        $sql='SELECT * FROM '.DBContract::$Users_TableName.' WHERE '.DBContract::$Users_Col_Email."=?";
        $statment=DBManager::$db_connection->prepare($sql);
        $statment->bind_param('s',$userEmail);
        $row=null;
        $statment->execute();
        $result=$statment->get_result();
        if( $row=$result->fetch_assoc()) {
            $user = new User();
            $user->setId($row[DBContract::$Users_Col_Id]);
            $user->setEmail($row[DBContract::$Users_Col_Email]);
            $user->setPasswordHash($row[DBContract::$Users_Col_PasswordHash]);
            $user->setUserName($row[DBContract::$Users_Col_UserName]);
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
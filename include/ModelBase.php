<?php

require_once 'DBManager.php';
/**
 * this class is used to perform crud operation for any model
 *
 */
abstract class ModelBase
{
    protected const table_name='';
    private DBManager $db_manager;
    public function __construct()
    {
        $this->db_manager=DBManager::getInstance();
    }

    /**
     * updates the current object to the database adds it if it does not already exist
     * @return void
     */
    public abstract function update();
    public abstract function add();
    public function delete(){
        $this->db_manager->
    };
    public abstract function getAll();

}
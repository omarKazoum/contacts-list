<?php

require_once 'DBManager.php';
/**
 * this class is used to perform crud operation for any model
 *
 */
class ModelBase
{
    public function __construct()
    {
        $this->db_manager=DBManager::getInstance();
    }

    private DBManager $db_manager;

    protected $propreties=[];

    /**
     * updates the current object to the database adds it if it does not already exist
     * @return void
     */
    function save(){

    }
    public function __get(string $name)
    {


    }
    public function __set(string $name, $value): void
    {
        if(in_array($name,$this->propreties))
            $this->$name=$value;
        else{
            throw new Exception("cannot add such a property !");
        }
    }
    public function __call(string $name, array $arguments)
    {
        if(preg_match("/getBy([A-Z]\w+)/",$name,$matches)){
            $atrName=strtolower($matches[1]);
            if(in_array($atrName,$this->propreties)){
                //so the attribute exists
                //TODO:: call the method respon,sible for getting the data form the database
                $this->db_manager->
            }else
                throw new Exception("cannot find an attribute of name: ".$atrName);

        }else{
            throw new Exception("no such method with name ".$name);
        }
    }

}
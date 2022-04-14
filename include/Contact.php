<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/include/ModelBase.php';


class Contact  extends ModelBase
{
    protected static string $tableName=Constants::Contacts_TableName;
    private $name;
    private $phone;
    private $email;
    private $adress;
    private $userId;

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }
    public function __construct()
    {
        parent::__construct();

    }
    public function update()
    {
        $sql="UPDATE ".self::$tableName." SET "
            .Constants::Contacts_Col_Name.'=?,'
            .Constants::Contacts_Col_Email.'=?,'
            .Constants::Contacts_Col_Address.'=?,'
            .Constants::Contacts_Col_Phone."=?,"
            .Constants::Contacts_Col_UserId."=?"
            .' WHERE '.self::ID_KEY.'=?;';
        $stmt =self::$db_manager->getConnection()->prepare($sql);

        $stmt->bind_param( "ssssss",
            $this->name,
            $this->email,
            $this->adress,
            $this->phone,
            $this->userId,
            $this->id
        );
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function add()
    {
        if($this->userId==-1 ||!isset($this->userId))
            throw new Exception('every contact should have an associated user id');
        $sql="INSERT INTO ".static::$tableName."("
            .Constants::Contacts_Col_Phone.','
            .Constants::Contacts_Col_Name.','
            .Constants::Contacts_Col_Email .','
            .Constants::Contacts_Col_Address.','
            .Constants::Contacts_Col_UserId
            .')'
            .' values(?,?,?,?,?)';

        $stmt =self::$db_manager->getConnection()->prepare($sql);

        $stmt->bind_param( "sssss",
            $this->phone,
        $this->name,
            $this->email,
            $this->adress,$this->userId);
        $stmt->execute();
        $this->id=$stmt->insert_id;
        return $stmt->affected_rows;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress): void
    {
        $this->adress = $adress;
    }
    public static function getAllByUserId($userId):array{
        $contactsArray=self::queryBy(Constants::Contacts_Col_UserId,$userId,self::$tableName);
        if($contactsArray)
        foreach ($contactsArray as $key=> $row){
            $contactsArray[$key]=self::parseEntity($row);
        }
        return $contactsArray;
    }
    protected static function parseEntity(array $data)
    {
            $contact=new Contact();
            $contact->setId($data[Constants::Contacts_Col_Id]);
            $contact->setAdress($data[Constants::Contacts_Col_Address]);
            $contact->setEmail($data[Constants::Contacts_Col_Email]);
            $contact->setPhone($data[Constants::Contacts_Col_Phone]);
            $contact->setName($data[Constants::Contacts_Col_Name]);
            $contact->setUserId($data[Constants::Contacts_Col_UserId]);

        return $contact;
       }
    public function getAsArray(){
        return [Constants::Contacts_Col_Id=>$this->id,
            Constants::Contacts_Col_Name=>$this->name,
            Constants::Contacts_Col_Email=>$this->email,
            Constants::Contacts_Col_Phone=>$this->phone,
            Constants::Contacts_Col_UserId=>$this->userId,
            Constants::Contacts_Col_Address=>$this->adress
            ];
    }

    public function __toString()
    {
        return json_encode($this->getAsArray());
    }


}
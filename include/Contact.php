<?php

class Contact  extends ModelBase
{
    private int $id;
    private int $nom;
    private int $phone;
    private int $email;
    private int $adress;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getNom(): int
    {
        return $this->nom;
    }

    /**
     * @param int $nom
     */
    public function setNom(int $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getPhone(): int
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone(int $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getEmail(): int
    {
        return $this->email;
    }

    /**
     * @param int $email
     */
    public function setEmail(int $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getAdress(): int
    {
        return $this->adress;
    }

    /**
     * @param int $adress
     */
    public function setAdress(int $adress): void
    {
        $this->adress = $adress;
    }


    public function update()
    {
        // TODO: Implement update() method.
    }

    public function add()
    {
        // TODO: Implement add() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
<?php
class User{
    private string $userName;
    private int $id;
    private string $passwordHash;
    private string $registerDate;
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

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
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * this function will hash the given password and store it (you can get it's hash later with {$this->getPasswordHash()})
     * @param string $password unhashed password
     */
    public function setPassword(string $password): void
    {
        $this->passwordHash = password_hash($password,PASSWORD_DEFAULT);
    }

    /**
     * @return string
     */
    public function getRegisterDate(): string
    {
        return $this->registerDate;
    }

    /**
     * @param string $registerDate
     */
    public function setRegisterDate(string $registerDate): void
    {
        $this->registerDate = $registerDate;
    }

}
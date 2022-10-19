<?php
namespace App\Entity;

class PhoneNumber
{
    private int $id;

    private $users;

    private  $phoneNumber;

    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): ?User
    {
        return $this->users;
    }

    public function setUser(?User $users): self
    {
        $this->users = $users;

        return $this;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    // public function __toArray()
    // {  
    //     return (string) $this->getPhoneNumber();
    // }
    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

}
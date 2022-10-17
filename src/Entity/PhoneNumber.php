<?php
namespace App\Entity;

class PhoneNumber
{

    private int $id;

    private $users;

    private int $phoneNumber;

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
    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }
    public function __toString()
    {  
        return strval($this->getPhoneNumber());
    }
    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

}
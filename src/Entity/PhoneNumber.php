<?php
namespace App\Entity;

class PhoneNumber
{

    private int $id;

    private $userId;

    private int $phoneNumber;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId(User $id): self
    {
        $this->userId = $id;

        return $this;
    }
    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
<?php
namespace App\Entity;

class PhoneNumber
{

    private int $id;

    private $users;

    private int $phoneNumber;

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
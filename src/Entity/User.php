<?php
namespace App\Entity;

class User
{

    private $id;
    private $firstName;
    private $lastName;
    private $bloodGroupId;
    private $genderId;
    private $phoneNumber;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBloodGroupId(): ?bloodgroup
    {
        return $this->bloodGroupId;
    }

    public function setBloodGroupId(bloodgroup $id): self
    {
        $this->bloodGroupId = $id;

        return $this;
    }

    public function getGenderId(): ?gender
    {
        return $this->genderId;
    }

    public function setGenderId(gender $genderId): self
    {
        $this->genderId = $genderId;

        return $this;
    }
    public function getPhoneNumber(): ?PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(PhoneNumber $Id): self
    {
        $this->Id = $Id;

        return $this;
    }
}
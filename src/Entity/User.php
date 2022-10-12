<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User
{

    private $id;
    private $firstName;
    private $lastName;
    private $bloodGroup;
    private $gender;
    private $phoneNumber;

    public function __construct()
    {
        $this->phoneNumber = new ArrayCollection();
    }
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

    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(bloodgroup $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGenderId(gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
    public function getPhoneNumber(): Collection
    {
        return $this->phoneNumber;
    }
    public function addPhoneNumber(phoneNumber $phoneNumber): void
    {
        if(!$this->phoneNumber->contains($phoneNumber))
        {
            $this->phoneNumber->add($phoneNumber);
        }
    }
    public function removePhoneNumber(phoneNumber $phoneNumber): void
    {
        if(!$this->phoneNumber->contains($phoneNumber))
        {
            $this->phoneNumber->remove($phoneNumber);
        }
}
}
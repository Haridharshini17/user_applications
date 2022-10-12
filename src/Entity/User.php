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
    private $phoneNumbers;

    public function __construct()
    {
        $this->phoneNumbers = new ArrayCollection();
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

    public function setGender(gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }
    public function getPhoneNumber(): Collection
    {
        return $this->phoneNumbers;
    }
    public function addPhoneNumber(phoneNumber $phoneNumber): self
    {
        if(!$this->phoneNumbers->contains($phoneNumber))
        {
            $this->phoneNumbers[] = $phoneNumber;
            $phoneNumber->setUser($this);
        }
        return $this;
    }
    public function removePhoneNumber(phoneNumber $phoneNumber): self
    {
        if(!$this->phoneNumbers->contains($phoneNumber))
        {
            $this->phoneNumbers->removeElement($phoneNumber);
        }
        if ($phoneNumber->getUser() === $this) 
        {
            $phoneNumber->setUser(null);
        }
        return $this;
}
}
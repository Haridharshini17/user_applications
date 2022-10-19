<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class User
{

    private $id;
    public $firstName;
    public $lastName;
    public $bloodGroup;
    public $gender;
    public $phoneNumbers;
    public $created_at;
    public $updated_at;

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
    // public function __toString()
    // {
    //     return $this->gender;
    // }
    
    public function getPhoneNumbers(): Collection
    {
        return $this->phoneNumbers;
    }
    // public function __toString()
    // {
    //     return (string) $this->phoneNumbers;
    // }
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
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
 
    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;
 
        return $this;
    }
 
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }
 
    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
 
        return $this;
    }

    // public function __toArray()
    // {
    //     return (string) [
    //         'id' => $this->getId(),
    //         'firstName' => $this->getFirstName(),
    //         'lastName' => $this->getLastName(),
    //         'bloodGroup' => $this->getBloodGroup(),
    //         'gender' => $this->getGender(),
    //         'phoneNumber' => $this->getPhoneNumbers(),
    //     ];
    // }
//     public function serialize()
//    {
//        return serialize([
//         $this->id,
//         $this->firstName,
//         $this->lastName,
//         $this->bloodGroup,
//         $this->gender,
//         $this->phoneNumber,
//     ]);
//    }
}
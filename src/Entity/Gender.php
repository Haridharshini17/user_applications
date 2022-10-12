<?php
namespace App\Entity;

class Gender
{
    private int $id;

    private $user;
    
    private string $gender;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getGender(): ?string
    {
        return $this->gender;
    }
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }
}
?>
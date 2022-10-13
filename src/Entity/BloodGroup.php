<?php
namespace App\Entity;
class BloodGroup
{
    private int $id;

    private int $user;
    
    private string $bloodGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup($bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }
}

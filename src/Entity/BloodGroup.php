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

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(string $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }
}

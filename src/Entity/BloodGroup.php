<?php

namespace App\Entity;

class BloodGroup
{
    private int $id;

    private $user = null;
    
    private string $bloodGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBloodGroup()
    {
        return $this->bloodGroup;
    }

    public function __toString()
    {  
        return $this->getBloodGroup();
    }

    public function setBloodGroup($bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }
}

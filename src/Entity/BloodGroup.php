<?php
namespace App\Entity;
class BloodGroup
{
    private $id;
    private $bloodGroup;
    

public function getId(): int
{
    return $this->id;
}
public function getBloodGroup()
{
    return $this->bloodGroup;
}
public function setBloodGroup(string $bloodGroup): self
{
    $this->bloodGroup = $bloodGroup;
    return $this;
}
}
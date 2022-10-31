<?php

namespace App\Entity;
class ApiToken
{
   
    private $id = null;
    private $token = null;
    private $user;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }
    
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getUser(): ?EndUser
    {
        return $this->user;
    }

    public function setUser(?EndUser $user): self
    {
        $this->user = $user;

        return $this;
    }
}

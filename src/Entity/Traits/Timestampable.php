<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

Trait Timestampable
{
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;


    public function getCreatedAt(): ?\DateTimeImmutable
        {
            return $this->createdAt;
        }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        if($this->createdAt===null)
        {
            $this->createdAt = new \DateTimeImmutable();
        }

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        if($this->updatedAt===null)
        {
            $this->updatedAt = new \DateTimeImmutable();
        }


        return $this;
    }
    /*hethi ma3neha eli avant de creation et update de pin bech nesta3mlou lfonction hethi*/
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps() 
    {
        if($this->getCreatedAt()==null)
        {
            $this->setCreatedAt(new \DateTimeImmutable);
        }
            
            $this->setUpdatedAt(new \DateTimeImmutable);
        
    }
}

<?php

namespace App\Entity;

class PropertySearch
{

   private $nomS;

   
   public function getNomS(): ?string
   {
       return $this->nomS;
   }

   public function setNomS(string $nomS): self
   {
       $this->nom = $nomS;

       return $this;
   }
}
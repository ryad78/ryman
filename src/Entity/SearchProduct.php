<?php

namespace App\Entity;
// je veut pas stocké la recherche dans la bdd je commente les uses et j'efface les annotations meme l'id jai pas besoin 
//use App\Repository\SearchProductRepository;
//use Doctrine\ORM\Mapping as ORM;


class SearchProduct
{
 
    
    private $minPrice = null ;

    private $maxPrice = null ;

    /**
     * @var Categories[]
     */
    private $categories = [];

    
    private $tags = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    public function setMinPrice(?int $minPrice): self
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(?int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(?array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnimalFood
 *
 * @ORM\Table(name="animal_food")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnimalFoodRepository")
 */
class AnimalFood
{
    /**
     * @var AppBundle\Entity\Animal
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Animal")
     * @ORM\JoinColumn(name="animal_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $animal;

    /**
     * @var AppBundle\Entity\Food
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Food")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
     * @ORM\Id
     */
    private $food;

    /**
     * @return AppBundle\Entity\Animal
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * @param AppBundle\Entity\Animal $animal
     * @return AnimalFood
     */
    public function setAnimal($animal)
    {
        $this->animal = $animal;
        return $this;
    }

    /**
     * @return AppBundle\Entity\Food
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param AppBundle\Entity\Food $food
     * @return AnimalFood
     */
    public function setFood($food)
    {
        $this->food = $food;
        return $this;
    }



    /**
     * @var int
     *
     * @ORM\Column(name="nbEatenUnity", type="integer")
     */
    private $nbEatenUnity;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nbEatenUnity
     *
     * @param integer $nbEatenUnity
     *
     * @return AnimalFood
     */
    public function setNbEatenUnity($nbEatenUnity)
    {
        $this->nbEatenUnity = $nbEatenUnity;

        return $this;
    }

    /**
     * Get nbEatenUnity
     *
     * @return int
     */
    public function getNbEatenUnity()
    {
        return $this->nbEatenUnity;
    }
}


<?php

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 *
 * @ORM\Table(name="bird")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BirdRepository")
 */
class Bird
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var AppBundle\Entity\Animal
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Animal")
     * @ORM\JoinColumn(name="animal_id", referencedColumnName="id")
     */
    private $animal;

    /**
     * @var int
     *
     * @ORM\Column(name="wingLength", type="integer")
     */
    private $wingLength;


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
     * Set wingLength
     *
     * @param integer $wingLength
     *
     * @return Bird
     */
    public function setWingLength($wingLength)
    {
        $this->wingLength = $wingLength;

        return $this;
    }

    /**
     * Get wingLength
     *
     * @return int
     */
    public function getWingLength()
    {
        return $this->wingLength;
    }

    /**
     * @return mixed
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * @param mixed $animal
     * @return Bird
     */
    public function setAnimal($animal)
    {
        $this->animal = $animal;
        return $this;
    }

    
}


<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Animal
 *
 * @ORM\Table(name="animal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnimalRepository")
 *
 *
 */
class Animal
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Country")
     *
     */
    private $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @param mixed $country
     * @return Animal
     */
    public function setCountries($countries)
    {
        $this->countries = $countries;
        return $this;
    }

    public function addCountry($country)
    {
        $this->countries->add($country);
        return $this;
    }

    public function removeCountry($country)
    {
        $this->countries->removeElement($country);
    }
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\Regex(pattern="/^[A-Z][a-z]+$/", message="The name must start with an uppercase character and contain at least 2 characters")
     */
    private $name;

    /**
     * @var int
     * 
     * @ORM\Column(name="weight", type="integer")
     * @Assert\NotBlank(message="The weight must be specified")
     * @Assert\GreaterThan(value=10, message="the weight must be greater than 10")
     */
    private $weight;

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
     * Set name
     *
     * @param string $name
     *
     * @return Animal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return Animal
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

}


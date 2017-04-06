<?php

//TMSolution\WizardBundle\Entity\ViewConfiguration
namespace TMSolution\WizardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 
 * @ORM\Entity()
 * @ORM\Table(name="wizzard_view_configuration")
 */
class ViewConfiguration {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=1000, nullable=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    protected $address;
    
    
     /**
     * @var string
     *
     * @ORM\Column(name="entity", type="string", length=1000, nullable=false)
     */
    protected $entity;

    

    /**
     * @ORM\ManyToOne(targetEntity="ViewType")
     * @ORM\JoinColumn(name="view_type_id", referencedColumnName="id")
     */
    protected $viewType;

    public function __construct() {
        
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ViewConfiguration
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return ViewConfiguration
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set viewType
     *
     * @param \TMSolution\WizardBundle\Entity\ViewType $viewType
     *
     * @return ViewConfiguration
     */
    public function setViewType(\TMSolution\WizardBundle\Entity\ViewType $viewType = null) {
        $this->viewType = $viewType;

        return $this;
    }

    /**
     * Get viewType
     *
     * @return \TMSolution\WizardBundle\Entity\ViewType
     */
    public function getViewType() {
        return $this->viewType;
    }

    public function __toString() {
        return $this->name;
    }


    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return ViewConfiguration
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }
}

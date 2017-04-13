<?php

namespace Flexix\SampleEntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Discount
 *
 * @ORM\Table(name="callcenter_product_discount")
 * @ORM\Entity
 */
class Discount
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantityFrom", type="integer")
     */
    private $quantityFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantityTo", type="integer")
     */
    private $quantityTo;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Flexix\SampleEntitiesBundle\Entity\MeasureUnit")
     */
    private $measureUnit;

 

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="decimal", precision=5, scale=2)
     */
    private $value;

    /**
     * @var ProductDefinition
     * 
     * @ORM\ManyToOne(targetEntity="Flexix\SampleEntitiesBundle\Entity\ProductDefinition", inversedBy="discounts")
     */    
    protected $productDefinition;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantityFrom
     *
     * @param integer $quantityFrom
     *
     * @return Discount
     */
    public function setQuantityFrom($quantityFrom)
    {
        $this->quantityFrom = $quantityFrom;

        return $this;
    }

    /**
     * Get quantityFrom
     *
     * @return integer
     */
    public function getQuantityFrom()
    {
        return $this->quantityFrom;
    }

    /**
     * Set measureUnit
     *
     * @param integer $measureUnit
     *
     * @return Discount
     */
    public function setMeasureUnit($measureUnit)
    {
        $this->measureUnit = $measureUnit;

        return $this;
    }

    /**
     * Get measureUnit
     *
     * @return integer
     */
    public function getMeasureUnit()
    {
        return $this->measureUnit;
    }



    /**
     * Set value
     *
     * @param string $value
     *
     * @return Discount
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * __toString method
     *
     * return string
     */
    public function __toString()
    {
        return (string)$this->getId();
    }

    /**
     * Set quantityTo
     *
     * @param integer $quantityTo
     *
     * @return Discount
     */
    public function setQuantityTo($quantityTo)
    {
        $this->quantityTo = $quantityTo;

        return $this;
    }

    /**
     * Get quantityTo
     *
     * @return integer
     */
    public function getQuantityTo()
    {
        return $this->quantityTo;
    }

    /**
     * Set productDefinition
     *
     * @param \Flexix\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition
     *
     * @return Discount
     */
    public function setProductDefinition(\Flexix\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition = null)
    {
        $this->productDefinition = $productDefinition;

        return $this;
    }

    /**
     * Get productDefinition
     *
     * @return \Flexix\SampleEntitiesBundle\Entity\ProductDefinition
     */
    public function getProductDefinition()
    {
        return $this->productDefinition;
    }
}

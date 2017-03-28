<?php

namespace TMSolution\SampleEntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Productdefinition
 * 
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="CCO\CallCenterBundle\Repository\ProductDefinitionRepository")
 * @ORM\Table(name="callcenter_productdefinition")
 */
class ProductDefinition
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="ProductDefinition", mappedBy="productDefinitions", cascade={"persist"})
     */
    protected $parents;
    
    /**
     * @ORM\ManyToMany(targetEntity="ProductDefinition", inversedBy="parents", cascade={"persist"})
     * @ORM\JoinTable(name="callcenter_productdefinition_has_productdefinition")
     */
    protected $productDefinitions;
    
    /**
     * @ORM\ManyToOne(targetEntity="MeasureUnit")
     * @ORM\JoinColumn(name="measureunit_id", referencedColumnName="id")
     */
    protected $measureUnit;
    
    /**
     * @var int
     * 
     * @ORM\Column(name="measureunit_quantity", type="integer", nullable=false)
     * @Assert\Type(type="integer")
     */
    protected $measureUnitQuantity;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductDictionary")
     */
    protected $productDictionary;    

    /**
     * @ORM\OneToMany(targetEntity="ProductPrice", mappedBy="productDefinition")
     */
    protected $productPrices;
    
    /**
     * @ORM\OneToMany(targetEntity="TMSolution\SampleEntitiesBundle\Entity\Discount", mappedBy="productDefinition")
     */    
    protected $discounts; 
    
    
    public function __construct()
    {
        $this->productPrices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productDefinitions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add productPrice
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductPrice $productPrice
     *
     * @return ProductDefinition
     */
    public function addProductPrice(\TMSolution\SampleEntitiesBundle\Entity\ProductPrice $productPrice)
    {
        $this->productPrices[] = $productPrice;
        
        return $this;
    }

    /**
     * Remove productPrice
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductPrice $productPrice
     */
    public function removeProductPrice(\TMSolution\SampleEntitiesBundle\Entity\ProductPrice $productPrice)
    {
        $this->productPrices->removeElement($productPrice);
    }

    /**
     * Get productPrices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductPrices()
    {
        return $this->productPrices;
    }

    /**
     * Set productDictionary
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductDictionary $productDictionary
     *
     * @return ProductDefinition
     */
    public function setProductDictionary(\TMSolution\SampleEntitiesBundle\Entity\ProductDictionary $productDictionary = null)
    {
        $this->productDictionary = $productDictionary;

        return $this;
    }

    /**
     * Get productDictionary
     *
     * @return \TMSolution\SampleEntitiesBundle\Entity\ProductDictionary
     */
    public function getProductDictionary()
    {
        return $this->productDictionary;
    }

    /**
     * __toString method
     *
     * return string
     */
    public function __toString()
    {
        return $this->getProductDictionary()->getName();
    }    


    /**
     * Add parent
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $parent
     *
     * @return ProductDefinition
     */
    public function addParent(\TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $parent)
    {
        $this->parents[] = $parent;
        $parent->addProductDefinition($this);
        
        return $this;
    }
    
    /**
     * Set parent
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $parent
     *
     * @return ProductDefinition
     */
    public function setParents(\TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $parent)
    {
        return $this->addParent($parent);
    }    

    /**
     * Remove parent
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $parent
     */
    public function removeParent(\TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $parent)
    {
        $this->parents->removeElement($parent);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Add productDefinition
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition
     *
     * @return ProductDefinition
     */
    public function addProductDefinition(\TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition)
    {
        $this->productDefinitions[] = $productDefinition;
        
        return $this;
    }

    /**
     * Remove productDefinition
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition
     */
    public function removeProductDefinition(\TMSolution\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition)
    {
        $this->productDefinitions->removeElement($productDefinition);
    }

    /**
     * Get productDefinitions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductDefinitions()
    {
        return $this->productDefinitions;
    }

    /**
     * Set measureUnitQuantity
     *
     * @param integer $measureUnitQuantity
     *
     * @return ProductDefinition
     */
    public function setMeasureUnitQuantity($measureUnitQuantity)
    {
        $this->measureUnitQuantity = $measureUnitQuantity;

        return $this;
    }

    /**
     * Get measureUnitQuantity
     *
     * @return integer
     */
    public function getMeasureUnitQuantity()
    {
        return $this->measureUnitQuantity;
    }

    /**
     * Set measureUnit
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\MeasureUnit $measureUnit
     *
     * @return ProductDefinition
     */
    public function setMeasureUnit(\TMSolution\SampleEntitiesBundle\Entity\MeasureUnit $measureUnit = null)
    {
        $this->measureUnit = $measureUnit;

        return $this;
    }

    /**
     * Get measureUnit
     *
     * @return \TMSolution\SampleEntitiesBundle\Entity\MeasureUnit
     */
    public function getMeasureUnit()
    {
        return $this->measureUnit;
    }

    /**
     * Add discount
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\Discount $discount
     *
     * @return ProductDefinition
     */
    public function addDiscount(\TMSolution\SampleEntitiesBundle\Entity\Discount $discount)
    {
        $this->discounts[] = $discount;

        return $this;
    }

    /**
     * Remove discount
     *
     * @param \TMSolution\SampleEntitiesBundle\Entity\Discount $discount
     */
    public function removeDiscount(\TMSolution\SampleEntitiesBundle\Entity\Discount $discount)
    {
        $this->discounts->removeElement($discount);
    }

    /**
     * Get discounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }
}

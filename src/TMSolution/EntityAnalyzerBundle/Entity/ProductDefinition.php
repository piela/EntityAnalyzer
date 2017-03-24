<?php

namespace CCO\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Accessor;

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
     * @JMS\Groups({"api"}) 
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
     * @ORM\OneToMany(targetEntity="CCO\CallCenterBundle\Entity\Discount", mappedBy="productDefinition")
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
     * @param \CCO\CallCenterBundle\Entity\ProductPrice $productPrice
     *
     * @return ProductDefinition
     */
    public function addProductPrice(\CCO\CallCenterBundle\Entity\ProductPrice $productPrice)
    {
        $this->productPrices[] = $productPrice;
        
        return $this;
    }

    /**
     * Remove productPrice
     *
     * @param \CCO\CallCenterBundle\Entity\ProductPrice $productPrice
     */
    public function removeProductPrice(\CCO\CallCenterBundle\Entity\ProductPrice $productPrice)
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
     * @param \CCO\CallCenterBundle\Entity\ProductDictionary $productDictionary
     *
     * @return ProductDefinition
     */
    public function setProductDictionary(\CCO\CallCenterBundle\Entity\ProductDictionary $productDictionary = null)
    {
        $this->productDictionary = $productDictionary;

        return $this;
    }

    /**
     * Get productDictionary
     *
     * @return \CCO\CallCenterBundle\Entity\ProductDictionary
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
     * @param \CCO\CallCenterBundle\Entity\ProductDefinition $parent
     *
     * @return ProductDefinition
     */
    public function addParent(\CCO\CallCenterBundle\Entity\ProductDefinition $parent)
    {
        $this->parents[] = $parent;
        $parent->addProductDefinition($this);
        
        return $this;
    }
    
    /**
     * Set parent
     *
     * @param \CCO\CallCenterBundle\Entity\ProductDefinition $parent
     *
     * @return ProductDefinition
     */
    public function setParents(\CCO\CallCenterBundle\Entity\ProductDefinition $parent)
    {
        return $this->addParent($parent);
    }    

    /**
     * Remove parent
     *
     * @param \CCO\CallCenterBundle\Entity\ProductDefinition $parent
     */
    public function removeParent(\CCO\CallCenterBundle\Entity\ProductDefinition $parent)
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
     * @param \CCO\CallCenterBundle\Entity\ProductDefinition $productDefinition
     *
     * @return ProductDefinition
     */
    public function addProductDefinition(\CCO\CallCenterBundle\Entity\ProductDefinition $productDefinition)
    {
        $this->productDefinitions[] = $productDefinition;
        
        return $this;
    }

    /**
     * Remove productDefinition
     *
     * @param \CCO\CallCenterBundle\Entity\ProductDefinition $productDefinition
     */
    public function removeProductDefinition(\CCO\CallCenterBundle\Entity\ProductDefinition $productDefinition)
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
     * @param \CCO\CallCenterBundle\Entity\MeasureUnit $measureUnit
     *
     * @return ProductDefinition
     */
    public function setMeasureUnit(\CCO\CallCenterBundle\Entity\MeasureUnit $measureUnit = null)
    {
        $this->measureUnit = $measureUnit;

        return $this;
    }

    /**
     * Get measureUnit
     *
     * @return \CCO\CallCenterBundle\Entity\MeasureUnit
     */
    public function getMeasureUnit()
    {
        return $this->measureUnit;
    }

    /**
     * Add discount
     *
     * @param \CCO\CallCenterBundle\Entity\Discount $discount
     *
     * @return ProductDefinition
     */
    public function addDiscount(\CCO\CallCenterBundle\Entity\Discount $discount)
    {
        $this->discounts[] = $discount;

        return $this;
    }

    /**
     * Remove discount
     *
     * @param \CCO\CallCenterBundle\Entity\Discount $discount
     */
    public function removeDiscount(\CCO\CallCenterBundle\Entity\Discount $discount)
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

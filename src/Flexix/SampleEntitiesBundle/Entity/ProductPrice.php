<?php

namespace Flexix\SampleEntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * Userskill
 *
 * @ORM\Table(name="callcenter_productprice")
 * @ORM\Entity
 */
class ProductPrice
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $active;

    /**
     * @var Flexix\SampleEntitiesBundle\Entity\ProductDefinition
     *
     * @ORM\ManyToOne(targetEntity="Flexix\SampleEntitiesBundle\Entity\ProductDefinition", inversedBy="productPrices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="productdefinition_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $productDefinition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefrom", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $dateFrom;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateto", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $dateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=5)
     */
    private $currency;
    
    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=7, scale=2)
     */
    private $price;    
    
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
     * Set active
     *
     * @param boolean $active
     * @return ProductPrice
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return ProductPrice
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set productDefinition
     *
     * @param \Flexix\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition
     * @return ProductPrice
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

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return ProductPrice
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return ProductPrice
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }
    

    /**
     * Set price
     *
     * @param string $price
     *
     * @return ProductPrice
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
}

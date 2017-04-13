<?php

namespace Flexix\SampleEntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductDictionary
 *
 * @ORM\Table(name="callcenter_productdictionary")
 * @ORM\Entity
 */
class ProductDictionary
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     */
    protected $productCategory;
    

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
     * Set name
     *
     * @param string $name
     *
     * @return ProductDictionary
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
     * Set productCategory
     *
     * @param \Flexix\SampleEntitiesBundle\Entity\ProductCategory $productCategory
     *
     * @return ProductDefinition
     */
    public function setProductCategory(\Flexix\SampleEntitiesBundle\Entity\ProductCategory $productCategory = null)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \Flexix\SampleEntitiesBundle\Entity\ProductCategory
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }
    
}


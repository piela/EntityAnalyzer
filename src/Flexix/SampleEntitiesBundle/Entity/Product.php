<?php

namespace Flexix\SampleEntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Userskill
 *
 * @ORM\Table(name="callcenter_product")
 * @ORM\Entity
 */
class Product {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

  


    /**
     * @var Flexix\SampleEntitiesBundle\Entity\ProductDefinition
     *
     * @ORM\ManyToOne(targetEntity="Flexix\SampleEntitiesBundle\Entity\ProductDefinition")
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
     * @var Flexix\SampleEntitiesBundle\Entity\Transaction
     *
     * @ORM\ManyToOne(targetEntity="Flexix\SampleEntitiesBundle\Entity\Transaction",inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $transaction;

    /**
     * @var string
     *
     * @ORM\Column(name="transaction_name", type="string", length=255, nullable=false)
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected $transactionName;

    /**
     * @var Flexix\SampleEntitiesBundle\Entity\PaymentFrequency
     *
     * @ORM\ManyToOne(targetEntity="Flexix\SampleEntitiesBundle\Entity\PaymentFrequency")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_frequency_id", referencedColumnName="id", nullable=false)
     * })
     */
    protected $paymentFrequency;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="payed", type="boolean")
     * @Assert\Type(type="bool")
     */
    protected $payed;

    /**
     * @var int
     * 
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     * @Assert\Type(type="integer")
     */
    protected $quantity;

    /**
     * @var decimal
     *
     * @ORM\Column(name="end_price", type="decimal", scale=2, nullable=false)
     * @Assert\Type(type="integer")
     */
    protected $endPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max=3)
     */
    protected $currency;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param int $quantity
     *
     * @return ProductDefinition
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    
    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Product
     */
    public function setDateFrom($dateFrom) {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom() {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     * @return Product
     */
    public function setDateTo($dateTo) {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime 
     */
    public function getDateTo() {
        return $this->dateTo;
    }

    /**
     * Set transactionName
     *
     * @param string $transactionName
     * @return Product
     */
    public function setTransactionName($transactionName) {
        $this->transactionName = $transactionName;

        return $this;
    }

    /**
     * Get transactionName
     *
     * @return string 
     */
    public function getTransactionName() {
        return $this->transactionName;
    }
    
    /**
     * Set payment frequency
     *
     * @param PaymentFrequency $paymentFrequency
     * @return PaymentFrequency
     */
    public function setPaymentFrequency(PaymentFrequency $paymentFrequency) {
        $this->paymentFrequency = $paymentFrequency;

        return $this;
    }

    /**
     * Get payment frequency
     *
     * @return PaymentFrequency 
     */
    public function getPaymentFrequency() {
        return $this->paymentFrequency;
    }
    
    /**
     * Set payed
     *
     * @param boolean $payed
     * @return Product
     */
    public function setPayed($payed) {
        $this->payed = $payed;

        return $this;
    }

    /**
     * Get payed
     *
     * @return boolean 
     */
    public function getPayed() {
        return $this->payed;
    }

    /**
     * Set endPrice
     *
     * @param string $endPrice
     * @return Product
     */
    public function setEndPrice($endPrice) {
        $this->endPrice = $endPrice;

        return $this;
    }

    /**
     * Get endPrice
     *
     * @return string 
     */
    public function getEndPrice() {
        return $this->endPrice;
    }

   
  

    /**
     * Set productDefinition
     *
     * @param \Flexix\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition
     * @return Product
     */
    public function setProductDefinition(\Flexix\SampleEntitiesBundle\Entity\ProductDefinition $productDefinition = null) {
        $this->productDefinition = $productDefinition;

        return $this;
    }

    /**
     * Get productDefinition
     *
     * @return \Flexix\SampleEntitiesBundle\Entity\ProductDefinition 
     */
    public function getProductDefinition() {
        return $this->productDefinition;
    }

    /**
     * Set transaction
     *
     * @param \Flexix\SampleEntitiesBundle\Entity\Transaction $transaction
     * @return Product
     */
    public function setTransaction(\Flexix\SampleEntitiesBundle\Entity\Transaction $transaction = null) {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * Get transaction
     *
     * @return \Flexix\SampleEntitiesBundle\Entity\Transaction 
     */
    public function getTransaction() {
        return $this->transaction;
    }  

    /**
     * __toString method
     *
     * return string
     */
    public function __toString() {
        return (string) $this->getId();
    }


    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Product
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

}

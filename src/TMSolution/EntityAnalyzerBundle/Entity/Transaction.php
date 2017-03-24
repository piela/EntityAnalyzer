<?php

namespace CCO\CallCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Groups;

/**
 * Userskill
 *
 * @ORM\Table(name="callcenter_transaction")
 * @ORM\Entity(repositoryClass="CCO\CallCenterBundle\Repository\TransactionRepository")
 */
class Transaction {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="transaction")
     */
    protected $products;

    

    /**
     * @var CCO\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="CCO\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $user;

    /**
     * @var CCO\CallCenterBundle\Entity\TransactionType
     *
     * @ORM\ManyToOne(targetEntity="CCO\CallCenterBundle\Entity\TransactionType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_type_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $transactionType;

    /**
     * @var decimal
     *
     * @ORM\Column(name="value", type="decimal", nullable=false, scale=2)
     * @Assert\NotBlank()
     * @JMS\Groups({"api"})
     */
    protected $value;

  

    /**
     * @var decimal
     *
     * @ORM\Column(name="balance", type="decimal", nullable=false, scale=2)
     * @Assert\NotBlank()
     */
    protected $balance;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=3, nullable=true)
     * @Assert\Type(type="string")
     * @Assert\Length(max=3)
     */
    protected $currency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     * @Assert\DateTime()
     * @JMS\Groups({"api"})
     */
    protected $date;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", nullable=true)
     */
    protected $transactionHash;

    /**
     * @var array
     *
     * @ORM\Column(name="parameters", type="array", nullable=false)
     */
    protected $parameters;

    /**
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="TransactionStatus")
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="text", nullable=true)
     */
    protected $link;

    /**
     * Constructor
     */
    public function __construct() {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parameters = [];
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
     * @return Transaction
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
     * Set value
     *
     * @param string $value
     *
     * @return Transaction
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Set balance
     *
     * @param string $balance
     *
     * @return Transaction
     */
    public function setBalance($balance) {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return string
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Transaction
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Add product
     *
     * @param \CCO\CallCenterBundle\Entity\Product $product
     *
     * @return Transaction
     */
    public function addProduct(\CCO\CallCenterBundle\Entity\Product $product) {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \CCO\CallCenterBundle\Entity\Product $product
     */
    public function removeProduct(\CCO\CallCenterBundle\Entity\Product $product) {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts() {
        return $this->products;
    }


    /**
     * Set user
     *
     * @param \CCO\UserBundle\Entity\User $user
     *
     * @return Transaction
     */
    public function setUser(\CCO\UserBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CCO\UserBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set transactionType
     *
     * @param \CCO\CallCenterBundle\Entity\TransactionType $transactionType
     *
     * @return Transaction
     */
    public function setTransactionType(\CCO\CallCenterBundle\Entity\TransactionType $transactionType = null) {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get transactionType
     *
     * @return \CCO\CallCenterBundle\Entity\TransactionType
     */
    public function getTransactionType() {
        return $this->transactionType;
    }

    /**
     * __toString method
     *
     * return string
     */
    public function __toString() {
        return (string) $this->getName();
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Transaction
     */
    public function setCurrency($currency) {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * Set transactionHash
     *
     * @param string $transactionHash
     *
     * @return Transaction
     */
    public function setTransactionHash($transactionHash) {
        $this->transactionHash = $transactionHash;

        return $this;
    }

    /**
     * Get transactionHash
     *
     * @return string
     */
    public function getTransactionHash() {
        return $this->transactionHash;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     *
     * @return Transaction
     */
    public function setParameters(array $parameters) {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Set status
     *
     * @param \CCO\CallCenterBundle\Entity\TransactionStatus $status
     *
     * @return Transaction
     */
    public function setStatus(\CCO\CallCenterBundle\Entity\TransactionStatus $status = null) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \CCO\CallCenterBundle\Entity\TransactionStatus
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Transaction
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink() {
        return $this->link;
    }


   

}

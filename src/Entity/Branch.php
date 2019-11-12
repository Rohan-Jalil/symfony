<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Branch
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StoreBranchRepository")
 * @ORM\Table(name="store_branch")
 */
class Branch
{
    /**
     * @var int | null
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer", nullable=true)
     */
    protected $id;
    /**
     * @var | null
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;
    /**
     * @var Store | null
     * @ORM\ManyToOne(targetEntity="Store", inversedBy="branches", cascade={"persist"})
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     */
    private $store;
    /**
     * @var string | null
     * @ORM\Column(name="street", type="string", nullable=true)
     */
    private $street;
    /**
     * @var string | null
     * @ORM\Column(name="county", type="string", nullable=true)
     */
    private $county;
    /**
     * @var string | null
     * @ORM\Column(name="state", type="string", nullable=true)
     */
    private $state;
    /**
     * @var int | null
     * @ORM\Column(name="zipcode", type="integer", nullable=true)
     */
    private $zipcode;
    /**
     * @var float | null
     * @ORM\Column(name="latitude", type="decimal", nullable=true, precision=9, scale=6)
     */
    private $latitude;
    /**
     * @var float | null
     * @ORM\Column(name="longitude", type="decimal", nullable=true, precision=9, scale=6)
     */
    private $longitude;
    /**
     * @var int | null
     * @ORM\Column(name="number_of_employees", type="integer", nullable=true)
     */
    private $numberOfEmployees;
    /**
     * @var \DateTime | null
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;
    /**
     * @var \DateTime | null
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return Store | null
     */
    public function getStore(): ?Store
    {
        return $this->store;
    }

    /**
     * @param Store $store
     */
    public function setStore(?Store $store): void
    {
        $this->store = $store;
        $this->store->addBranch($this);
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string|null
     */
    public function getCounty(): ?string
    {
        return $this->county;
    }

    /**
     * @param string|null $county
     */
    public function setCounty(?string $county): void
    {
        $this->county = $county;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     */
    public function setState(?string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return int |null
     */
    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    /**
     * @param int |null $zipcode
     */
    public function setZipcode(?int $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return int|null
     */
    public function getNumberOfEmployees(): ?int
    {
        return $this->numberOfEmployees;
    }

    /**
     * @param int|null $numberOfEmployees
     */
    public function setNumberOfEmployees(?int $numberOfEmployees): void
    {
        $this->numberOfEmployees = $numberOfEmployees;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
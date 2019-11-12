<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * Class Store
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 * @ORM\Table(name="store")
 */
class Store
{
    /**
     * @var int | null
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer", nullable=true)
     */
    protected $id;

    /**
     * @var string | null
     * @ORM\Column(name="store_name", type="string", nullable=true)
     */
    private $storeName;

    /**
     * @var PersistentCollection
     * @ORM\OneToMany(targetEntity="Branch", mappedBy="store")
     */
    private $branches;

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
     * @return PersistentCollection
     */
    public function getBranches(): PersistentCollection
    {
        return $this->branches;
    }

    /**
     * @param Branch $branch
     */
    public function addBranch(Branch $branch): void
    {
        if (!$this->branches->contains($branch)) {
            $this->branches->add($branch);
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getStoreName(): ?string
    {
        return $this->storeName;
    }

    /**
     * @param string|null $storeName
     */
    public function setStoreName(?string $storeName): void
    {
        $this->storeName = $storeName;
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
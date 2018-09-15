<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRequestRepository")
 * @ORM\Table(name="job_requests")
 */
class JobRequestEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="JobCategoryEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="JobLocationEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="JobUserEntity", inversedBy="jobRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=1250)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $requestedDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?JobCategoryEntity
    {
        return $this->category;
    }

    public function setCategory(?JobCategoryEntity $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLocation(): ?JobLocationEntity
    {
        return $this->location;
    }

    public function setLocation(?JobLocationEntity $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getUser(): ?JobUserEntity
    {
        return $this->user;
    }

    public function setUser(?JobUserEntity $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRequestedDateTime(): ?\DateTimeInterface
    {
        return $this->requestedDateTime;
    }

    public function setRequestedDateTime(?\DateTimeInterface $requestedDateTime): self
    {
        $this->requestedDateTime = $requestedDateTime;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobUserRepository")
 * @ORM\Table(name="job_users")
 */
class JobUserEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="JobRequestEntity", mappedBy="userId")
     */
    private $jobRequests;

    public function __construct()
    {
        $this->jobRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|JobRequestEntity[]
     */
    public function getJobRequests(): Collection
    {
        return $this->jobRequests;
    }

    public function addJobRequest(JobRequestEntity $jobRequest): self
    {
        if (!$this->jobRequests->contains($jobRequest)) {
            $this->jobRequests[] = $jobRequest;
            $jobRequest->setUser($this);
        }

        return $this;
    }

    public function removeJobRequest(JobRequestEntity $jobRequest): self
    {
        if ($this->jobRequests->contains($jobRequest)) {
            $this->jobRequests->removeElement($jobRequest);
            // set the owning side to null (unless already changed)
            if ($jobRequest->getUser() === $this) {
                $jobRequest->setUser(null);
            }
        }

        return $this;
    }
}

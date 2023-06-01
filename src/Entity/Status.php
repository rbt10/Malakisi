<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: UserBook::class)]
    private Collection $userBooks;

    public function __construct()
    {
        $this->userBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, UserBook>
     */
    public function getUserBooks(): Collection
    {
        return $this->userBooks;
    }

    public function addUserBook(UserBook $userBook): self
    {
        if (!$this->userBooks->contains($userBook)) {
            $this->userBooks->add($userBook);
            $userBook->setStatus($this);
        }

        return $this;
    }

    public function removeUserBook(UserBook $userBook): self
    {
        if ($this->userBooks->removeElement($userBook)) {
            // set the owning side to null (unless already changed)
            if ($userBook->getStatus() === $this) {
                $userBook->setStatus(null);
            }
        }

        return $this;
    }
}

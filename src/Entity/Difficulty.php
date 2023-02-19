<?php

namespace App\Entity;

use App\Repository\DifficultyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DifficultyRepository::class)
 */
class Difficulty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Rooms::class, mappedBy="difficulty")
     */
    private $rooms;

    /**
     * @ORM\OneToMany(targetEntity=ChildGame::class, mappedBy="difficulty")
     */
    private $childGames;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
        $this->childGames = new ArrayCollection();
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
     * @return Collection|Rooms[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Rooms $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
            $room->setDifficulty($this);
        }

        return $this;
    }

    public function removeRoom(Rooms $room): self
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getDifficulty() === $this) {
                $room->setDifficulty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChildGame[]
     */
    public function getChildGames(): Collection
    {
        return $this->childGames;
    }

    public function addChildGame(ChildGame $childGame): self
    {
        if (!$this->childGames->contains($childGame)) {
            $this->childGames[] = $childGame;
            $childGame->setDifficulty($this);
        }

        return $this;
    }

    public function removeChildGame(ChildGame $childGame): self
    {
        if ($this->childGames->removeElement($childGame)) {
            // set the owning side to null (unless already changed)
            if ($childGame->getDifficulty() === $this) {
                $childGame->setDifficulty(null);
            }
        }

        return $this;
    }
}

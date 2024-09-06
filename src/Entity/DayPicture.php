<?php

namespace App\Entity;

use App\Repository\DayPictureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayPictureRepository::class)]
class DayPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Picture>
     */
    #[ORM\ManyToMany(targetEntity: Picture::class)]
    private Collection $id_picture;

    /**
     * @var Collection<int, Day>
     */
    #[ORM\ManyToMany(targetEntity: Day::class, inversedBy: 'dayPictures')]
    private Collection $id_day;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    public function __construct()
    {
        $this->id_picture = new ArrayCollection();
        $this->id_day = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getIdPicture(): Collection
    {
        return $this->id_picture;
    }

    public function addIdPicture(Picture $idPicture): static
    {
        if (!$this->id_picture->contains($idPicture)) {
            $this->id_picture->add($idPicture);
        }

        return $this;
    }

    public function removeIdPicture(Picture $idPicture): static
    {
        $this->id_picture->removeElement($idPicture);

        return $this;
    }

    /**
     * @return Collection<int, Day>
     */
    public function getIdDay(): Collection
    {
        return $this->id_day;
    }

    public function addIdDay(Day $idDay): static
    {
        if (!$this->id_day->contains($idDay)) {
            $this->id_day->add($idDay);
        }

        return $this;
    }

    public function removeIdDay(Day $idDay): static
    {
        $this->id_day->removeElement($idDay);

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }
}

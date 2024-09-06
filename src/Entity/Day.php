<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayRepository::class)]
#[ApiResource]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_day = null;

    #[ORM\Column]
    private ?int $template_day = null;

    #[ORM\Column(length: 255)]
    private ?string $title_day = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_day = null;

    /**
     * @var Collection<int, Content>
     */
    #[ORM\OneToMany(targetEntity: Content::class, mappedBy: 'id_day')]
    private Collection $contents;

    /**
     * @var Collection<int, DayPicture>
     */
    #[ORM\ManyToMany(targetEntity: DayPicture::class, mappedBy: 'id_day')]
    private Collection $dayPictures;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->dayPictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDay(): ?int
    {
        return $this->id_day;
    }

    public function setIdDay(int $id_day): static
    {
        $this->id_day = $id_day;

        return $this;
    }

    public function getTemplateDay(): ?int
    {
        return $this->template_day;
    }

    public function setTemplateDay(int $template_day): static
    {
        $this->template_day = $template_day;

        return $this;
    }

    public function getTitleDay(): ?string
    {
        return $this->title_day;
    }

    public function setTitleDay(string $title_day): static
    {
        $this->title_day = $title_day;

        return $this;
    }

    public function getDateDay(): ?\DateTimeInterface
    {
        return $this->date_day;
    }

    public function setDateDay(?\DateTimeInterface $date_day): static
    {
        $this->date_day = $date_day;

        return $this;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): static
    {
        if (!$this->contents->contains($content)) {
            $this->contents->add($content);
            $content->setIdDay($this);
        }

        return $this;
    }

    public function removeContent(Content $content): static
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getIdDay() === $this) {
                $content->setIdDay(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DayPicture>
     */
    public function getDayPictures(): Collection
    {
        return $this->dayPictures;
    }

    public function addDayPicture(DayPicture $dayPicture): static
    {
        if (!$this->dayPictures->contains($dayPicture)) {
            $this->dayPictures->add($dayPicture);
            $dayPicture->addIdDay($this);
        }

        return $this;
    }

    public function removeDayPicture(DayPicture $dayPicture): static
    {
        if ($this->dayPictures->removeElement($dayPicture)) {
            $dayPicture->removeIdDay($this);
        }

        return $this;
    }
}

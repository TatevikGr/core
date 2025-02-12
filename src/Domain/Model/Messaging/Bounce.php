<?php

declare(strict_types=1);

namespace PhpList\Core\Domain\Model\Messaging;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use PhpList\Core\Domain\Model\Interfaces\DomainModel;
use PhpList\Core\Domain\Model\Interfaces\Identity;
use PhpList\Core\Domain\Model\Traits\IdentityTrait;
use PhpList\Core\Domain\Repository\Messaging\BounceRepository;

#[ORM\Entity(repositoryClass: BounceRepository::class)]
#[ORM\Table(name: 'phplist_bounce')]
#[ORM\Index(name: 'dateindex', columns: ['date'])]
#[ORM\Index(name: 'statusidx', columns: ['status'])]
class Bounce implements DomainModel, Identity
{
    use IdentityTrait;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $date;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $header;

    #[ORM\Column(type: 'blob', nullable: true)]
    private ?string $data;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $status;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comment;

    public function __construct(
        ?DateTime $date = null,
        ?string $header = null,
        ?string $data = null,
        ?string $status = null,
        ?string $comment = null
    ) {
        $this->date = $date;
        $this->header = $header;
        $this->data = $data;
        $this->status = $status;
        $this->comment = $comment;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?DateTime $date): void
    {
        $this->date = $date;
    }

    public function getHeader(): ?string
    {
        return $this->header;
    }

    public function setHeader(?string $header): void
    {
        $this->header = $header;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): void
    {
        $this->data = $data;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }
}

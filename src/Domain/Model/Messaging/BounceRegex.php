<?php

declare(strict_types=1);

namespace PhpList\Core\Domain\Model\Messaging;

use Doctrine\ORM\Mapping as ORM;
use PhpList\Core\Domain\Model\Interfaces\DomainModel;
use PhpList\Core\Domain\Model\Interfaces\Identity;
use PhpList\Core\Domain\Model\Traits\IdentityTrait;
use PhpList\Core\Domain\Repository\Messaging\BounceRegexRepository;

#[ORM\Entity(repositoryClass: BounceRegexRepository::class)]
#[ORM\Table(name: 'phplist_bounceregex')]
#[ORM\UniqueConstraint(name: 'regex', columns: ['regexhash'])]
class BounceRegex implements DomainModel, Identity
{
    use IdentityTrait;

    #[ORM\Column(type: 'string', length: 2083, nullable: true)]
    private ?string $regex;

    #[ORM\Column(name: 'regexhash', type: 'string', length: 32, nullable: true)]
    private ?string $regexHash;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $action;

    #[ORM\Column(name: 'listorder', type: 'integer', nullable: true, options: ['default' => 0])]
    private ?int $listOrder = 0;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $admin;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $comment;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $status;

    #[ORM\Column(type: 'integer', nullable: true, options: ['default' => 0])]
    private ?int $count = 0;

    public function __construct(
        ?string $regex = null,
        ?string $regexHash = null,
        ?string $action = null,
        ?int $listOrder = 0,
        ?int $admin = null,
        ?string $comment = null,
        ?string $status = null,
        ?int $count = 0
    ) {
        $this->regex = $regex;
        $this->regexHash = $regexHash;
        $this->action = $action;
        $this->listOrder = $listOrder;
        $this->admin = $admin;
        $this->comment = $comment;
        $this->status = $status;
        $this->count = $count;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRegex(): ?string
    {
        return $this->regex;
    }

    public function setRegex(?string $regex): void
    {
        $this->regex = $regex;
    }

    public function getRegexHash(): ?string
    {
        return $this->regexHash;
    }

    public function setRegexHash(?string $regexHash): void
    {
        $this->regexHash = $regexHash;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): void
    {
        $this->action = $action;
    }

    public function getListOrder(): ?int
    {
        return $this->listOrder;
    }

    public function setListOrder(?int $listOrder): void
    {
        $this->listOrder = $listOrder;
    }

    public function getAdmin(): ?int
    {
        return $this->admin;
    }

    public function setAdmin(?int $admin): void
    {
        $this->admin = $admin;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): void
    {
        $this->count = $count;
    }
}

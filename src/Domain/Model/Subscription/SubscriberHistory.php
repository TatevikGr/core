<?php

declare(strict_types=1);

namespace PhpList\Core\Domain\Model\Subscription;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use PhpList\Core\Domain\Model\Interfaces\DomainModel;
use PhpList\Core\Domain\Model\Interfaces\Identity;
use PhpList\Core\Domain\Model\Traits\IdentityTrait;

#[ORM\Entity]
#[ORM\Table(name: "phplist_user_user_history")]
#[ORM\Index(name: "dateidx", columns: ["date"])]
#[ORM\Index(name: "userididx", columns: ["userid"])]
class SubscriberHistory implements DomainModel, Identity
{
    use IdentityTrait;

    #[ORM\ManyToOne(targetEntity: Subscriber::class)]
    #[ORM\JoinColumn(name: "userid", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    private Subscriber $subscriber;

    #[ORM\Column(name: "ip", type: "string", length: 255, nullable: true)]
    private ?string $ip = null;

    #[ORM\Column(name: "date", type: "datetime", nullable: true)]
    private ?DateTime $date = null;

    #[ORM\Column(name: "summary", type: "string", length: 255, nullable: true)]
    private ?string $summary = null;

    #[ORM\Column(name: "detail", type: "text", nullable: true)]
    private ?string $detail = null;

    #[ORM\Column(name: "systeminfo", type: "text", nullable: true)]
    private ?string $systemInfo = null;

    public function getSubscriber(): Subscriber
    {
        return $this->subscriber;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function getSystemInfo(): ?string
    {
        return $this->systemInfo;
    }

    public function setUser(Subscriber $subscriber): self
    {
        $this->subscriber = $subscriber;
        return $this;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    public function setDate(?DateTime $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;
        return $this;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;
        return $this;
    }

    public function setSystemInfo(?string $systemInfo): self
    {
        $this->systemInfo = $systemInfo;
        return $this;
    }
}

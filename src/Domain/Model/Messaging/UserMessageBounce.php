<?php

declare(strict_types=1);

namespace PhpList\Core\Domain\Model\Messaging;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use PhpList\Core\Domain\Model\Interfaces\DomainModel;
use PhpList\Core\Domain\Model\Interfaces\Identity;
use PhpList\Core\Domain\Model\Traits\IdentityTrait;

#[ORM\Entity]
#[ORM\Table(name: "phplist_user_message_bounce")]
#[ORM\Index(name: "bounceidx", columns: ["bounce"])]
#[ORM\Index(name: "msgidx", columns: ["message"])]
#[ORM\Index(name: "umbindex", columns: ["user", "message", "bounce"])]
#[ORM\Index(name: "useridx", columns: ["user"])]
#[ORM\HasLifecycleCallbacks]
class UserMessageBounce implements DomainModel, Identity
{
    use IdentityTrait;

    #[ORM\Column(name: "user", type: "integer")]
    private int $user;

    #[ORM\Column(name: "message", type: "integer")]
    private int $message;

    #[ORM\Column(name: "bounce", type: "integer")]
    private int $bounce;

    #[ORM\Column(name: "time", type: "datetime", options: ["default" => "CURRENT_TIMESTAMP"])]
    private DateTime $time;

    public function __construct()
    {
        $this->time = new DateTime();
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function getMessage(): int
    {
        return $this->message;
    }

    public function getBounce(): int
    {
        return $this->bounce;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setMessage(int $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setBounce(int $bounce): self
    {
        $this->bounce = $bounce;
        return $this;
    }
}

<?php

declare(strict_types=1);

namespace PhpList\Core\Domain\Common\Model\Interfaces;

use DateTime;

/**
 * This interface communicates that a domain model has a creation date.
 *
 * The CreationDateTrait is the default implementation.
 *
 * @author Oliver Klee <oliver@phplist.com>
 * @author Tatevik Grigoryan <tatevik@phplist.com>
 */
interface CreationDate
{
    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime;
}

<?php
namespace Data\Enums;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class staffFunction extends AbstractEnumType {

    protected string $name = 'staffFunction';
    protected array $values=['EXECUTIVE', 'SECRETARY', 'EMPLOYEE'];

}
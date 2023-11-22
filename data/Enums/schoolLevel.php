<?php
namespace Data\Enums;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class schoolLevel extends AbstractEnumType {

    protected string $name = 'schoolLevel';
    protected array $values=['CP', 'CE1', 'CE2', 'CM1', 'CM2', '6E',
        '5E', '4E', '3E', '2ND', '1ERE', 'TERM'];

}

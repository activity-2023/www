<?php
namespace App\Data\Enums;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class roomType extends AbstractEnumType
{
    protected string $name = 'roomType';
    protected array $values = array('AMPHITHEATER', 'ROOM', 'WORKSHOP');

}
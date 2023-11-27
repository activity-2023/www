<?php
namespace App\Data\Enums;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class gender extends AbstractEnumType {

    protected string $name = 'gender';
    protected array $values=[ 'MALE', 'FEMALE'];

}

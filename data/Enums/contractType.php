<?php
namespace Data\Enums;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class contractType extends AbstractEnumType
{
    protected string $name = 'contractType';
    protected array $values = array( 'PERMANENT', 'FIXED-TERM', 'TEMPORARY', 'SERVICE');

}
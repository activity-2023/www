<?php

namespace App\Data\Enums;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractEnumType extends Type{

    protected string $name;
    protected array $values = array();

    public function getName(): string{
        return $this->name;
    }
    public function convertToPHPValue($value, AbstractPlatform $platform){
        return $value;
    }

    public function get(string $type): string{
        if(!in_array($type, $this->values)){
            throw new \InvalidArgumentException('Invalid type');
        }
        return $type;
    }
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string{
        $values = array_map(function($val) { return "'".$val."'"; }, $this->values);

        return "ENUM(".implode(", ", $values).")";
    }

    public function addToTypes(){
        try {
            Type::addType($this->name, "Data\Enums\\" . $this->name);
        } catch (Exception $e) {
            echo "Error Type:".$this->name." can not be added to doctrine types";
        }
    }
}
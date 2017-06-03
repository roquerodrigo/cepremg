<?php

namespace App\Models;

/**
 * @Entity @Table(name="davis")
 **/
class Davis extends AbstractDavis
{
   public function __get($name)
    {
        if(property_exists(get_class($this), $name))
            return $this->$name;
        return null;
    }

    public function __set($name, $value)
    {
        if(property_exists(get_class($this), $name)) {
            $this->$name = $value;
        }
    }
}

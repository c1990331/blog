<?php
namespace core;

use core\db\Mongodb;

class Model extends Mongodb
{
    protected $mongodb;
    public function __construct()
    {
        parent::__construct();
        $this->mongodb = new Mongodb();
    }
}
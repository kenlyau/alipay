<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager as Capsule;

class Config {
    public function __construct ($settings) {
        $capsule = new Capsule;
        $capsule->addConnection($settings['settings']['db']);
        $capsule->bootEloquent();        

    }
}

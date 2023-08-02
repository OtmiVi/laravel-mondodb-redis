<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Cache;

class Cacher{

    public $store = '';
    public function __construct(string $store = 'redis'){
        $this->store = $store;
    }

    public function setCached($key,$value){
        $cachedData = Cache::store($this->store)->put($key,$value);
    }

    public function getCached($key){
        $cachedData =   Cache::store($this->store)->get($key);
        if($cachedData){
            return json_decode($cachedData);
        }
    }

    public function removeCached($key){
        Cache::store($this->store)->forget($key);
    }
}
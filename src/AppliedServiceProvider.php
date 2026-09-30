<?php
namespace ChadPriddle\AppliedApi;
use Illuminate\Support\ServiceProvider; use ChadPriddle\AppliedApi\Auth\TokenManager;
class AppliedServiceProvider extends ServiceProvider {
 public function register():void{$this->mergeConfigFrom(__DIR__.'/../config/applied.php','applied');$this->app->singleton(TokenManager::class,fn($a)=>new TokenManager($a['cache.store']));$this->app->singleton(AppliedClient::class,fn($a)=>new AppliedClient($a->make(TokenManager::class)));$this->app->singleton(Applied::class,fn($a)=>new Applied($a->make(AppliedClient::class)));$this->app->alias(Applied::class,'applied');}
 public function boot():void{$this->publishes([__DIR__.'/../config/applied.php'=>config_path('applied.php')],'applied-config');}
}
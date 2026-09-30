<?php
namespace ChadPriddle\AppliedApi\Auth;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Facades\Http;
use ChadPriddle\AppliedApi\Exceptions\AuthenticationException;
class TokenManager {
 public function __construct(private readonly Cache $cache){}
 public function getToken():string {
  $key='applied_api.token.'.config('applied.environment','mock');
  if($t=$this->cache->get($key)) return $t;
  $k=config('applied.consumer_key'); $s=config('applied.consumer_secret');
  if(!$k||!$s) throw new AuthenticationException('APPLIED_CONSUMER_KEY and APPLIED_CONSUMER_SECRET are required.');
  $r=Http::asForm()->withBasicAuth($k,$s)->timeout(config('applied.timeout',30))->connectTimeout(config('applied.connect_timeout',10))
    ->post(rtrim(config('applied.base_urls.'.config('applied.environment','mock')),'/').config('applied.token_path'),
      ['grant_type'=>'client_credentials','audience'=>config('applied.audience')]);
  if(!$r->successful()) throw new AuthenticationException("Applied authentication failed ({$r->status()}): ".$r->body());
  $t=$r->json('access_token'); if(!$t) throw new AuthenticationException('Applied token response did not contain access_token.');
  $ttl=max(60,(int)$r->json('expires_in',7200)-(int)config('applied.token_expiry_buffer',100)); $this->cache->put($key,$t,now()->addSeconds($ttl)); return $t;
 }
 public function forget():void{$this->cache->forget('applied_api.token.'.config('applied.environment','mock'));}
}
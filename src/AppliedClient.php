<?php
namespace ChadPriddle\AppliedApi;
use Illuminate\Http\Client\Response; use Illuminate\Support\Facades\Http; use Illuminate\Support\Str;
use ChadPriddle\AppliedApi\Auth\TokenManager; use ChadPriddle\AppliedApi\Exceptions\ApiException;
class AppliedClient {
 public function __construct(private readonly TokenManager $tokens){}
 public function get(string $path,array $query=[],array $headers=[],bool $correlation=false):Response{return $this->request('GET',$path,$query,null,$headers,$correlation);}
 public function post(string $path,array $data=[],array $headers=[],bool $correlation=false):Response{return $this->request('POST',$path,[],$data,$headers,$correlation);}
 public function put(string $path,array $data=[],array $headers=[],bool $correlation=false):Response{return $this->request('PUT',$path,[],$data,$headers,$correlation);}
 public function request(string $method,string $path,array $query=[],?array $data=null,array $headers=[],bool $correlation=false):Response {
  $send=function()use($method,$path,$query,$data,$headers,$correlation){$h=array_merge(['Accept'=>'application/json','Accept-Language'=>config('applied.language','en-US')],$headers);
   if($correlation&&!isset($h['Asi-Client-Correlation-Id']))$h['Asi-Client-Correlation-Id']=(string)Str::uuid();
   $opts=['query'=>$query]; if($data!==null)$opts['json']=$data;
   return Http::withToken($this->tokens->getToken())->withHeaders($h)->timeout(config('applied.timeout',30))->connectTimeout(config('applied.connect_timeout',10))
    ->send($method,rtrim(config('applied.base_urls.'.config('applied.environment','mock')),'/').'/'.ltrim($path,'/'),$opts);};
  $r=$send(); if($r->status()===401){$this->tokens->forget();$r=$send();} if(!$r->successful())throw new ApiException("Applied API request failed ({$r->status()}): ".$r->body(),$r); return $r;
 }
}
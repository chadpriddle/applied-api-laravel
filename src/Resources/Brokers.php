<?php
namespace ChadPriddle\AppliedApi\Resources;
use Illuminate\Http\Client\Response;
class Brokers extends Resource {
 public const FILTERS=['QueryValue','QueryValue2','SearchType','IncludeActive','IncludeInactive','PageNumber'];
 public function list(array $filters=[]):Response{return $this->client->get('/sdk/v1/brokers',array_intersect_key($this->q($filters),array_flip(self::FILTERS)),[],true);}
 public function search(string $v,array $f=[]):Response{return $this->list(array_merge(['QueryValue'=>$v],$f));}
}
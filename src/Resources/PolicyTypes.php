<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class PolicyTypes extends Resource { public function list(array $f=[]):Response{return $this->client->get('/policy/v1/policy-types',$this->q($f),[],true);} public function findByCode(string $v):Response{return $this->list(['code'=>$v]);} }
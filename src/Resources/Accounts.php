<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class Accounts extends Resource {
 public function list(array $f=[]):Response{return $this->client->get('/epic/account/v1/accounts',$this->q($f));}
 public function get($id):Response{return $this->client->get('/epic/account/v1/accounts/'.rawurlencode($id));}
 public function searchDetails(array $f=[]):Response{return $this->client->get('/epic/account/v1/accounts/search',$this->q($f));}
 public function search(string $v,array $f=[]):Response{return $this->list(array_merge(['search'=>$v],$f));}
}
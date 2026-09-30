<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class ClientClaims extends Resource { public function list($id,array $f=[]):Response{return $this->client->get('/policy/v1/clients/'.rawurlencode($id).'/claims',$this->q($f));} }
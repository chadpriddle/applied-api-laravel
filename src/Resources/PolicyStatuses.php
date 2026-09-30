<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class PolicyStatuses extends Resource { public function list(array $f=[]):Response{return $this->client->get('/policy/v1/policies/statuses',$this->q($f),[],true);} }
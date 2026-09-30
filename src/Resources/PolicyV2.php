<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class PolicyV2 extends Resource { public function get($id,array $embed=[]):Response{return $this->client->get('/epic/policy/v2/policies/'.rawurlencode($id),$embed?['embed'=>implode(',',$embed)]:[]);} }
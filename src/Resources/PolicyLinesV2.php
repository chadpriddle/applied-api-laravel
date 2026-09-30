<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class PolicyLinesV2 extends Resource {
 private function n(array $f):array{foreach(['embed','expand','organization'] as $k)if(isset($f[$k])&&is_array($f[$k]))$f[$k]=implode(',',$f[$k]);return $f;}
 public function list(array $f=[]):Response{return $this->client->get('/epic/policy/v2/lines',$this->n($f));}
 public function get($id,array $embed=[]):Response{return $this->client->get('/epic/policy/v2/lines/'.rawurlencode($id),$embed?['embed'=>implode(',',$embed)]:[],[],true);}
 public function servicingRoles($id,array $f=[]):Response{return $this->client->get('/epic/policy/v2/lines/'.rawurlencode($id).'/servicing-roles',$this->n($f),[],true);}
}
<?php
namespace ChadPriddle\AppliedApi\Resources; use Illuminate\Http\Client\Response;
class Attachments extends Resource {
 private function n(array $f):array{foreach(['embed','expand'] as $k)if(isset($f[$k])&&is_array($f[$k]))$f[$k]=implode(',',$f[$k]);return $f;}
 public function list(array $f=[]):Response{return $this->client->get('/epic/attachment/v2/attachments',$this->n($f));}
 public function get($id,array $embed=[]):Response{return $this->client->get('/epic/attachment/v2/attachments/'.rawurlencode($id),$embed?['embed'=>implode(',',$embed)]:[]);}
 public function create(array $d):Response{return $this->client->post('/epic/attachment/v2/attachments',$d);}
 public function update($id,array $d):Response{return $this->client->put('/epic/attachment/v2/attachments/'.rawurlencode($id),$d);}
 public function attachTo($attachmentId,$targetId,string $type):Response{return $this->client->post('/epic/attachment/v2/attachments/'.rawurlencode($attachmentId).'/attach-to',['id'=>(string)$targetId,'type'=>$type]);}
}
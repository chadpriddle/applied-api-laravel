<?php
namespace ChadPriddle\AppliedApi\Resources;
use Illuminate\Http\Client\Response;
class Lines extends Resource {
 public const FILTERS=['BillingMode','IssuingCompanyCode','LineID','LineStatusCode','PolicyID','PageNumber'];
 public function list(array $filters=[]):Response{return $this->client->get('/sdk/v1/lines',array_intersect_key($this->q($filters),array_flip(self::FILTERS)),[],true);}
 public function forPolicy($id):Response{return $this->list(['PolicyID'=>$id]);}
}
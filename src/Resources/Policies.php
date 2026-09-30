<?php
namespace ChadPriddle\AppliedApi\Resources;
use Illuminate\Http\Client\Response;
class Policies extends Resource {
 public const FILTERS=['BrokerCommissionCode','BrokerCommissionCodeComparisonType','ClientID','ClientServicingRoleCode','DepartmentCode','EffectiveDateBegins','EffectiveDateEnds','ExpirationDateBegins','ExpirationDateEnds','PolicyID','PolicyNumber','PolicyNumberComparisonType','PolicyTypeCode','ProducerCommissionCode','ProducerCommissionCodeComparisonType','ServicingRoleEmployeeLookupCode','Status','limit','offset'];
 public function list(array $filters=[]):Response{return $this->client->get('/sdk/v1/policies',array_intersect_key($this->q($filters),array_flip(self::FILTERS)),[],true);}
 public function findById($id):Response{return $this->list(['PolicyID'=>$id]);}
}
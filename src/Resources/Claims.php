<?php
namespace ChadPriddle\AppliedApi\Resources;
use Illuminate\Http\Client\Response;
class Claims extends Resource {
 public const FILTERS=['limit','offset','AgencyClaimNumber','ClaimStatus','ClientId','CompanyClaimNumber','CompanyClaimNumberComparisonType','DateOfLossBegins','DateOfLossEnds','DateReportedBegins','DateReportedEnds','Description','DescriptionComparisonType','LossType','PolicyNumber','PolicyNumberComparisonType','ServicingRoleCode','ServicingRoleEmployeeLookupCode'];
 public function list(array $filters=[]):Response{return $this->client->get('/sdk/v1/claims',array_intersect_key($this->q($filters),array_flip(self::FILTERS)),[],true);}
 public function forClient($id):Response{return $this->list(['ClientId'=>$id]);}
}
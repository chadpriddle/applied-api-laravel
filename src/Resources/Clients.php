<?php
namespace ChadPriddle\AppliedApi\Resources;
use Illuminate\Http\Client\Response;
class Clients extends Resource {
 public const FILTERS=['AgencyCode','AgencyDefinedCategory','BranchCode','City','ClaimsAdditionalPartiesInvolvement','ClaimsAdditionalPartiesName','ClaimsAdditionalPartiesPhoneNumber','ClientID','ClientName','ClientStatus','ClientType','CompanyClaimNumber','DateOfLossBegins','DateOfLossEnds','EmailAddress','FirstName','InvoiceNumber','LastName','LineInformationLineID','LoanNumber','LookupCode','PhoneNumber','PolicyNumber','PriorAccountID','RelationshipCode','RelationshipName','SanctionSearchReferenceNumber','ServicingRoleCode','ServicingRoleEmployeeCode','StateProvinceCode','StreetAddress','SubmissionID','VehicleRegistrationNumber','ZipPostalCode','PageNumber'];
 public function list(array $filters=[]):Response{return $this->client->get('/sdk/v1/clients',array_intersect_key($this->q($filters),array_flip(self::FILTERS)),[],true);}
 public function findById($id):Response{return $this->list(['ClientID'=>$id]);} public function findByName(string $v):Response{return $this->list(['ClientName'=>$v]);}
}
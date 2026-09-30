<?php
namespace ChadPriddle\AppliedApi\Resources;
use Illuminate\Http\Client\Response;
class Contacts extends Resource {
 public const FILTERS=['AccountID','AccountTypeCode','Category','City','CityComparisonType','Classification','ClassificationComparisonType','ContactID','DateOfBirthBegins','DateOfBirthEnds','Description','DescriptionComparisonType','EmailAddress','EmailAddressComparisontype','Name','NameComparisonType','Phone','PhoneComparisonType','State'];
 public function list(array $filters=[]):Response{return $this->client->get('/sdk/v1/contacts',array_intersect_key($this->q($filters),array_flip(self::FILTERS)),[],true);}
 
}
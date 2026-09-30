<?php
namespace ChadPriddle\AppliedApi;
use ChadPriddle\AppliedApi\Resources\{Clients,Policies,Lines,Contacts,Companies,Brokers,Employees,Claims,Accounts,PolicyV2,PolicyLinesV2,Attachments,Vendors,ClientPolicies,PolicyTypes,PolicyStatuses,ClientClaims};
class Applied {
 public function __construct(private readonly AppliedClient $c){}
 public function sdk(){return new SdkApi($this->c);} public function epic(){return new EpicApi($this->c);} public function policy(){return new PolicyApi($this->c);}
 public function get(string $p,array $q=[]){return $this->c->get($p,$q);} public function post(string $p,array $d=[]){return $this->c->post($p,$d);} public function put(string $p,array $d=[]){return $this->c->put($p,$d);}
}
class SdkApi{public function __construct(private readonly AppliedClient $c){} public function clients(){return new Clients($this->c);} public function policies(){return new Policies($this->c);} public function lines(){return new Lines($this->c);} public function contacts(){return new Contacts($this->c);} public function companies(){return new Companies($this->c);} public function brokers(){return new Brokers($this->c);} public function employees(){return new Employees($this->c);} public function claims(){return new Claims($this->c);}}
class EpicApi{public function __construct(private readonly AppliedClient $c){} public function accounts(){return new Accounts($this->c);} public function policies(){return new PolicyV2($this->c);} public function policyLines(){return new PolicyLinesV2($this->c);} public function attachments(){return new Attachments($this->c);} public function vendors(){return new Vendors($this->c);}}
class PolicyApi{public function __construct(private readonly AppliedClient $c){} public function clientPolicies(){return new ClientPolicies($this->c);} public function types(){return new PolicyTypes($this->c);} public function statuses(){return new PolicyStatuses($this->c);} public function clientClaims(){return new ClientClaims($this->c);}}

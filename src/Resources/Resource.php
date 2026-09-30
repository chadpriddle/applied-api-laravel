<?php
namespace ChadPriddle\AppliedApi\Resources;
use ChadPriddle\AppliedApi\AppliedClient;
abstract class Resource { public function __construct(protected readonly AppliedClient $client){} protected function q(array $q):array{return array_filter($q,fn($v)=>$v!==null);} }

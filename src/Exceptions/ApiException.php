<?php
namespace ChadPriddle\AppliedApi\Exceptions;
use Illuminate\Http\Client\Response;
class ApiException extends AppliedException {
 public function __construct(string $message, public readonly ?Response $response=null){parent::__construct($message,$response?->status()??0);}
}
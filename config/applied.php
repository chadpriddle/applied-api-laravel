<?php
return [
'environment'=>env('APPLIED_ENV','mock'),'consumer_key'=>env('APPLIED_CONSUMER_KEY'),'consumer_secret'=>env('APPLIED_CONSUMER_SECRET'),
'language'=>env('APPLIED_ACCEPT_LANGUAGE','en-US'),'timeout'=>(int)env('APPLIED_TIMEOUT',30),'connect_timeout'=>(int)env('APPLIED_CONNECT_TIMEOUT',10),
'token_expiry_buffer'=>(int)env('APPLIED_TOKEN_EXPIRY_BUFFER',100),
'base_urls'=>['mock'=>'https://api.mock.myappliedproducts.com','production'=>'https://api.myappliedproducts.com'],
'token_path'=>'/v1/auth/connect/token','audience'=>'api.myappliedproducts.com/epic'];

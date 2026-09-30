# chadpriddle/applied-api-laravel

Laravel Composer wrapper for Applied Systems APIs collected from Applied DevCenter documentation.

## Install
`composer require chadpriddle/applied-api-laravel`

## Configure
```env
APPLIED_ENV=mock
APPLIED_CONSUMER_KEY=your_key
APPLIED_CONSUMER_SECRET=your_secret
APPLIED_ACCEPT_LANGUAGE=en-US
```
Set `APPLIED_ENV=production` for production.

## Examples
```php
use ChadPriddle\\AppliedApi\\Facades\\Applied;
$clients = Applied::sdk()->clients()->list(['ClientName'=>'Smith','PageNumber'=>0]);
$account = Applied::epic()->accounts()->get($accountId);
$policies = Applied::policy()->clientPolicies()->list($clientId);
$attachments = Applied::epic()->attachments()->list(['account'=>$accountId,'embed'=>['folder','account','organizations','accessLevel']]);
Applied::epic()->attachments()->update($attachmentId,['description'=>'Updated']);
```
Authentication is OAuth 2.0 client credentials using the Applied token endpoint. Tokens are cached and a 401 causes one token refresh/retry. API methods return Laravel HTTP Response objects.


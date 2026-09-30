# chadpriddle/applied-api-laravel

Laravel Composer wrapper for the Applied Systems APIs documented in Applied DevCenter.

> **Disclaimer:** This is an independent open-source PHP/Laravel client. It is not affiliated with, sponsored by, or endorsed by Applied Systems, Inc. Applied Systems and related trademarks are property of their respective owners.

## Install

```bash
composer require chadpriddle/applied-api-laravel
```

The package automatically registers its Laravel service provider.

## Configuration

Add your Applied credentials to `.env`:

```env
APPLIED_ENV=mock
APPLIED_CONSUMER_KEY=your_consumer_key
APPLIED_CONSUMER_SECRET=your_consumer_secret
APPLIED_ACCEPT_LANGUAGE=en-US
```

For production:

```env
APPLIED_ENV=production
```

Publish the configuration if you want to customize it:

```bash
php artisan vendor:publish --tag=applied-config
```

### Authentication

The package implements Applied's OAuth 2.0 client-credentials flow:

```text
POST /v1/auth/connect/token
```

It uses the Consumer Key and Consumer Secret with HTTP Basic Authentication and requests:

```text
grant_type=client_credentials
audience=api.myappliedproducts.com/epic
```

Access tokens are cached automatically. If an API request receives HTTP 401, the cached token is cleared and the request is retried once with a new token.

Never commit your Consumer Key or Consumer Secret to GitHub.

---

# Laravel Controller Example

The wrapper is designed to be used directly from a Laravel controller.

For example, suppose you want a controller that searches Applied clients and returns them to your application's frontend.

Create a controller:

```bash
php artisan make:controller AppliedClientController
```

Then:

```php
<?php

namespace App\Http\Controllers;

use ChadPriddle\AppliedApi\Facades\Applied;
use Illuminate\Http\Request;

class AppliedClientController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'ClientName' => $request->input('name'),
            'EmailAddress' => $request->input('email'),
            'ClientStatus' => 'All',
            'PageNumber' => (int) $request->input('page', 0),
        ];

        // Remove filters that were not supplied.
        $filters = array_filter(
            $filters,
            fn ($value) => $value !== null && $value !== ''
        );

        $response = Applied::sdk()->clients()->list($filters);

        return response()->json($response->json());
    }
}
```

Add a route:

```php
use App\Http\Controllers\AppliedClientController;

Route::get('/api/applied/clients', [
    AppliedClientController::class,
    'index',
]);
```

You can then call:

```text
GET /api/applied/clients?name=Smith
```

or:

```text
GET /api/applied/clients?email=john@example.com
```

The controller does not need to manually deal with OAuth tokens or the Applied API base URL. The package handles that for you.

---

# Dependency Injection Example

If you prefer dependency injection instead of the facade, inject `Applied` into your controller:

```php
<?php

namespace App\Http\Controllers;

use ChadPriddle\AppliedApi\Applied;

class AppliedAccountController extends Controller
{
    public function show(Applied $applied, string $accountId)
    {
        $response = $applied
            ->epic()
            ->accounts()
            ->get($accountId);

        return response()->json($response->json());
    }
}
```

This is especially useful if you want your controllers to be easy to unit test.

---

# Creating an Applied Policy

The Policy v1 API can create a policy for a client:

```php
<?php

namespace App\Http\Controllers;

use ChadPriddle\AppliedApi\Facades\Applied;
use Illuminate\Http\Request;

class AppliedPolicyController extends Controller
{
    public function store(Request $request, string $clientId)
    {
        $data = [
            'description' => $request->input('description'),
            'effectiveDate' => $request->input('effectiveDate'),
            'expirationDate' => $request->input('expirationDate'),

            'policyType' => [
                'id' => $request->input('policyTypeId'),
            ],

            'organization' => [
                'agency' => [
                    'id' => $request->input('agencyId'),
                ],
                'branch' => [
                    'id' => $request->input('branchId'),
                ],
                'department' => [
                    'id' => $request->input('departmentId'),
                ],
            ],

            'estimatedPremium' => [
                'units' => $request->input('premiumUnits'),
                'partialUnits' => 0,
            ],

            'lines' => $request->input('lines', []),
        ];

        $response = Applied::policy()
            ->clientPolicies()
            ->create($clientId, $data);

        return response()->json(
            $response->json(),
            $response->status()
        );
    }
}
```

The wrapper JSON-encodes the PHP array and sends:

```text
POST /policy/v1/clients/{clientId}/policies
Content-Type: application/json
Authorization: Bearer ...
```

---

# Working With Attachments

Attachments support listing, retrieving, creating, updating, and attaching an existing attachment to another Applied object.

```php
use ChadPriddle\AppliedApi\Facades\Applied;

// Find attachments for an account.
$response = Applied::epic()
    ->attachments()
    ->list([
        'account' => $accountId,
        'active_status' => 'active',
        'limit' => 100,
        'offset' => 0,
    ]);

// Include related objects.
$response = Applied::epic()
    ->attachments()
    ->list([
        'account' => $accountId,
        'embed' => [
            'folder',
            'account',
            'organizations',
            'accessLevel',
        ],
    ]);

// Retrieve one attachment.
$response = Applied::epic()
    ->attachments()
    ->get($attachmentId);

// Update an attachment.
$response = Applied::epic()
    ->attachments()
    ->update($attachmentId, [
        'description' => 'Updated policy document',
        'active' => true,
        'clientAccessible' => true,
    ]);

// Attach it to another Applied object.
$response = Applied::epic()
    ->attachments()
    ->attachTo(
        $attachmentId,
        $activityId,
        'ACTIVITY'
    );
```

---

# Available API Resources

## SDK v1

```php
Applied::sdk()->clients()
Applied::sdk()->policies()
Applied::sdk()->lines()
Applied::sdk()->contacts()
Applied::sdk()->companies()
Applied::sdk()->brokers()
Applied::sdk()->employees()
Applied::sdk()->claims()
```

## Epic Account v1

```php
Applied::epic()->accounts()
```

Supports:

```php
->list()
->get($accountId)
->search($value)
->searchDetails($filters)
```

## Epic Policy v2

```php
Applied::epic()->policies()
Applied::epic()->policyLines()
```

Policy lines also support:

```php
->servicingRoles($lineId)
```

## Epic Attachment v2

```php
Applied::epic()->attachments()
```

Supports:

```php
->list()
->get($attachmentId)
->create($data)
->update($attachmentId, $data)
->attachTo($attachmentId, $targetId, $type)
```

## Epic Vendor v1

```php
Applied::epic()->vendors()
```

Supports:

```php
->list()
->search($value)
->get($vendorId)
```

## Policy v1

```php
Applied::policy()->clientPolicies()
Applied::policy()->types()
Applied::policy()->statuses()
Applied::policy()->clientClaims()
```

---

# Response Handling

Resource methods return Laravel's:

```php
Illuminate\Http\Client\Response
```

This means you can use the normal Laravel HTTP client response methods:

```php
$response->successful();
$response->status();
$response->json();
$response->body();
$response->header('Content-Type');
```

For example:

```php
$response = Applied::epic()->accounts()->get($accountId);

if ($response->successful()) {
    $account = $response->json();
}
```

Non-2xx API responses throw:

```php
ChadPriddle\AppliedApi\Exceptions\ApiException
```

Authentication failures throw:

```php
ChadPriddle\AppliedApi\Exceptions\AuthenticationException
```

You can handle them in a controller or your application's exception handler.

---

# Raw API Requests

If an endpoint is added to Applied later but isn't yet represented by a convenience resource method, the underlying client can also make direct requests:

```php
$response = Applied::get(
    '/some/path',
    ['foo' => 'bar']
);

$response = Applied::post(
    '/some/path',
    ['foo' => 'bar']
);

$response = Applied::put(
    '/some/path',
    ['foo' => 'bar']
);
```

This allows the package to remain useful while additional Applied endpoints are being added.

---

# API Endpoint Inventory

See [`ENDPOINTS.md`](ENDPOINTS.md) for the complete endpoint inventory currently implemented in this package.

---

# Development

Clone the repository:

```bash
git clone https://github.com/chadpriddle/applied-api-laravel.git
cd applied-api-laravel
```

Install dependencies:

```bash
composer install
```

Run tests:

```bash
vendor/bin/phpunit
```

## License

MIT License.

Copyright (c) 2026 Chad Priddle.

# Endpoint inventory

## SDK v1
GET /sdk/v1/clients
GET /sdk/v1/policies
GET /sdk/v1/lines
GET /sdk/v1/contacts
GET /sdk/v1/companies
GET /sdk/v1/brokers
GET /sdk/v1/employees
GET /sdk/v1/claims

## Epic Account v1
GET /epic/account/v1/accounts
GET /epic/account/v1/accounts/{accountId}
GET /epic/account/v1/accounts/search

## Epic Policy v2
GET /epic/policy/v2/policies/{policyId}
GET /epic/policy/v2/lines
GET /epic/policy/v2/lines/{lineId}
GET /epic/policy/v2/lines/{lineId}/servicing-roles

## Epic Attachment v2
GET /epic/attachment/v2/attachments
GET /epic/attachment/v2/attachments/{attachmentId}
POST /epic/attachment/v2/attachments
PUT /epic/attachment/v2/attachments/{attachmentId}
POST /epic/attachment/v2/attachments/{attachmentId}/attach-to

## Epic Vendor v1
GET /epic/vendor/v1/vendors
GET /epic/vendor/v1/vendors/{vendorId}

## Policy v1
GET /policy/v1/clients/{clientId}/policies
POST /policy/v1/clients/{clientId}/policies
POST /policy/v1/policies/{policyId}/lines
GET /policy/v1/policy-types
GET /policy/v1/policies/statuses
GET /policy/v1/clients/{clientId}/claims

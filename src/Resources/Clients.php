<?php

namespace ChadPriddle\AppliedApi\Resources;

use Illuminate\Http\Client\Response;

class Clients extends Resource
{
    public const FILTERS = [
        'AgencyCode', 'AgencyDefinedCategory', 'BranchCode', 'City',
        'ClaimsAdditionalPartiesInvolvement', 'ClaimsAdditionalPartiesName',
        'ClaimsAdditionalPartiesPhoneNumber', 'ClientID', 'ClientName',
        'ClientStatus', 'ClientType', 'CompanyClaimNumber', 'DateOfLossBegins',
        'DateOfLossEnds', 'EmailAddress', 'FirstName', 'InvoiceNumber',
        'LastName', 'LineInformationLineID', 'LoanNumber', 'LookupCode',
        'PhoneNumber', 'PolicyNumber', 'PriorAccountID', 'RelationshipCode',
        'RelationshipName', 'SanctionSearchReferenceNumber', 'ServicingRoleCode',
        'ServicingRoleEmployeeCode', 'StateProvinceCode', 'StreetAddress',
        'SubmissionID', 'VehicleRegistrationNumber', 'ZipPostalCode', 'PageNumber',
    ];

    /**
     * Get clients as a plain PHP array.
     *
     * Applied's SDK v1 endpoint wraps the records in:
     * Envelope -> Body -> Get_ClientResponse -> Get_ClientResult.
     * This method removes that transport wrapper.
     */
    public function list(array $filters = []): array
    {
        $response = $this->client->get(
            '/sdk/v1/clients',
            array_intersect_key($this->q($filters), array_flip(self::FILTERS)),
            [],
            true
        );

        return $this->extractClients($response);
    }

    /**
     * Return the raw Laravel response when the complete Applied envelope is needed.
     */
    public function response(array $filters = []): Response
    {
        return $this->client->get(
            '/sdk/v1/clients',
            array_intersect_key($this->q($filters), array_flip(self::FILTERS)),
            [],
            true
        );
    }

    private function extractClients(Response $response): array
    {
        $data = $response->json();

        $clients = data_get(
            $data,
            'Envelope.Body.Get_ClientResponse.Get_ClientResult.Clients.Client',
            []
        );

        if ($clients === null) {
            return [];
        }

        // Normalize a single client object to an array of clients.
        if (!array_is_list($clients)) {
            $clients = [$clients];
        }

        return $clients;
    }

    public function findById($id): array
    {
        return $this->list(['ClientID' => $id]);
    }

    public function findByName(string $name): array
    {
        return $this->list(['ClientName' => $name]);
    }
}

<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class FranceTravailTokenService
{
    public function __construct(
        private HttpClientInterface $client,
        private string $clientId,
        private string $clientSecret,
    ) {}

    public function getAccessToken(): ?string
    {
        $response = $this->client->request('POST', 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=/partenaire', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => 'api_offresdemploiv2 o2dsoffre',
            ],
        ]);

        $data = $response->toArray();

        if (!isset($data['access_token'])) {
            throw new \Exception('Token non reçu : ' . json_encode($data));
        }

        return $data['access_token'];
    }
}

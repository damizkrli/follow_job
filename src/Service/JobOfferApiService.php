<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class JobOfferApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private FranceTravailTokenService $tokenService
    ) {}

    public function fetchOffers(
    array $keywords = ['Développeur Web'],
    int $limitPerKeyword = 5,
    array $excludes = ['apprenti', 'alternant', '.NET', 'C#', 'Java', 'Angular']
): array {
    $token = $this->tokenService->getAccessToken();
    $results = [];

    foreach ($keywords as $keyword) {
        $response = $this->client->request('GET', 'https://api.pole-emploi.io/partenaire/offresdemploi/v2/offres/search', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'query' => [
                'motsCles' => $keyword,
                'range' => '0-' . ($limitPerKeyword - 1),
            ],
        ]);

        $offers = $response->toArray()['resultats'] ?? [];

        foreach ($offers as $offer) {
            $title = strtolower($offer['intitule']);

            // On exclut si un mot-clé interdit est présent dans le titre
            $isExcluded = false;
            foreach ($excludes as $excludedWord) {
                if (str_contains($title, strtolower($excludedWord))) {
                    $isExcluded = true;
                    break;
                }
            }

            if (!$isExcluded) {
                $results[$offer['id']] = $offer;
            }
        }
    }

    return array_values($results);
}

}

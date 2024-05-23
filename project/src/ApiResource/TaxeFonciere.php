<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\State\TaxeFonciereProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/TaxeFonciere",
            openapi: new Model\Operation(
                summary: 'Calcul taxe foncière',
                description: 'Ce service permet de calculer la taxe foncière d\'une commune',
            ),
            normalizationContext: ['groups' => ['taxe_fonciere:read']],
            denormalizationContext: ['groups' => ['taxe_fonciere:post']],
            input: TaxeFonciereProcessor::class,
            output: TaxeFonciereProcessor::class,
            processor: TaxeFonciereProcessor::class,
        )
    ]
)]
class TaxeFonciere
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'number'
        ]
    )]
    #[Groups([ 'taxe_fonciere:post'])]
    public float $surface;

    #[ApiProperty(
        openapiContext: [
            'type' => 'number'
        ]
    )]
    #[Groups([ 'taxe_fonciere:post'])]
    public float $prixm²;

    #[ApiProperty(
        openapiContext: [
            'type' => 'number'
        ]
    )]
    #[Groups([ 'taxe_fonciere:read'])]
    public float $result;

    public function process(): void
    {
        $valcad = $this->surface * $this ->prixm²;
        $this->result = $valcad*0.005;       
    }
}
<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\State\TaxeOrduresProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/TaxeOrdures",
            openapi: new Model\Operation(
                summary: 'Calcul taxe d\'enlévement d\'ordures',
                description: 'Ce service permet de calculer la taxe d\'enlévement d\'ordures d\'une commune',
            ),
            normalizationContext: ['groups' => ['taxe_ordures:read']],
            denormalizationContext: ['groups' => ['taxe_ordures:post']],
            input: TaxeOrduresProcessor::class,
            output: TaxeOrduresProcessor::class,
            processor: TaxeOrduresProcessor::class,
        )
    ]
)]
class TaxeOrdures
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'number'
        ]
    )]
    #[Groups([ 'taxe_ordures:write'])]
    public float $valloccad;

    #[ApiProperty(
        openapiContext: [
            'type' => 'number'
        ]
    )]
    #[Groups([ 'taxe_ordures:read'])]
    public float $result;

    public function process(): float
    {
        $this->result = ($this->valloccad/2)*0.0937;       
        return $this->result;
    }
}
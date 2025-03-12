<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Address",
 *     required={"id", "contact_id", "street", "city", "province", "country", "postal_code"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="contact_id", type="integer", example=1),
 *     @OA\Property(property="street", type="string", example="Jalan Sudirman No. 123"),
 *     @OA\Property(property="city", type="string", example="Jakarta"),
 *     @OA\Property(property="province", type="string", example="DKI Jakarta"),
 *     @OA\Property(property="country", type="string", example="Indonesia"),
 *     @OA\Property(property="postal_code", type="string", example="12345"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Address {}
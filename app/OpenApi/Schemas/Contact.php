<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Contact",
 *     required={"id", "user_id", "first_name", "last_name", "email", "phone"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="081234567890"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="addresses",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Address")
 *     )
 * )
 */
class Contact {}
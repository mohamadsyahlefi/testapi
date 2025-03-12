<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Addresses",
 *     description="API Endpoints untuk manajemen alamat kontak"
 * )
 */
class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/contacts/{contact}/addresses",
     *     summary="Mendapatkan semua alamat dari kontak",
     *     tags={"Addresses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="contact",
     *         in="path",
     *         required=true,
     *         description="ID kontak",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/Address")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Contact not found")
     * )
     */
    public function index(Contact $contact): JsonResponse
    {
        if ($contact->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => $contact->addresses
        ]);
    }

    /**
     * @OA\Post(
     *     path="/contacts/{contact}/addresses",
     *     summary="Menambah alamat baru untuk kontak",
     *     tags={"Addresses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="contact",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"street","city","province","country","postal_code"},
     *             @OA\Property(property="street", type="string", example="Jalan Sudirman No. 123"),
     *             @OA\Property(property="city", type="string", example="Jakarta"),
     *             @OA\Property(property="province", type="string", example="DKI Jakarta"),
     *             @OA\Property(property="country", type="string", example="Indonesia"),
     *             @OA\Property(property="postal_code", type="string", example="12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Address created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Address")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Contact not found")
     * )
     */
    public function store(Request $request, Contact $contact): JsonResponse
    {
        if ($contact->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'street' => 'required|string|max:200',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10'
        ]);

        $address = $contact->addresses()->create($validated);

        return response()->json([
            'data' => $address
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/contacts/{contact}/addresses/{address}",
     *     summary="Mendapatkan detail alamat",
     *     tags={"Addresses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="contact",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Address")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Address not found")
     * )
     */
    public function show(Contact $contact, Address $address): JsonResponse
    {
        if ($contact->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => $address
        ]);
    }

    /**
     * @OA\Put(
     *     path="/contacts/{contact}/addresses/{address}",
     *     summary="Mengupdate alamat",
     *     tags={"Addresses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="contact",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="city", type="string"),
     *             @OA\Property(property="province", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="postal_code", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Address updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Address")
     *         )
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Address not found")
     * )
     */
    public function update(Request $request, Contact $contact, Address $address): JsonResponse
    {
        if ($contact->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'street' => 'string|max:200',
            'city' => 'string|max:100',
            'province' => 'string|max:100',
            'country' => 'string|max:100',
            'postal_code' => 'string|max:10'
        ]);

        $address->update($validated);

        return response()->json([
            'data' => $address
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/contacts/{contact}/addresses/{address}",
     *     summary="Menghapus alamat",
     *     tags={"Addresses"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="contact",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Address deleted successfully"
     *     ),
     *     @OA\Response(response=403, description="Forbidden"),
     *     @OA\Response(response=404, description="Address not found")
     * )
     */
    public function destroy(Contact $contact, Address $address): JsonResponse
    {
        if ($contact->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $address->delete();

        return response()->json(null, 204);
    }
}
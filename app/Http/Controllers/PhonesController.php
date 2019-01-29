<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\IndexPhone;
use App\Http\Requests\StorePhone;
use App\Http\Requests\UpdatePhone;
use App\Phone;

class PhonesController extends Controller
{
    /**
     * Display a listing of the phones.
     *
     * @OA\Get(
     *     path="/v1/phones",
     *     summary="Returns phones (paginated)",
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", ref="#/components/schemas/page"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/PhoneWithContact")
     *             ),
     *             @OA\Property(property="first_page_url", ref="#/components/schemas/url"),
     *             @OA\Property(property="from", ref="#/components/schemas/from"),
     *             @OA\Property(property="last_page", ref="#/components/schemas/page"),
     *             @OA\Property(property="last_page_url", ref="#/components/schemas/url"),
     *             @OA\Property(property="next_page_url", ref="#/components/schemas/url"),
     *             @OA\Property(property="path", ref="#/components/schemas/url"),
     *             @OA\Property(property="per_page", ref="#/components/schemas/per-page"),
     *             @OA\Property(property="prev_page_url", ref="#/components/schemas/url"),
     *             @OA\Property(property="to", ref="#/components/schemas/to"),
     *             @OA\Property(property="total", ref="#/components/schemas/total"),
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexPhone $request)
    {
        $filters = $request->validated();
        $phones = Phone::query();
        
        if (!empty($filters['number'])) {
            $phones->where('number', 'like', '%' . $filters['number'] . '%');
        }
        if (!empty($filters['updated_at'])) {
            $phones->where('updated_at', 'like', '%' . $filters['updated_at'] . '%');
        }
        if (!empty($filters['created_at'])) {
            $phones->where('created_at', 'like', '%' . $filters['created_at'] . '%');
        }
        if (!empty($filters['fullname'])) {
            $phones->whereHas('contact', function ($query) use ($filters) {
                $query->where(DB::raw("CONCAT_WS(' ', `surname`, `name`, `patronymic`)"), 'like', '%' . $filters['fullname'] . '%');
            });
        }
        if (!empty($filters['surname'])) {
            $phones->whereHas('contact', function ($query) use ($filters) {
                $query->where('surname', 'like', '%' . $filters['surname'] . '%');
            });
        }
        if (!empty($filters['name'])) {
            $phones->whereHas('contact', function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            });
        }
        if (!empty($filters['patronymic'])) {
            $phones->whereHas('contact', function ($query) use ($filters) {
                $query->where('patronymic', 'like', '%' . $filters['patronymic'] . '%');
            });
        }
        if (!empty($filters['sort'])) {
            $phones->sort($filters['sort']);
        }
        
        return $phones->paginate();
    }

    /**
     * Store a newly created phone in storage.
     *
     * @OA\Post(
     *     path="/v1/phones",
     *     summary="Creates a new phone",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PhoneForm")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PhoneWithContact")
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhone $request)
    {
        return Phone::create($request->validated());
    }

    /**
     * Display the specified phone.
     *
     * @OA\Get(
     *     path="/v1/phones/{phoneId}",
     *     summary="Returns a single phone",
     *     @OA\Parameter(ref="#/components/parameters/phoneId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PhoneWithContact")
     *     )
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Phone::findOrFail($id);
    }

    /**
     * Update the specified phone in storage.
     *
     * @OA\Patch(
     *     path="/v1/phones/{phoneId}",
     *     summary="Updates an existing phone",
     *     @OA\Parameter(ref="#/components/parameters/phoneId"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PhoneForm")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PhoneWithContact")
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhone $request, $id)
    {
        $phone = Phone::findOrFail($id);
        $phone->update($request->validated());
        
        return $phone;
    }

    /**
     * Remove the specified phone from storage.
     *
     * @OA\Delete(
     *     path="/v1/phones/{phoneId}",
     *     summary="Removes a single phone",
     *     @OA\Parameter(ref="#/components/parameters/phoneId"),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation",
     *     )
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $phone = Phone::findOrFail($id);
        $phone->delete();
        
        return response('', 204);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\IndexContact;
use App\Http\Requests\StoreContact;
use App\Http\Requests\UpdateContact;
use App\Contact;

class ContactsController extends Controller
{
    /**
     * Display a listing of the contacts.
     *
     * @OA\Get(
     *     path="/v1/contacts",
     *     summary="Returns contacts (paginated)",
     *     @OA\Parameter(ref="#/components/parameters/page"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ContactWithPhones")
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexContact $request)
    {
        $filters = $request->validated();
        $contacts = Contact::query();
        
        if (!empty($filters['fullname'])) {
            $contacts->where(DB::raw("CONCAT_WS(' ', `surname`, `name`, `patronymic`)"), 'like', '%' . $filters['fullname'] . '%');
        }
        if (!empty($filters['surname'])) {
            $contacts->where('surname', 'like', '%' . $filters['surname'] . '%');
        }
        if (!empty($filters['name'])) {
            $contacts->where('name', 'like', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['patronymic'])) {
            $contacts->where('patronymic', 'like', '%' . $filters['patronymic'] . '%');
        }
        if (!empty($filters['updated_at'])) {
            $contacts->where('updated_at', 'like', '%' . $filters['updated_at'] . '%');
        }
        if (!empty($filters['created_at'])) {
            $contacts->where('created_at', 'like', '%' . $filters['created_at'] . '%');
        }
        if (!empty($filters['phone'])) {
            $contacts->whereHas('phones', function ($query) use ($filters) {
                $query->where('number', 'like', '%' . $filters['phone'] . '%');
            });
        }
        if (!empty($filters['sort'])) {
            $contacts->sort($filters['sort']);
        }
        
        return $contacts->paginate()->getCollection();
    }

    /**
     * Store a newly created contact in storage.
     *
     * @OA\Post(
     *     path="/v1/contacts",
     *     summary="Creates a new contact",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ContactForm")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ContactWithPhones")
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContact $request)
    {
        return Contact::create($request->validated());
    }

    /**
     * Display the specified contact.
     *
     * @OA\Get(
     *     path="/v1/contacts/{contactId}",
     *     summary="Returns a single contact",
     *     @OA\Parameter(ref="#/components/parameters/contactId"),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ContactWithPhones")
     *     )
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Contact::findOrFail($id);
    }

    /**
     * Update the specified contact in storage.
     *
     * @OA\Patch(
     *     path="/v1/contacts/{contactId}",
     *     summary="Updates an existing contact",
     *     @OA\Parameter(ref="#/components/parameters/contactId"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ContactForm")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ContactWithPhones")
     *     )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContact $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update($request->validated());
        
        return $contact;
    }

    /**
     * Remove the specified contact from storage.
     *
     * @OA\Delete(
     *     path="/v1/contacts/{contactId}",
     *     summary="Removes a single contact",
     *     @OA\Parameter(ref="#/components/parameters/contactId"),
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
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return response('', 204);
    }
}

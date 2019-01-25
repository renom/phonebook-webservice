<?php

namespace App;

/**
 * @OA\Schema()
 */
class Phone extends Model
{
/**
 * @OA\Property(property="id", ref="#/components/schemas/id")
 * @OA\Property(property="number", ref="#/components/schemas/number")
 * @OA\Property(property="updated_at", ref="#/components/schemas/updated_at")
 * @OA\Property(property="created_at", ref="#/components/schemas/created_at")
 */
    protected $fillable = ['contact_id', 'number'];
    protected $with = ['contact'];
    protected $arrayable = ['id', 'number', 'updated_at', 'created_at', 'contact'];

    public function contact()
    {
        return $this->belongsTo('App\Contact')->without('phones');
    }
}
/**
 * @OA\Schema(
 *   schema="PhoneWithContact",
 *   allOf={
 *     @OA\Schema(ref="#/components/schemas/Phone"),
 *     @OA\Schema(
 *       @OA\Property(property="contact", ref="#/components/schemas/Contact")
 *     )
 *   }
 * )
 * @OA\Schema(
 *     schema="PhoneForm",
 *     type="object",
 *     required={"number"},
 *     @OA\Property(property="number", ref="#/components/schemas/number")
 * )
 */

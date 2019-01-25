<?php

namespace App;

/**
 * @OA\Schema()
 */
class Contact extends Model
{
/**
 * @OA\Property(property="id", ref="#/components/schemas/id")
 * @OA\Property(property="fullname", ref="#/components/schemas/fullname")
 * @OA\Property(property="surname", ref="#/components/schemas/surname")
 * @OA\Property(property="name", ref="#/components/schemas/name")
 * @OA\Property(property="patronymic", ref="#/components/schemas/patronymic")
 * @OA\Property(property="updated_at", ref="#/components/schemas/updated_at")
 * @OA\Property(property="created_at", ref="#/components/schemas/created_at")
 */
    protected $fillable = ['surname', 'name', 'patronymic'];
    protected $appends = ['fullname'];
    protected $with = ['phones'];
    protected $arrayable = ['id', 'fullname', 'surname', 'name', 'patronymic', 'updated_at', 'created_at', 'phones'];

    public function phones()
    {
        return $this->hasMany('App\Phone')->without('contact');
    }
    
    public function getFullnameAttribute()
    {
        return implode(' ', array_filter([$this->surname, $this->name, $this->patronymic])) ?: null;
    }
}
/**
 * @OA\Schema(
 *   schema="ContactWithPhones",
 *   allOf={
 *     @OA\Schema(ref="#/components/schemas/Contact"),
 *     @OA\Schema(
 *       @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Phone")
 *       )
 *     )
 *   }
 * )
 * @OA\Schema(
 *     schema="ContactForm",
 *     type="object",
 *     required={"surname", "name", "patronymic"},
 *     @OA\Property(property="surname", ref="#/components/schemas/surname"),
 *     @OA\Property(property="name", ref="#/components/schemas/name"),
 *     @OA\Property(property="patronymic", ref="#/components/schemas/patronymic")
 * )
 */

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{
    /**
     * Указываем, что первичный ключ — это UUID, а не автоинкрементное поле.
     */
    protected $primaryKey = 'UUID_USER';
    public $incrementing = false; // Отключаем автоинкремент
    protected $keyType = 'string'; // Указываем тип ключа как строку

    /**
     * Массив заполняемых (fillable) полей.
     */
    protected $fillable = [
        'UUID_USER',
        'login',
        'mail',
        'password_hash',
    ];

    /**
     * Массив скрытых (hidden) полей, которые не будут возвращаться в JSON.
     */
    protected $hidden = [
        'password_hash', // Скрываем хэш пароля
    ];

    /**
     * Отключаем временные метки, если они не нужны (по умолчанию включены).
     */
    public $timestamps = true;

    /**
     * Метод для получения идентификатора JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Возвращает значение первичного ключа
    }

    /**
     * Метод для получения пользовательских претензий (claims) для JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // Можно добавить дополнительные данные, если нужно
    }

    /**
     * Связь с директориями пользователя (один ко многим).
     *
     * @return HasMany
     */
    public function directories(): HasMany
    {
        return $this->hasMany(Dir::class, 'UUID_USER', 'UUID_USER');
    }

    /**
     * Связь с файлами пользователя (один ко многим).
     *
     * @return HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'UUID_USER', 'UUID_USER');
    }
}
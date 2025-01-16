<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasFile;

    protected $fileFields = ['profile_photo', 'cover_photo'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'pinfl',
        'profile_photo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'profile_photo' => 'array',
        ];
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students', 'student_id', 'course_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, "user_roles", "user_id", "role_id")->withPivot('status');
    }


    public function teachersCourses()
    {
        return $this->belongsToMany(Course::class, 'teachers_courses', 'teacher_id', 'course_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }
    public function scopeAdmin($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        });
    }

    public function scopeTeacher($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        });
    }

    public function scopeStudent($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'student');
        });
    }
    public function getProfilePhotoAttribute($value): string
    {
        return $value ? asset('storage/' . $value) : asset('storage/default-profile-photo.jpg');
    }
    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    public function getIsStudentAttribute(): bool
    {
        return $this->role === 'student';
    }

    public function getIsTeacherAttribute(): bool
    {
        return $this->role === 'teacher';
    }
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
    public function user_roles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserRole::class);
    }
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}

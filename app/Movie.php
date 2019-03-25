<?php namespace App;
use Illuminate\Database\Eloquent\Model;
class Movie extends Model
{
    protected $table = 'movies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'rating', 'length', 'onDVD', 'onBluRay', 'description'
    ];

    public function rentals()
    {
        return $this->belongsToMany('App\User', 'rentals')
            ->withPivot(['movie_id', 'user_id', 'rent_date', 'return_date', 'disc_type']);
    }
}

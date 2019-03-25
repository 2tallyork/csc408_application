
<?php namespace App;
use Illuminate\Database\Eloquent\Model;
class Rental extends Model
{
    protected $table = 'rentals';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'movie_id', 'user_id', 'rent_date', 'return_date', 'disc_type'
    ];

    public function movie()
    {
        return $this->belongsTo('App\Movie');

    }

}

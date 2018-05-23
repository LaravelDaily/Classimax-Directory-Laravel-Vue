<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class Company
 *
 * @package App
 * @property string $name
 * @property string $city
 * @property string $address
 * @property text $description
 * @property string $logo
*/
class Company extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = ['name', 'address', 'description', 'logo', 'city_id'];
    protected $hidden = [];
    protected $appends = ['uploaded_logo', 'logo_link',];
    protected $with = ['media'];
    
    public function getUploadedLogoAttribute()
    {
        return $this->getFirstMedia('logo');
    }

    /**
     * @return string
     */
    public function getLogoLinkAttribute()
    {
        $file = $this->getFirstMedia('logo');
        if (! $file) {
            return '';
        }

        return '<a href="' . $file->getUrl() . '" target="_blank">' . $file->file_name . '</a>';
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_company')->withTrashed();
    }
    
}

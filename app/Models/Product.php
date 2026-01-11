<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'category_id',
        'user_id',
        'price',
        'stock',
        'min_order',
        'status',
    ];
    
    protected $attributes = [
        'min_order' => 1,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(Image::class)->where('is_primary', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the image URL attribute
     */
    public function getImageUrlAttribute()
    {
        try {
            $primaryImage = $this->primaryImage;
            if ($primaryImage && $primaryImage->path) {
                // Check if path starts with http (external URL) or is a relative path
                if (str_starts_with($primaryImage->path, 'http')) {
                    return $primaryImage->path;
                }
                return asset('storage/' . $primaryImage->path);
            }
        } catch (\Exception $e) {
            // If relationship fails, return placeholder
        }
        
        // Return a placeholder image if no image exists
        return 'https://via.placeholder.com/100x100?text=No+Image';
    }

    /**
     * Get the is_active attribute (based on status)
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

}

<?php

namespace App\Observers;

use App\Helper\Helper;
use App\Models\Category;

class CategoryObserver
{

    public function updated(Category $category)
    {
        if ($category->getOriginal('img')) {
            $fullAddressName = 'files/images/' . $category->getOriginal('img');
            unlink($fullAddressName);
        }
    }



    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        if ($category->img) {
            $fullAddressName = 'files/images/' . $category->img;
            Helper::removeFile($fullAddressName);
        }

    }
}

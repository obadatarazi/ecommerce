<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Model;

class ReviewService extends BaseService
{

    public function __construct()
{
    $this->model = Review::class;
    parent::__construct();
}
    /**
     * new Review
     */
    public function create($data): Review
    {
        $review = new Review($data);
        $review->fill($data);
        $review->save();

        return $review;
    }

    /**
    * update exist Review
     */
    public function update($data, Review|Model $review): Review
    {
        $review->update($data);
        $review->fill($data);

        return $review;
    }

    /**
     * update publish Review
     * */
    public function togglePublish(Review|Model $review, bool $status): Review
    {
        $review->publish = $status;
        $review->save();

        return $review;
    }

}

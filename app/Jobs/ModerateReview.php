<?php

namespace App\Jobs;

use App\Models\Review;
use App\Services\ContentModerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ModerateReview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $reviewId;

    public function __construct($reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public function handle(ContentModerator $moderator)
    {
        $review = Review::find($this->reviewId);

        if (!$review) return;

        $isSafe = $moderator->validateReview($review->comment);

        $review->status = $isSafe ? 'approved' : 'rejected';
        $review->save();
    }
}

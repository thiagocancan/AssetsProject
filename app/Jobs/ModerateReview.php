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

        try {
            $isSafe = $moderator->validateReview($review->comment);
            $review->status = $isSafe ? 'approved' : 'rejected';
        } catch (\Exception $e) {
            \Log::error("Moderation review error {$this->reviewId}: " . $e->getMessage());
            $review->status = 'error';
        }

        $review->save();
    }
}

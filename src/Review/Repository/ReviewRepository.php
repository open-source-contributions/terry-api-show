<?php

namespace App\Review\Repository;

use App\Review\Entity\Review;

interface ReviewRepository
{
    /**
     * @return int
     */
    public function nextId(): int;

    /**
     * @param Review $review
     */
    public function saveReview(Review $review): void;

    /**
     * @param int $productId
     * @param int $userId
     * @return bool
     */
    public function reviewExists(int $productId, int $userId): bool;

    /**
     * @param int $id
     * @return Review
     */
    public function findReview(int $id): Review;

    /**
     * @return Review[]
     */
    public function findReviews(): array;
}

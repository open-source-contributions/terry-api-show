<?php

declare(strict_types=1);

namespace App\Product;

use App\Product\Exception\ProductNotExists;
use App\Product\Repository\CategoryViewRepository;
use App\Product\Value\Language;
use App\Product\View\CategoryView;
use App\Product\View\ProductView;
use App\Product\Repository\ProductViewRepository;
use App\Product\Value\ProductId;

class ProductService
{
    private CategoryViewRepository $categoryViewRepository;

    private ProductViewRepository $productViewRepository;

    public function __construct(CategoryViewRepository $categoryViewRepository, ProductViewRepository $productViewRepository)
    {
        $this->categoryViewRepository = $categoryViewRepository;
        $this->productViewRepository = $productViewRepository;
    }

    /**
     * @return CategoryView[]
     */
    public function categories(Language $language)
    {

        return $this->categoryViewRepository->findCategoryViews($language);
    }

    /**
     * @return ProductView[]
     */
    public function products(Language $language): array
    {
        return $this->productViewRepository->findProductViews($language);
    }

    public function product(ProductId $productId, Language $language): ProductView
    {
        try {
            return $this->productViewRepository->findProductView($productId, $language);
        } catch (\Throwable $e) {
            throw ProductNotExists::id($productId->toInt());
        }
    }
}

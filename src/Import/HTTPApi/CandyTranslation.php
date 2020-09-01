<?php

declare(strict_types=1);

namespace App\Import\HTTPApi;

use TerryApiBundle\Annotation\HTTPApi;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @HTTPApi
 */
class CandyTranslation
{
    /**
     * @Assert\Type("string")
     * @var string
     */
    public $language;

    /**
     * @Assert\Type("string")
     * @var string
     */
    public $title;
}
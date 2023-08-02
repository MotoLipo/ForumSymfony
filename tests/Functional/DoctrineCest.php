<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Topics;
use Tests\Support\FunctionalTester;

final class DoctrineCest
{
    public function grabNumRecords(FunctionalTester $I)
    {
        $numRecords = $I->grabNumRecords(Topics::class);
        $I->assertSame(3, $numRecords);
    }
}
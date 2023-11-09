<?php

namespace Tests\Unit;

use App\Models\data\AccountTitle;
use PHPUnit\Framework\TestCase;

class AccountTitleTest extends TestCase
{

    public function test_create()
    {
        AccountTitle::firstOrCreate(array('key' => 'value'));
    }

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}

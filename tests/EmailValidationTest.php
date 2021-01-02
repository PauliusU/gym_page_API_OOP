<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

include_once dirname(__DIR__) . '/core/functions/form/validators.php';

final class EmailValidationTest extends TestCase
{
    public function testCanNotBeWithoutTopLevelDomain(): void
    {
        $test_array = [];

        $this->assertEquals(
            false,
            validate_email('test@test', $test_array)
        );
    }
}
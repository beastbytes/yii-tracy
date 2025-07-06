<?php

namespace BeastBytes\Yii\Tracy\Tests;

use BeastBytes\Yii\Tracy\Helper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    #[DataProvider('tables')]
    #[Test]
    public function helper(array $tbody, array $thead, ?bool $th, string $expected): void
    {
        $this->assertSame($expected, Helper::table($tbody, $thead, $th));
    }

    public static function tables(): array
    {
        return [
            'tbody - auto 1st col th' => [
                [
                    ['K1', 'V1'],
                    ['K2', 'V2'],
                    ['K3', 'V3'],
                ],
                [],
                null,
                '<table>'
                . '<tbody>'
                . '<tr><th>K1</th><td>V1</td></tr>'
                . '<tr><th>K2</th><td>V2</td></tr>'
                . '<tr><th>K3</th><td>V3</td></tr>'
                . '</tbody>'
                . '</table>'
            ],
            'tbody & thead - auto 1st col td' => [
                [
                    ['R1V1', 'R1V2', 'R1V3'],
                    ['R2V1', 'R2V2', 'R2V3'],
                    ['R3V1', 'R3V2', 'R3V3'],
                ],
                ['H1', 'H2', 'H3'],
                null,
                '<table>'
                . '<thead><tr><th>H1</th><th>H2</th><th>H3</th></tr></thead>'
                . '<tbody>'
                . '<tr><td>R1V1</td><td>R1V2</td><td>R1V3</td></tr>'
                . '<tr><td>R2V1</td><td>R2V2</td><td>R2V3</td></tr>'
                . '<tr><td>R3V1</td><td>R3V2</td><td>R3V3</td></tr>'
                . '</tbody>'
                . '</table>'
            ],
            'tbody - 1st col td' => [
                [
                    ['K1', 'V1'],
                    ['K2', 'V2'],
                    ['K3', 'V3'],
                ],
                [],
                false,
                '<table>'
                . '<tbody>'
                . '<tr><td>K1</td><td>V1</td></tr>'
                . '<tr><td>K2</td><td>V2</td></tr>'
                . '<tr><td>K3</td><td>V3</td></tr>'
                . '</tbody>'
                . '</table>'
            ],
            'tbody & thead - 1st col th' => [
                [
                    ['R1V1', 'R1V2', 'R1V3'],
                    ['R2V1', 'R2V2', 'R2V3'],
                    ['R3V1', 'R3V2', 'R3V3'],
                ],
                ['H1', 'H2', 'H3'],
                true,
                '<table>'
                . '<thead><tr><th>H1</th><th>H2</th><th>H3</th></tr></thead>'
                . '<tbody>'
                . '<tr><th>R1V1</th><td>R1V2</td><td>R1V3</td></tr>'
                . '<tr><th>R2V1</th><td>R2V2</td><td>R2V3</td></tr>'
                . '<tr><th>R3V1</th><td>R3V2</td><td>R3V3</td></tr>'
                . '</tbody>'
                . '</table>'
            ],
        ];
    }
}

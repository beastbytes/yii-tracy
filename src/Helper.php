<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Tracy;

final class Helper
{
    public static function table(array $tbody, array $thead = [], ?bool $th = null): string 
    {
        $table = '<table>';
        
        if (!empty($thead)) {
            $table .= self::thead($thead);
        }
        
        $table .= self::tbody($tbody, is_null($th) ? empty($thead) : $th);
        
        return $table . '</table>';
    }

    public static function tbody(array $rows, bool $th = false): string 
    {
        $tbody = '<tbody>';
        
        foreach ($rows as $row) {
            $tbody .= '<tr>';
            foreach ($row as $i => $cell) {
                $tbody .= ($i === 0 && $th ? '<th>' : '<td>') . $cell . ($i === 0 && $th ? '</th>' : '</td>');
            }
            $tbody .= '</tr>';
        }
        
        return $tbody . '</tbody>';        
    }
    
    public static function thead(array $cells): string 
    {
        return '<thead><tr><th>' . implode('</th><th>', $cells) . '</th></tr></thead>';
    }   
}
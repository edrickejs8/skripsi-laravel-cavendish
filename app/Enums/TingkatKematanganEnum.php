<?php

namespace App\Enums;

enum TingkatKematanganEnum: string
{
    case Mentah = 'Mentah';
    case Matang = 'Matang';
    case MatangSekali = 'Matang Sekali';
    case Busuk = 'Busuk';
}

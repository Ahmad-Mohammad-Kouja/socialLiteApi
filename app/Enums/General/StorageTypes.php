<?php

namespace App\Enums\General;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StorageTypes extends Enum
{
    const user =   'user';
    const post =   'post';
}

<?php

namespace App\Enums\Social;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FriendShipTypes extends Enum
{
    const accepted =   'accepted';
    const pending =   'pending';
    const rejected =   'rejected';
    const blocked = 'blocked';
    const muted = 'muted';
}

<?php

declare(strict_types=1);

namespace NorseBlue\Optionals\Functions;

use NorseBlue\Optionals\SchroedingerBox;

/**
 * Create a new SchroedingerBox object.
 *
 * @param mixed $cat
 * @param null $default
 *
 * @return \NorseBlue\Optionals\SchroedingerBox
 */
function box($cat, $default = null): SchroedingerBox
{
    return new SchroedingerBox($cat, $default);
}

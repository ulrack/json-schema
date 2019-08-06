<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use Ulrack\Enum\Enum;
use Ulrack\JsonSchema\Component\Map\Draft7;

/**
 * @method static SupportedDraftsEnum DEFAULT()
 * @method static SupportedDraftsEnum DRAFT_07()
 * @method static SupportedDraftsEnum DRAFT_06()
 */
class SupportedDraftsEnum extends Enum
{
    const DRAFT_06 = Draft7::class;
    const DRAFT_07 = Draft7::class;
    const DEFAULT = SupportedDraftsEnum::DRAFT_07;
}

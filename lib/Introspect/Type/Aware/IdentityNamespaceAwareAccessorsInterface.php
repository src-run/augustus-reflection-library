<?php

/*
 * This file is part of the `src-run/augustus-reflection-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Reflection\Introspect\Type\Aware;

/**
 * Class IdentityNamespaceAwareAccessorsTrait.
 */
interface IdentityNamespaceAwareAccessorsInterface
{
    /**
     * @return string
     */
    public function namespaceName();

    /**
     * @return string[]
     */
    public function namespaceSections();
}

/* EOF */

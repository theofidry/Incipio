<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FrontBundle\Utils;

/**
 * Helper class to manipulate IRIs.
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class IriHelper
{
    /**
     * Extract the ID element from the IRI. This assumes that the ID is the last member of the given URI. If the
     * parameter passed is not an URI, its value is left unchanged.
     *
     * @param string $iri
     *
     * @return string ID
     */
    public static function extractId($iri)
    {
        if (0 === strpos($iri, '/')) {
            return substr(strrchr($iri, '/'), 1);
        }

        return $iri;
    }
}

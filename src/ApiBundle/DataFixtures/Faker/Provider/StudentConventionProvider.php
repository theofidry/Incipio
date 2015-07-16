<?php

namespace ApiBundle\DataFixtures\Faker\Provider;

use Faker\Factory;

/**
 * @see    ApiBundle\Entity\StudentConvention
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class StudentConventionProvider
{
    /**
     * Generates a student convention reference from the student full name and the date of signature of the convention.
     *
     * @param \DateTime     $dateOfSignature
     * @param string|string $fullname If is null, a random name is used instead
     *
     * @return string
     */
    public function generateReference(\DateTime $dateOfSignature, $fullname = null)
    {
        if (null === $fullname) {
            // It does not matter if the Faker instance is not based on the application locale as we don't really
            // care of the real value of the name. Keeping this avoid having to inject a faker instance which is
            // more difficul to properly test.
            $fullname = Factory::create()->name();
        }

        $fullnameParts = array_merge(explode(' ', $this->normalizeString($fullname)), ['a', 'b', 'c', 'd', 'e', 'f']);

        $reference = '';
        foreach ($fullnameParts as $part) {
            $referenceLength = strlen($reference);
            if (6 === $referenceLength) {
                break;
            }

            $remaining = 6 - $referenceLength;
            if (3 < $remaining) {
                $remaining = 3;
            }

            $reference .= substr($part, 0, $remaining);
        }

        $reference .= $dateOfSignature->format('Ymd');


        return strtoupper($reference);
    }

    /**
     * Removes any non letter characters from the string except for whitespaces.
     *
     * @param string $string
     *
     * @return string
     */
    private function normalizeString($string)
    {
        $string = str_replace(' ', '______', $string);      // Secure spaces
        $string = preg_replace('/[^A-Za-z\_]/', '', $string); // Removes special characters

        return str_replace('______', ' ', $string);
    }
}

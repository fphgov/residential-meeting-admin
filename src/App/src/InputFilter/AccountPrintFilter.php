<?php

declare(strict_types=1);

namespace App\InputFilter;

use Laminas\Filter;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator;

/** phpcs:disable */
class AccountPrintFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'        => 'id',
            'allow_empty' => false,
            'validators'  => [
                new Validator\NotEmpty([
                    'messages' => [
                        Validator\NotEmpty::IS_EMPTY => 'Kötelező a mező kitöltése',
                        Validator\NotEmpty::INVALID  => 'Hibás mező tipus',
                    ],
                ]),
            ],
            'filters'     => [
                new Filter\StringTrim(),
                new Filter\StripTags(),
                new Filter\StringToUpper(),
            ],
        ]);
    }
}
/** phpcs:enable */

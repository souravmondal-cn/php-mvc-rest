<?php

namespace Services;

class DateTimeOperation
{
    
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function validateDate($date, $format = 'd-m-Y')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

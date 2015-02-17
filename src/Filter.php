<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <aostrycharz@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas;

class Filter extends \Phalcon\Filter
{
    public function __construct()
    {
        $this->dateToTimestampFilter();
        $this->dateToArrayFilter();
        $this->priceToIntFilter();
    }

    private function dateToTimestampFilter()
    {
        $this->add('dateToTimestamp', function($value) {
            try {
                if ($value) {
                    $dateTime = new \DateTime($value);
                    return $dateTime->getTimestamp();
                }
            } catch(\Exception $ex) {
                // break silently
            }
            
            return $value;
        });
    }
    
    private function dateToArrayFilter()
    {
        $this->add('dateToArray', function($value) {
            try {
                if ($value) {
                    $dateTime = new \DateTime($value);

                    $dateArray = array();
                    $dateArray['year'] = $dateTime->format('Y');
                    $dateArray['month'] = $dateTime->format('m');
                    $dateArray['day'] = $dateTime->format('d');

                    return $dateArray;
                }
            } catch(\Exception $ex) {
                // break silently
            }

            return $value;
        });
    }

    private function priceToIntFilter()
    {
        $this->add('priceToInt', function($value) {

            $dotPrice = strpos($value, '.') > strpos($value, ',');

            if ($dotPrice) {
                $price = preg_replace(['/[^0-9\,\.\-]/', '/\,/'], ['', ''], $value);
            } else {
                $price = preg_replace(['/[^0-9\,\.\-]/', '/\./', '/\,/'], ['', '', '.'], $value);;
            }

            $price = $price*100;

            return (int)$price;
        });
    }
}

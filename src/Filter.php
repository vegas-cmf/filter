<?php
/**
 * This file is part of Vegas package
 *
 * @author Arkadiusz Ostrycharz <arkadiusz.ostrycharz@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
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
            if ($value) {
                $dateArray = explode('-', $value);
                
                $value = array();
                $value['year'] = $dateArray[0];
                $value['month'] = $dateArray[1];
                $value['day'] = $dateArray[2];
            }
            
            return $value;
        });
    }
}

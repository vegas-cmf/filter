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
namespace Vegas\Tests;

use Vegas\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    protected $filter;

    protected function setUp()
    {
        $this->filter = new Filter();
    }

    public function testDateToTimestamp()
    {
        $nonDate = 'some random data';

        $value = $this->filter->sanitize($nonDate, 'dateToTimestamp');
        $this->assertEquals($nonDate, $value);

        $time = mktime(0,0,0,3,12,2013);
        $date = date('Y-m-d', $time);

        $value = $this->filter->sanitize($date, 'dateToTimestamp');
        $this->assertEquals($time, $value);

        $timeWithSeconds = mktime(12,10,2,3,12,2013);
        $date = date('Y-m-d H:i:s', $timeWithSeconds);

        $value = $this->filter->sanitize($date, 'dateToTimestamp');
        $this->assertEquals($timeWithSeconds, $value);

        $dateWithoutTime = date('Y-m-d', $timeWithSeconds);

        $value = $this->filter->sanitize($dateWithoutTime, 'dateToTimestamp');
        $this->assertNotEquals($timeWithSeconds, $value);
    }

    public function testDateToArray()
    {
        $nonDate = 'some random data';

        $value = $this->filter->sanitize($nonDate, 'dateToArray');
        $this->assertEquals($nonDate, $value);

        $date = date('Y-m-d');
        $dateArray = explode('-',$date);

        $value = $this->filter->sanitize($date, 'dateToArray');
        $this->assertEquals($dateArray[0], $value['year']);
        $this->assertEquals($dateArray[1], $value['month']);
        $this->assertEquals($dateArray[2], $value['day']);
    }

    public function testPriceToInt()
    {
        $nonPrice = 'some random data';

        $value = $this->filter->sanitize($nonPrice, 'priceToInt');
        $this->assertEquals(0, $value);

        $price = '0.99';
        $value = $this->filter->sanitize($price, 'priceToInt');
        $this->assertEquals(99, $value);

        $price = '1234.99';
        $value = $this->filter->sanitize($price, 'priceToInt');
        $this->assertEquals(123499, $value);

        $price = '1 234.99';
        $value = $this->filter->sanitize($price, 'priceToInt');
        $this->assertEquals(123499, $value);

        $price = '1 234,99';
        $value = $this->filter->sanitize($price, 'priceToInt');
        $this->assertEquals(123499, $value);
    }
}

<?php

namespace Fizz\Ranker\Test;

use PHPUnit\Framework\TestCase;

class RankerTest extends TestCase
{
    public function files()
    {
        return [
            ['fixtures/1.in.json'],
        ];
    }

    /**
     * @dataProvider files
     */
    public function testRanker(string $url)
    {
        $in = fetch($url);
        $out = ranker($in);
        $in = collect($in);

        $this->assertSameSize($in, $out);
        $this->assertEquals($in->sum('scores'), $out->sum('scores'));

        $this->assertEquals($out->pluck('rank'), $out->pluck('rank')->sort());
        // dd($out);
        $this->assertEquals(9, $out->sum('rank'));
    }
}

<?php

namespace Fizz\Ranker\Test;

use PHPUnit\Framework\TestCase;

class RankerTest extends TestCase
{
    public function files()
    {
        return [
            ['fixtures/1.in.json', 9, 'c2e19d3e672fa85cc71f5741c58450561dcaa5e5'],
            ['fixtures/2.in.json', 1906049, 'efe7a9d09dfca172f3ae74d81effbe9934b32a85'],
        ];
    }

    /**
     * @dataProvider files
     */
    public function testRanker(string $url, int $rankSum, string $teamHash)
    {
        $in = fetch($url);
        $out = ranker($in);
        $in = collect($in);

        $this->assertSameSize($in, $out);
        $this->assertEquals($in->sum('scores'), $out->sum('scores'));
        $this->assertEquals($teamHash, sha1($out->pluck('team')->sortDesc(SORT_NATURAL)->join(':')));

        $this->assertEquals($out->pluck('rank'), $out->pluck('rank')->sort());
        $this->assertEquals($rankSum, $out->sum('rank'));
    }
}

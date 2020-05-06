<?php

use Tightenco\Collect\Support\Collection;

function rankByUrl(string $url): string
{
    $data = fetch($url);
    return ranker($data)->toJson();
}

function fetch(string $url): array
{
    return json_decode(file_get_contents($url), true);
}

/**
 * @param Collection|array $data
 */
function ranker(iterable $data)
{
    return collect($data)
        ->sortByDesc('scores')
        ->zip(range(1, count($data)))
        ->map(function ($item) {
            [$item, $rank] = $item;
            $item['rank'] = $rank;
            return $item;
        })
        ->groupBy('scores')
        ->map('adjustGroupRank')->flatten(1)
    ;
}

function adjustGroupRank($groupped)
{
    $rank = $groupped->min('rank');
    return $groupped->map(function ($item) use ($rank) {
        $item['rank'] = $rank;
        return $item;
    });
}

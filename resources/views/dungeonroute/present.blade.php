@extends('layouts.map', [
    'custom' => true,
    'footer' => false,
    'header' => false,
    'title' => $dungeonroute->title,
    'cookieConsent' => false,
    'showAds' => false,
])
<?php
/** @var $dungeonroute \App\Models\DungeonRoute\DungeonRoute */
/** @var $floor \App\Models\Floor\Floor */

$affixes         = $dungeonroute->affixes->pluck('text', 'id');
$selectedAffixes = $dungeonroute->affixes->pluck('id');
if (count($affixes) == 0) {
    $affixes         = [-1 => __('view_dungeonroute.view.any')];
    $selectedAffixes = -1;
}

$dungeon = \App\Models\Dungeon::findOrFail($dungeonroute->dungeon_id);
?>
@section('linkpreview')
    <?php
    $defaultDescription = $dungeonroute->author === null ?
        sprintf(__('view_dungeonroute.view.linkpreview_default_description_sandbox'), __($dungeonroute->dungeon->name))
        : sprintf(__('view_dungeonroute.view.linkpreview_default_description'), __($dungeonroute->dungeon->name), $dungeonroute->author?->name);
    ?>
    @include('common.general.linkpreview', [
        'title' => sprintf(__('view_dungeonroute.view.linkpreview_title'), $dungeonroute->title),
        'description' => empty($dungeonroute->description) ? $defaultDescription : $dungeonroute->description,
        'image' => $dungeonroute->dungeon->getImageUrl()
    ])
@endsection

@section('content')
    <div class="wrapper">
        @include('common.maps.map', [
            'dungeon' => $dungeon,
            'mappingVersion' => $dungeonroute->mappingVersion,
            'dungeonroute' => $dungeonroute,
            'edit' => false,
            'floorId' => $floor->id,
            'noUI' => false,
            'gestureHandling' => false,
            'showAttribution' => false,
            'show' => [
                'header' => false,
                'controls' => [
                    'present' => true,
                    'pulls' => true,
                    'enemyInfo' => false,
                    'raiderioKsgAttribution' => true,
                ],
                'share' => [
                    'link' => !$dungeonroute->isSandbox(),
                    'embed' => !$dungeonroute->isSandbox(),
                    'mdt-export' => $dungeon->mdt_supported,
                    'publish' => false,
                ]
            ],
            'hiddenMapObjectGroups' => [
                'floorunion',
                'floorunionarea',
            ],
        ])
    </div>
@endsection


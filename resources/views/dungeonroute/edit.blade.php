<?php
/** @var $dungeonroute \App\Models\DungeonRoute\DungeonRoute */
/** @var $floor \App\Models\Floor\Floor */
$dungeon = $dungeonroute->dungeon->load(['expansion', 'floors']);

$sandbox = $dungeonroute->isSandbox();
?>

@extends('layouts.map', ['title' => sprintf(__('view_dungeonroute.edit.title'), $dungeonroute->title)])

@include('common.general.inline', [
    'path' => 'dungeonroute/edit',
    'dependencies' => ['common/maps/map'],
    'options' => [
        'dungeonroute' => $dungeonroute,
        'levelMin' => config('keystoneguru.keystone.levels.min'),
        'levelMax' => config('keystoneguru.keystone.levels.max'),
    ]
])

@section('linkpreview')
    @include('common.general.linkpreview', [
        'title' => sprintf(__('view_dungeonroute.edit.linkpreview_title'), $dungeonroute->title),
        'description' => !empty($dungeonroute->description) ?
            $dungeonroute->description :
            ($dungeonroute->isSandbox() ?
            sprintf(__('view_dungeonroute.edit.linkpreview_default_description_sandbox'), __($dungeonroute->dungeon->name)) :
            sprintf(__('view_dungeonroute.edit.linkpreview_default_description'), __($dungeonroute->dungeon->name), $dungeonroute->author->name)),
            'image' => $dungeonroute->dungeon->getImageUrl()
    ])
@endsection

@section('content')
    <div class="wrapper">
        @include('common.maps.map', [
            'dungeon' => $dungeon,
            'dungeonroute' => $dungeonroute,
            'edit' => true,
            'sandboxMode' => $sandbox,
            'floorId' => $floor->id,
            'show' => [
                'header' => true,
                'controls' => [
                    'draw' => true,
                    'pulls' => true,
                    'enemyInfo' => true,
                ],
                'share' => [
                    'link' => !$sandbox,
                    'embed' => !$sandbox,
                    'mdt-export' => $dungeon->mdt_supported,
                    'publish' => !$sandbox,
                ]
            ],
            'hiddenMapObjectGroups' => [
                'floorunion',
                'floorunionarea'
            ],
        ])
    </div>
@endsection

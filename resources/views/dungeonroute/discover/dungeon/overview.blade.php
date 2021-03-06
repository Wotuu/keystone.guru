@extends('layouts.sitepage', ['rootClass' => 'discover col-xl-10 offset-xl-1', 'breadcrumbsParams' => [$dungeon], 'title' => sprintf('%s routes', $dungeon->name)])

<?php
/**
 * @var $currentAffixGroup \App\Models\AffixGroup
 * @var $showAds boolean
 * @var $isMobile boolean
 * @var $dungeon \App\Models\Dungeon
 * @var $dungeonroutes array
 */
?>

@include('common.general.inline', ['path' => 'dungeonroute/discover/discover',
        'options' =>  [
        ]
])

@section('content')
    @include('dungeonroute.discover.wallpaper', ['dungeon' => $dungeon])

    @include('dungeonroute.discover.panel', [
        'title' => __('Popular'),
        'link' => route('dungeonroutes.discoverdungeon.popular', ['dungeon' => $dungeon]),
        'currentAffixGroup' => $currentAffixGroup,
        'dungeonroutes' => $dungeonroutes['popular'],
        'showMore' => true,
    ])

    @include('dungeonroute.discover.panel', [
        'title' => __('Popular routes by current affixes'),
        'link' => route('dungeonroutes.discoverdungeon.thisweek', ['dungeon' => $dungeon]),
        'currentAffixGroup' => $currentAffixGroup,
        'affixgroup' => $currentAffixGroup,
        'dungeonroutes' => $dungeonroutes['thisweek'],
        'showMore' => true,
    ])

    @if( !$adFree && !$isMobile)
        <div align="center" class="mt-4">
            @include('common.thirdparty.adunit', ['id' => 'site_middle_discover', 'type' => 'header', 'reportAdPosition' => 'top-right'])
        </div>
    @endif

    @include('dungeonroute.discover.panel', [
        'title' => __('Popular routes by next affixes'),
        'link' => route('dungeonroutes.discoverdungeon.nextweek', ['dungeon' => $dungeon]),
        'currentAffixGroup' => $currentAffixGroup,
        'affixgroup' => $nextAffixGroup,
        'dungeonroutes' => $dungeonroutes['nextweek'],
        'showMore' => true,
    ])
    @include('dungeonroute.discover.panel', [
        'title' => __('Newly published routes'),
        'link' => route('dungeonroutes.discoverdungeon.new', ['dungeon' => $dungeon]),
        'currentAffixGroup' => $currentAffixGroup,
        'dungeonroutes' => $dungeonroutes['new'],
        'showMore' => true,
    ])

    @component('common.general.modal', ['id' => 'userreport_dungeonroute_modal'])
        @include('common.modal.userreport.dungeonroute')
    @endcomponent
@endsection
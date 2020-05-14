@extends('layouts.app', ['showAds' => false, 'title' => __('User list')])

@section('header-title')
    {{ __('View Users') }}
@endsection

<?php
/** @var $models \Illuminate\Support\Collection */
// eager load the classification
//dd($models);
?>

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#admin_user_table').DataTable({});
        });
    </script>
@endsection

@section('content')
    <table id="admin_user_table" class="tablesorter default_table table-striped">
        <thead>
        <tr>
            <th width="5%">{{ __('Id') }}</th>
            <th width="20%">{{ __('Name') }}</th>
            <th width="15%">{{ __('# routes') }}</th>
            <th width="10%">{{ __('Roles') }}</th>
            <th width="15%">{{ __('Registered') }}</th>
            <th width="35%">{{ __('Actions') }}</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($models as $user)
            <?php /** @var $user \App\User */?>
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->dungeonroutes->count() }}</td>
                <td>{{ implode(', ', $user->roles->pluck('display_name')->toArray())}}</td>
                <td>{{ $user->created_at->setTimezone('Europe/Amsterdam') }}</td>
                <td>
                    <?php
                    // I really want to be the only one doing this
                    if( Auth::user()->name === 'Admin' ){ ?>
                    <div class="row">
                        {{ Form::model($user, ['route' => ['admin.user.makeadmin', $user->id], 'autocomplete' => 'off', 'method' => 'post']) }}
                        {!! Form::submit(__('Make admin'), ['class' => 'btn btn-info', 'name' => 'submit']) !!}
                        {!! Form::close() !!}

                        {{ Form::model($user, ['route' => ['admin.user.makeuser', $user->id], 'autocomplete' => 'off', 'method' => 'post']) }}
                        {!! Form::submit(__('Make user'), ['class' => 'btn btn-info ml-1', 'name' => 'submit']) !!}
                        {!! Form::close() !!}

                        {{ Form::model($user, ['route' => ['admin.user.delete', $user->id], 'autocomplete' => 'off', 'method' => 'delete']) }}
                        {!! Form::submit(__('Delete user'), ['class' => 'btn btn-danger ml-1', 'name' => 'submit']) !!}
                        {!! Form::close() !!}
                    </div>
                    <?php } else {
                        echo _('Please login as "Admin"');
                    }
                    ?>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
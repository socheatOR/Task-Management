@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h5">{{ __('Dashboard') }}</div>
                <div class="row p-2">
                    @foreach($cards as $card)
                        <div class="col-md-6">
                            <div class="card mb-6">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $card['title'] }}</h5>
                                    <p class="card-text text-center font-weight-bold text-lg">{{ $card['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-header h5">{{ __('Task Group By Due Date') }}</div>
                @foreach($taskGroupBy as $dueDate => $taskGroup)
                    <h5 class="card-header">{{ \Carbon\Carbon::parse($dueDate)->format('F j, Y') }}</h5>
                    <ul class="list-group mb-4 p-2">
                        @foreach($taskGroup as $task)
                            <li class="list-group-item">
                                <h5>{{ $task->name }}</h5>
                                <p>{{ $task->description }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

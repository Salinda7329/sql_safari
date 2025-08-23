@extends('layouts.app')

@section('title','Achievements & Leaderboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">🏆 Achievements & Leaderboard</h2>

    {{-- Player’s Achievements --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            🎖️ Your Achievements
        </div>
        <div class="card-body row">
            @if($player && $player->achievements->count())
                @foreach($player->achievements as $achievement)
                    <div class="col-md-4 text-center mb-3">
                        <img src="{{ asset('images/badges/'.$achievement->badge_image) }}"
                             alt="{{ $achievement->name }}"
                             class="img-fluid mb-2" style="max-width:100px;">
                        <h6>{{ $achievement->name }}</h6>
                        <small class="text-muted">{{ $achievement->description }}</small>
                    </div>
                @endforeach
            @else
                <p class="text-muted">You don’t have any badges yet. Keep playing! 🚀</p>
            @endif
        </div>
    </div>

    {{-- Leaderboard --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            🌍 Global Leaderboard
        </div>
        <div class="card-body">
            <table class="table table-striped text-center align-middle">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Badges</th>
                        <th>Highest Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaderboard as $i => $user)
                        <tr @if($player && $player->id === $user->id) class="table-success" @endif>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->achievements_count }}</td>
                            <td>{{ $user->progress?->highest_level ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="/sql-game/{{ $player->progress->current_level ?? 1 }}" class="btn btn-lg btn-success">
            ➡️ Continue Journey
        </a>
    </div>
</div>
@endsection

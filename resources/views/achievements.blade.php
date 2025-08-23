@extends('layouts.app')

@section('title', 'Achievements')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">🏆 Your Achievements</h2>

        <div class="row">
            @foreach ($player->achievements as $achievement)
                <div class="col-md-4 text-center mb-4">
                    <img src="{{ asset('images/badges/' . $achievement->badge_image) }}" alt="{{ $achievement->name }}"
                        class="img-fluid" style="max-width:120px;">
                    <h5 class="mt-2">{{ $achievement->name }}</h5>
                    <p>{{ $achievement->description }}</p>
                </div>
            @endforeach
        </div>

        <hr>

        <h3 class="mt-4">🌍 Leaderboard</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboard as $i => $player)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $player->name }}</td>
                        <td>{{ $player->score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="/sql-game/2" class="btn btn-success">➡️ Continue to Level 2</a>
        </div>
    </div>
@endsection

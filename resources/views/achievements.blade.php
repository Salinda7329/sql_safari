{{-- resources/views/achievements/index.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
  .achv-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
  }
  @media (max-width: 992px) {
    .achv-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  }
  @media (max-width: 576px) {
    .achv-grid { grid-template-columns: 1fr; }
  }

  .achv-card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    padding: 16px;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    position: relative;
    display: flex;
    gap: 12px;
  }
  .achv-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    display: grid; place-items: center;
    flex: 0 0 56px;
    color: #fff;
  }
  .achv-body h3 {
    margin: 0 0 6px;
    font-size: 1.05rem;
    line-height: 1.2;
  }
  .achv-body p {
    margin: 0 0 10px;
    color: #4b5563;
    font-size: .95rem;
  }
  .achv-chip {
    font-size: .8rem;
    padding: 4px 8px;
    border-radius: 999px;
    display: inline-block;
  }
  .achv-chip.earned {
    background: #dcfce7; color: #166534; border: 1px solid #86efac;
  }
  .achv-chip.locked {
    background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb;
  }
</style>

<div class="container">
  <h1>{{ $userName }}’s Achievements</h1>

  @php
    // nice, high-contrast palette for icons
    $palette = ['#6366F1','#EC4899','#10B981','#F59E0B','#06B6D4','#8B5CF6','#EF4444','#22C55E','#F97316'];
  @endphp

  <div class="achv-grid">
    @forelse($achievements as $a)
      @php
        $color = $palette[($a->id - 1) % count($palette)];
      @endphp

      <div class="achv-card">
        <div class="achv-icon" style="background: {{ $color }}">
          {{-- medal/trophy style SVG icon (white fill) --}}
          <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17 3H7v4a5 5 0 1 0 10 0V3Zm-5 13a7 7 0 0 1-7-7V3H3v2a7 7 0 0 0 6 6.93V21l3-1 3 1v-9.07A7 7 0 0 0 21 5V3h-2v6a7 7 0 0 1-7 7Z"/>
          </svg>
        </div>

        <div class="achv-body">
          <h3>{{ $a->name }}</h3>
          <p>{{ $a->description }}</p>

          @if ($a->earned_at)
            <span class="achv-chip earned">
              Earned on {{ \Carbon\Carbon::parse($a->earned_at)->format('Y-m-d H:i') }}
            </span>
          @else
            <span class="achv-chip locked">Not earned yet</span>
          @endif
        </div>
      </div>
    @empty
      <p>No achievements configured.</p>
    @endforelse
  </div>
</div>
@endsection

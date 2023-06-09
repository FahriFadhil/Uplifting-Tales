@extends('layouts.app')

@section('content')
<div class="px-64 py-16 flex flex-col">
  <h1 class="text-4xl">{{ $data_user->name }} Bookmarked Stories</h1>
  @if( $data_user_bookmark->count() == 0 )
  <div class="flex flex-col items-center gap-1 mt-8">
    <h2 class="text-lg">Sorry, this user haven't bookmarked any story yet.</h2>
  </div>
  @else
  <div class="grid grid-cols-2 gap-x-12">
    @foreach( $data_user_bookmark as $row )
    <div class="flex flex-col mt-12 pb-8 border-b">
      <div class="flex items-center gap-3">
        @if( $row->story->pfp != null)
        <div class="h-6 w-6 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{  $row->story->pfp }}')]"></div>
        @else
        <div class="h-6 w-6 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
        @endif
        <a href="/user/{{ $row->user->slug }}" class="text-sm font-semibold hover:underline">{{ $row->story->user->name }}</a>
        <span>•</span>
        <p class="text-xs opacity-50">{{ ($row->story->updated_at)->format('M d, Y') }}</p>
      </div>
      <a href="/story/{{ $row->story->slug }}" class="group">
        <h2 class="group-hover:underline text-lg my-2 font-semibold leading-normal pe-8">{{ $row->story->title }}</h2>
        <p class="text-sm pe-8">{!! implode(' ', array_slice(explode(' ', $row->story->body), 0, 40)) . (strlen($row->story->body) > 40 ? '...' : '') !!}</p>
      </a>
      <div class="flex items-end justify-between">
        <div class="flex items-center gap-3 mt-5">
          <div class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs">{{ $row->story->readtime }}</span>
          </div>
          <span>•</span>
          <div class="flex items-center gap-1">
            <a href="/tag/{{ $row->story->tag->body }}" class="py-1 px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full text-xs">{{ $row->story->tag->body }}</a>
          </div>
        </div>
        @if( $row->story->user_id == Auth::user()->id )
        <a href="/story/edit/{{ $row->story->slug }}" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
          </svg>
          <span class="text-sm text-sky-700">Edit</span>
        </a>
        @else
        <div class="flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-rose-500 hover:stroke-rose-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
          </svg>
          <button onclick="toggleBookmark(dataset.storyId)" data-story-id="{{ $row->story->id }}" class="bookmark-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-orange-500 hover:stroke-orange-500 cursor-pointer fill-orange-500">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
            </svg>
          </button>
        </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  {{ $data_user_bookmark->appends(request()->query())->links() }}
  @endif
</div>
@endsection
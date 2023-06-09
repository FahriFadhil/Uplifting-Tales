@extends('layouts.app')

@section('content')
<div class="px-64 py-16 flex justify-between">
  <div class="w-7/12">
    <h1 class="text-4xl">{{ $data_story->title }}</h1>
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-4 my-2 opacity-50">
        <p class="text-sm">{{ ($data_story->updated_at)->format('M d, Y') }}</p>
        <span class="text-md">|</span>
        <div class="flex items-center gap-1 ">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p class="text-sm">{{ $data_story->readtime }}</p>
        </div>
      </div>
      <p>Tag:
        <a href="" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 transition rounded-full ms-1">{{ $data_story->tag->body }}</a>
      </p>
    </div>
    <div class="text-lg py-4 border-b-2" id="detail_body">{!! $data_story->body !!}</div>
    <!-- Comments Sections -->
    <div class="flex flex-col gap-2 mt-4">
      <h2 class="text-2xl font-semibold">Comments</h2>
      <form action="/comment/store" class="my-2 flex items-start gap-4 pb-4">
        @if( $data_story->user->pfp != null)
        <div class="h-10 w-10 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{  $data_story->user->pfp }}')]"></div>
        @else
        <div class="h-10 w-10 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
        @endif
        <textarea type="text" name="body" class="border rounded-lg py-2 px-4 w-full outline-0 focus:shadow resize-none" placeholder="Tambahkan Komentar Kamu…"></textarea>
        <input type="hidden" name="story_id" value="{{ $data_story->id }}">
        <button type="submit" class="p-3 bg-sky-50 hover:bg-sky-100 rounded-full shadow">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
          </svg>
        </button>
      </form>
      <div class="flex flex-col" id="comment_section">
        @if($data_comment->count()==0)
        <p class="text-center text-lg">Belum ada Komentar, Jadilah yang pertama berkomentar.</p>
        @else

        @foreach($data_comment as $row)
        <div class="flex flex-col pb-3 mb-6 border-b">
          <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-4">
              <img class="w-6 h-6 rounded-full shadow" src="https://source.unsplash.com/400x400?profile" alt="...">
              <a href="/user/{{ $row->user->slug }}" class="text-md font-semibold hover:underline">{{ $row->user->name }}</a>
            </div>
            <p class="text-xs opacity-50">{{ ($row->updated_at)->format('M d, Y') }}</p>
          </div>
          <form id="form-comment-edit-{{ $row->id }}" action="/comment/update/{{ $row->id }}" method="post">
            @csrf
            {{ method_field('PUT') }}
            <input type="hidden" name="story_id" value="{{ $row->story->id }}">
            <textarea type="text" name="body" class="w-full outline-0 resize-none" data-comment_id="{{ $row->id }}" readonly onfocusout="setAttribute('readonly', 'readonly'); classList.remove('onEdit'); const el2 = document.querySelector('#btn-comment-edit-{{ $row->id }}'); el2.classList.remove('hidden'); setTimeOut(el2.nextElementSibling.firstElementChild.classList.add('hidden'), 10)">{{ $row->body }}</textarea>
          </form>

          <div class="flex justify-end items-start gap-2">
            <div class="mt-[1px] hover:scale-[1.1] cursor-pointer">
              <svg id="btn-comment-edit-{{ $row->id }}" onclick="const el = document.querySelector('#form-comment-edit-{{ $row->id }}'); el.lastElementChild.removeAttribute('readonly'); el.lastElementChild.focus(); el.lastElementChild.classList.add('onEdit'); nextElementSibling.firstElementChild.classList.remove('hidden'); classList.add('hidden')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-sky-700">
                <path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
              </svg>
              <a href="/comment/update/{{ $row->id }}" onclick="event.preventDefault(); document.getElementById('form-comment-edit-{{ $row->id }}').submit();">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-sky-700 hidden">
                  <path class="pointer-events-none" stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
              </a>
            </div>
            <form action="/comment/destroy/{{ $row->id }}" method="post" class="group">
              @csrf
              {{ method_field('DELETE') }}
              <button type="submit" class="group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-sky-700 group-hover:scale-[1.1] transition">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
              </button>
            </form>
          </div>
        </div>
        @endforeach

        @endif
      </div>
    </div>
    <!-- End -->
  </div>
  <div class="w-4/12">
    <div class="sticky top-24">

      @if( $data_story->user_id == Auth::user()->id )
      <div class="flex items-center gap-4">
        <a href="/story/edit/{{ $data_story->slug }}" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
          </svg>
          <span class="text-sm text-sky-700">Edit</span>
        </a>
        <form action="/story/destroy/{{ $data_story->id }}" method="post" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
          @csrf
          {{ method_field('DELETE') }}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
          </svg>
          <button type="submit" class="text-sm text-sky-700">Delete</button>
        </form>
      </div>
      @elseif( Auth::user()->authorization == 'admin' )
      <div class="flex items-center gap-4">
        <a href="" class="flex items-center gap-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 group-hover:fill-rose-500 group-hover:stroke-rose-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
          </svg>
          <p>Like</p>
        </a>
        <a href="" class="flex items-center gap-2 group">
          @php
          $isBookmarked = $data_story_bookmarked->contains('story_id', $data_story->id);
          @endphp
          <button onclick="toggleBookmark(dataset.storyId)" data-story-id="{{ $data_story->id }}" class="bookmark-btn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-orange-500 hover:stroke-orange-500 cursor-pointer {{ $isBookmarked ? 'fill-orange-500' : '' }}">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
            </svg>
          </button>
          <p>Bookmark</p>
        </a>
        <form action="/story/destroy/{{ $data_story->id }}" method="post" class="flex items-center gap-2 py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full">
          @csrf
          {{ method_field('DELETE') }}
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 stroke-sky-700">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
          </svg>
          <button type="submit" class="text-sm text-sky-700">Delete</button>
        </form>
      </div>
      @else
      <div class="flex items-center gap-4">
        <a href="" class="flex items-center gap-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 group-hover:fill-rose-500 group-hover:stroke-rose-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
          </svg>
          <p>Like</p>
        </a>
        <a href="" class="flex items-center gap-2 group">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 group-hover:fill-orange-500 group-hover:stroke-orange-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
          </svg>
          <p>Bookmark</p>
        </a>
      </div>
      @endif

      <h2 class="text-xl font-semibold mt-8">Tentang Penulis</h2>
      <div class="flex items-center justify-between shadow px-4 rounded-lg mt-2">
        <a href="/user/{{ $data_story->user->slug }}" class="flex gap-4 items-center py-4 group">
          @if( $data_story->user->pfp != null)
          <div class="h-8 w-8 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('storage/images') }}/{{  $data_story->user->pfp }}')]"></div>
          @else
          <div class="h-8 w-8 shadow rounded-full bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images') }}/profile.png')]"></div>
          @endif
          <p class="text-lg group-hover:underline">{{ $data_story->user->name }}</p>
        </a>
        @if( $data_story->user_id == Auth::user()->id )
        @else
        <a href="" class="py-2 px-4 bg-sky-50 hover:bg-sky-100 rounded-full transition">Follow</a>
        @endif
      </div>

      @if( $data_user_story->count() == 0 )

      <h2 class="text-xl font-semibold mt-8">Telusuri Tag Berikut</h2>
      <div class="flex flex-wrap items-center gap-2 mt-4">
        @foreach($data_random_tag as $row)
        <a href="" class="py-[6px] px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full">{{ $row->body }}</a>
        @endforeach
      </div>

      @else

      <h2 class="text-xl font-semibold mt-8">Dari {{ $data_story->user->name }}</h2>
      <div class="flex-col mt-2">

        @foreach( $data_user_story as $row )
        <div class="flex flex-col pb-4 mt-2 border-b">
          <a href="/story/{{ $row->slug }}" class="group">
            <div class="flex items-center gap-3">
              <h2 class="basis-2/3 group-hover:underline text-lg my-2 font-semibold leading-normal">{{ $row->title }}</h2>
              <span>•</span>
              <p class="basis-1/3 text-xs opacity-50">{{ ($row->updated_at)->format('M d, Y') }}</p>
            </div>
            <p class="text-sm pe-8">{!! implode(' ', array_slice(explode(' ', $row->body), 0, 16)) . (strlen($row->body) > 16 ? '...' : '') !!}</p>
          </a>

          <div class="flex items-end justify-between">
            <div class="flex items-center gap-3 mt-5">
              <div class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xs">{{ $row->readtime }}</span>
              </div>
              <span>•</span>
              <div class="flex items-center gap-1">
                <a href="/tag/{{ $row->tag->body }}" class="py-1 px-3 bg-sky-50 hover:bg-sky-100 transition rounded-full text-xs">{{ $row->tag->body }}</a>
              </div>
            </div>

            @if( $row->user_id == Auth::user()->id )
            @else
            <div class="flex items-center gap-1">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-rose-500 hover:stroke-rose-500 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hover:fill-orange-500 hover:stroke-orange-500 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
              </svg>
            </div>
            @endif

          </div>
        </div>
        @endforeach

      </div>

      @endif

    </div>
  </div>
</div>

<a href="#comment_section" class="p-2 bg-sky-50 hover:bg-sky-100 rounded-full fixed bottom-8 left-8">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 5.25l-7.5 7.5-7.5-7.5m15 6l-7.5 7.5-7.5-7.5" />
  </svg>
</a>
@endsection

@section('style')
<style>
  #detail_body>* {
    margin: 1.25rem 0;
  }

  .onEdit {
    padding: .5rem;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    border-radius: .25rem;
    margin-bottom: .25rem;
  }
</style>
@endsection

@section('script')
@endsection
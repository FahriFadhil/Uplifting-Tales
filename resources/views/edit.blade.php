@extends('layouts.app')

@section('content')
<div class="px-64 py-8">
  <form id="storyForm" action="/story/update/{{ $data_story->id }}" method="post" class="flex justify-between my-8">
    @csrf
    {{ method_field('PUT') }}
    <div class="basis-9/12 flex flex-col">
      <!-- title -->
      <input required class="outline-0 font-semibold text-4xl mb-8" autofocus type="text" placeholder="Judul" name="title" value="{{ $data_story->title }}" maxlength="100">
      <!-- <div id="editor-container" class="h-96 text-lg"></div> -->
      <!-- body -->
      <!-- <input type="hidden" id="editor-content" name="body"> -->
      <textarea name="body" id="editor-container" cols="30" class="text-lg">{{ $data_story->body }}</textarea>
      <div class="text-xs text-red-700 leading-none mt-2 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
        </svg>
        <span>
          Leaving the page or refreshing the page will make the writing progress disappear, be careful.
        </span>
      </div>
    </div>
    <div class="basis-2/12">
      <h1 class="text-2xl font-semibold">Story Desk</h1>
      <p class="mt-2 mb-6">Write a story you want to share.</p>
      <label for="tag" class="font-semibold">Add Tag</label>
      <!-- story_tag -->
      <select name="tag_id" id="tag" class="bg-sky-50 py-2 px-4 rounded-full text-sm mt-2">
        <option value="{{ $data_story->tag->id }}">{{ $data_story->tag->body }}</option>
        @foreach( $data_tag as $row )
        <option value="{{ $row->id }}">{{ $row->body }}</option>
        @endforeach
      </select>
      <div class="text-xs text-sky-700 mt-2 leading-tight inline-block">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 float-left me-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
        </svg>
        <span>
          Tags to classify your story type
        </span>
      </div>
      <!-- <button class="flex items-center gap-1 py-2 px-4 bg-sky-50 rounded-full hover:bg-sky-100">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        <span>Tag</span>
      </button> -->

      <button class="inline-block py-3 px-6 bg-sky-50 hover:bg-sky-100 rounded-full shadow flex items-center gap-2 mt-4" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
        </svg>
        <span>Update</span>
      </button>
 
    </div>
  </form>
</div>

@endsection

@section('script')

<script>
  ClassicEditor
    .create(document.querySelector('#editor-container'))
</script>

<!-- <script>
  var quill = new Quill('#editor-container', {
    theme: 'snow',
    placeholder: 'Cerita kamu…'
    // Add any additional configuration options as needed
  });

  // Listen for form submission
  document.getElementById('storyForm').addEventListener('submit', function(e) {
    // Retrieve the HTML content from the Quill editor
    var editorContent = quill.root.innerHTML;

    // Assign the content to the hidden input field
    document.getElementById('editor-content').value = editorContent;
  });
</script> -->

@endsection
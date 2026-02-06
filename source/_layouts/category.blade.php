@extends('_layouts.main')

@section('body')
    <div class="category-header">
        <span class="text-xl font-extrabold">Category</span>
        <h1 class="text-4xl font-bold">{{ $page->title }}</h1>
        <p>
            {{ $page->description }}
        </p>
    </div>

    <div class="text-2xl border-b border-primary mb-6 pb-10">
        @yield('content')
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach ($page->posts($posts) as $post)
            @include('_components.post-preview-inline')
        @endforeach
    </div>
@stop

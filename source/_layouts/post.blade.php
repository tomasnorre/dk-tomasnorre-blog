@extends('_layouts.master')

@php
    $page->addVariables(["type" => "article"]);
@endphp

@section('body')
    @if ($page->cover_image)
        <div class="relative pb-2/6">
            <figure class="mb-4 text-center">
                <img src="{{ $page->cover_image }}" alt="Cover Image: {{ $page->title }}" class="absolute h-full w-full object-cover rounded-2xl">
            </figure>
        </div>
        @if ($page->cover_credit)
            <figcaption class="text-center text-sm">{!! $page->cover_credit !!}</figcaption>
        @endif
    @endif

    <h1 class="leading-none mb-2">{{ $page->title }}</h1>

    <p class="text-gray-700 text-xl md:mt-0">{{ $page->author }}  •  <date>{{ date('F j, Y', $page->date) }}</date></p>

    @if ($page->categories)
        @foreach ($page->categories as $i => $category)
            <a
                href="{{ '/blog/categories/' . $category }}"
                title="View posts in {{ $category }}"
                class="inline-block bg-gray-300 hover:bg-blue-200 leading-loose tracking-wide text-gray-800 uppercase text-xs font-semibold rounded-2xl mr-4 px-3 pt-px"
            >{{ $category }}</a>
        @endforeach
    @endif

    <div class="border-b border-blue-200 mb-10 pb-4">
        @yield('content')
    </div>

    <div class="rounded-2xl px-3 py-3 bg-green-300 text-green-800 font-bold text-base mb-10">
        If you find any typos or incorrect information, please reach out on <a href="https://github.com/tomasnorre/dk-tomasnorre-blog">GitHub</a> so that we can have the mistake corrected.
    </div>

    <nav class="flex justify-between text-sm md:text-base">
        <div>
            @if ($next = $page->getNext())
                <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
                    &LeftArrow; {{ $next->title }}
                </a>
            @endif
        </div>

        <div>
            @if ($previous = $page->getPrevious())
                <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
                    {{ $previous->title }} &RightArrow;
                </a>
            @endif
        </div>
    </nav>
@endsection

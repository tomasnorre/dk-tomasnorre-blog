@extends('_layouts.main')

@php
    $page->addVariables(["type" => "article"]);
@endphp

@section('body')
    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="mb-8 overflow-hidden rounded-2xl shadow-md">
            <figure>
                <img src="{{ $page->cover_image }}" alt="Cover Image: {{ $page->title }}" class="w-full h-96 object-cover" />
            </figure>
        </div>
        @if ($page->cover_credit)
            <figcaption class="text-center text-sm">{!! $page->cover_credit !!}</figcaption>
        @endif

        <p class="text-xl text-gray-500 mb-2">
            <date>{{ date('F j, Y', $page->date) }}</date>
        </p>

        <h1 class="text-4xl font-bold mb-4">{{ $page->title }}</h1>

    @if ($page->categories)
        @foreach ($page->categories as $i => $category)
            <a
                href="{{ '/blog/categories/' . $category }}"
                title="View posts in {{ $category }}"
                class="inline-block bg-gray-300 hover:bg-blue-200 leading-loose tracking-wide text-gray-800 uppercase text-xs font-semibold rounded-2xl mr-4 px-3 pt-px"
            >{{ $category }}</a>
        @endforeach
    @endif

    <div class="prose prose-lg prose-img:rounded-xl prose-a:text-blue-600 prose-a:font-semibold max-w-none mb-12">
        @yield('content')
    </div>

    <div class="rounded-2xl px-3 py-3 bg-green-300 text-green-800 font-bold text-base mb-10">
        If you find any typos or incorrect information, please reach out on <a href="https://github.com/tomasnorre/dk-tomasnorre-blog">GitHub</a> so that we can have the mistake corrected.
    </div>

        <div class="bg-green-100 rounded-2xl shadow-md mb-6 overflow-hidden">
            <div class="p-6">
                <div class="flex">
                    <div class="pr-10 hidden lg:block">
                        <img src="/assets/img/7th-green-logo.svg" class="h-36" alt="7th Green logo, showing 3 elephants">
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">Hire Me?</h2>
                        <p>
                            I work as a freelancer in my company <a href="https://7th-green.com">7th Green</a>, specializing in PHP development and DevOps.
                            My main strengths include TYPO3, PHP in general, DevOps and Automation.
                        </p>
                        <p>
                            Please reach out, I will be happy to talk about your project.
                        </p>
                    </div>
                </div>

            </div>
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
    </div>
@endsection

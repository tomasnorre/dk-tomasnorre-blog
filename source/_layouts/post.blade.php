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

        <p class="text-xl text-muted mb-2">
            <date>{{ date('F j, Y', $page->date) }}</date>
        </p>

        <h1 class="text-4xl font-bold mb-4">{{ $page->title }}</h1>

    @if ($page->categories)
        @foreach ($page->categories as $i => $category)
            <a
                href="{{ '/blog/categories/' . $category }}"
                title="View posts in {{ $category }}"
                class="inline-block bg-base-300 hover:bg-secondary leading-loose tracking-wide uppercase text-xs font-semibold rounded-2xl mr-4 px-3 pt-px"
            >{{ $category }}</a>
        @endforeach
    @endif

    <div class="prose prose-lg prose-img:rounded-xl prose-a:text-primary prose-a:font-semibold max-w-none mb-12">
        @yield('content')
    </div>

    <div class="rounded-2xl px-3 py-3 bg-secondary text-base-content text-base mb-6">
        If you find any typos or incorrect information, please reach out on <a href="https://github.com/tomasnorre/dk-tomasnorre-blog">GitHub</a> so that we can have the mistake corrected.
    </div>

        @php
            $hasRelated = $page->related_posts && $page->related_posts->count() > 0;
        @endphp

        <div class="grid grid-cols-1 {{ $hasRelated ? 'lg:grid-cols-2' : '' }} gap-6 mb-6">
            {{-- Hire Me Box --}}
            <div class="bg-secondary rounded-2xl shadow-md overflow-hidden flex flex-col">
                <div class="p-6 grow">
                    <h2 class="text-xl font-bold mb-2">Want to Hire Me?</h2>
                    <div class="flex">
                        <div class="pr-10 {{ $hasRelated ? 'hidden' : 'hidden lg:block' }} ">
                            <img src="/assets/img/7th-green-logo.svg" class="h-36" alt="7th Green logo, showing 3 elephants">
                        </div>
                        <div>
                    <p class="text-md">
                        I work as a freelancer in my company <a href="https://7th-green.com" class="font-semibold">7th Green</a>.
                        My strengths include TYPO3, PHP, DevOps and Automation.
                    </p>
                    <p class="text-md mt-2">
                        Reach out, I'd be happy to talk about your project.
                    </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Articles Box --}}
            @if($hasRelated)
                <div class="bg-secondary rounded-2xl shadow-md overflow-hidden flex flex-col">
                    <div class="p-6 grow">
                        <h2 class="text-xl font-bold mb-2">Related Articles</h2>
                        <ul class="list-none m-0 p-0 space-y-3 pt-2">
                            @foreach($page->related_posts as $related)
                                <li class="text-md">
                                    <a href="{{ $related->getUrl() }}" class="block font-medium leading-tight">
                                        {{ $related->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

    <nav class="flex justify-between text-base">
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

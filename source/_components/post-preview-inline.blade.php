<div class="card bg-base-100 w-full shadow-sm">
    <figure>
        <img
                src="{{ $post->cover_image }}"
                alt="{{ $post->cover_alt }}" />
    </figure>
    <div class="card-body">
        <p class="text-sm text-base-content">
            {{ $post->getDate()->format('F j, Y') }}
        </p>
        <h2 class="">
            {{ $post->title }}
        </h2>
        <p class="text-lg line-clamp-3 mb-6 leading-relaxed">{!! $post->getExcerpt(200) !!}</p>
        <div class="card-actions justify-end">
            <a href="{{ $post->getUrl() }}" class="btn btn-primary">Read More →</a>
        </div>
    </div>
</div>

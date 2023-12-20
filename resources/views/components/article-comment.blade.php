<div class="mb-3 d-flex">
    <img class="border rounded-circle me-3 bg-light" src="" alt="Profile picture
    pengirim"
        style="width:3em; height:3em">
    <div class="card flex-grow-1 text-bg-light border-0">
        <div class="card-body">
            <div class="text-secondary mb-1">
                {{ Date::parse($comment->created_at)->locale('id')->diffForHumans() }}
            </div>
            {{ $comment->content }}
        </div>
    </div>
</div>

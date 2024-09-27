<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas-1">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title text-accent2">{{ $user->username }} - (SA) <br> <em class="fw-smaller">{{ $user->email }}</em></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            <span class="w-100">
                <a class="btn text-accent2 fw-bold" href="{{ route('sa.dashboard') }}">Tasks</a>
            </span>
        </div>
        <div class="mb-3">
            <span class="w-100">
                <a class="btn text-accent2 fw-bold" href="{{ route('sa.profile') }}">Profile</a>
            </span>
        </div>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="btn text-accent2 background-accent1 fw-bolder" type="submit">Logout</button>
        </form>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas-1">
    <div class="offcanvas-header border-bottom text-end">
        <h5 class="offcanvas-title w-100 pe-2 text-accent2">{{ $user->username }} - (SAM)</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mt-2">
        <div>
            <span class="w-100">
                <a class="btn text-accent2 fw-bold" href="{{ route('sa.manager.dashboard.ongoing') }}"
                    style="padding: 5px;color: rgb(0,0,0);font-weight: bold;">Tasks</a>
            </span>
        </div>
        <div>
            <span class="w-100">
                <a class="btn text-accent2 fw-bold" href="{{ route('report.saReport') }}"
                    style="padding: 5px;color: rgb(0,0,0);font-weight: bold;">SA Reports</a>
            </span>
        </div>
        <div class="mb-3">
            <span class="w-100">
                <a class="btn text-accent2 fw-bold" href="{{ route('report.officeReport') }}"
                    style="padding: 5px;color: rgb(0,0,0);font-weight: bold;">Office Reports</a>
            </span>
        </div>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="btn text-accent2 background-accent1 fw-bolder w-100 shadow" type="submit"
                >Logout</button>
        </form>
    </div>
</div>

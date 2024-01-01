<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar shadow">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'dashboard' ? 'active' : '' }} collapsed"
                href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'technicals.index' ? 'active' : '' }} collapsed"
                href="{{ route('technicals.index') }}">
                <i class="bi bi-award"></i>
                <span>Technical Test</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::route()->getName() == 'stories.index' ? 'active' : '' }} collapsed"
                href="{{ route('stories.index') }}">
                <i class="bi bi-book"></i>
                <span>Story Technical Test</span>
            </a>
        </li>

        @if (auth()->user()->role_id == 1)
            <li class="nav-heading">administrator</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'categories.index' ? 'active' : '' }} collapsed"
                    href="{{ route('categories.index') }}">
                    <i class="bi bi-bounding-box"></i>
                    <span>Category</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'accounts.index' ? 'active' : '' }} collapsed"
                    href="{{ route('accounts.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Account</span>
                </a>
            </li>

            <li class="nav-heading">history</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'history.technical' ? 'active' : '' }} collapsed"
                    href="{{ route('history.technical') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>History Technical Test</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'history.story' ? 'active' : '' }} collapsed"
                    href="{{ route('history.story') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>History Story Technical Test</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'history.category' ? 'active' : '' }} collapsed"
                    href="{{ route('history.category') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>History Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'history.etc' ? 'active' : '' }} collapsed"
                    href="{{ route('history.etc') }}">
                    <i class="bi bi-clock-history"></i>
                    <span>History ETC</span>
                </a>
            </li>
        @else
            <li class="nav-heading">user</li>

            <li class="nav-item">
                <a class="nav-link {{ Request::route()->getName() == 'role-management.index' ? 'active' : '' }} collapsed"
                    href="{{ route('role-management.index') }}">
                    <i class="bi bi-kanban"></i>
                    <span>Role Management</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->

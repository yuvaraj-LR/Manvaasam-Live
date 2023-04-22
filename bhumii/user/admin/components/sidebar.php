<header class="topbar" data-navbarbg="skin5" style="position:fixed;width: 100%">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand" href="<?= $baseUrl ?>" target="_blank">
                <b class="logo-icon">
                    <img src="<?= $baseUrl ?>admin/img/icon-black.png" alt="homepage" style="height: 40px;">
                </b>
                <span class="logo-text">
                    <img src="<?= $baseUrl ?>admin/img/text-black.png" alt="homepage" style="height: 30px;width: 150px;">
                </span>
            </a>
            <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
        </div>
        <ul class="navbar-nav ms-auto d-flex align-items-center px-2">
            <li>
                <a class="profile-pic" href="#">
                    <img src="<?= $baseUrl ?>admin/img/varun.png" alt="user-img" width="36" class="img-circle"><span class="text-white font-medium">
                        <?php
                        if (isset($_SESSION['fullname'])) {
                            echo $_SESSION['fullname'];
                        } else {
                            echo "Guest";
                        }
                        ?>
                    </span></a>
            </li>
        </ul>
    </nav>
</header>
<aside class="left-sidebar" style="position:fixed" data-sidebarbg="skin6">
    <div class="scroll-sidebar" style="overflow-y: auto">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12.71 2.29a1 1 0 0 0-1.42 0l-9 9a1 1 0 0 0 0 1.42A1 1 0 0 0 3 13h1v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7h1a1 1 0 0 0 1-1a1 1 0 0 0-.29-.71zM6 20v-9.59l6-6l6 6V20z" />
                        </svg>
                        <span class="hide-menu px-2">Home</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>classes" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M23 2H1a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h22a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1m-1 18h-2v-1h-5v1H2V4h20v16M10.29 9.71A1.71 1.71 0 0 1 12 8c.95 0 1.71.77 1.71 1.71c0 .95-.76 1.72-1.71 1.72s-1.71-.77-1.71-1.72m-4.58 1.58c0-.71.58-1.29 1.29-1.29a1.29 1.29 0 0 1 1.29 1.29c0 .71-.58 1.28-1.29 1.28c-.71 0-1.29-.57-1.29-1.28m10 0A1.29 1.29 0 0 1 17 10a1.29 1.29 0 0 1 1.29 1.29c0 .71-.58 1.28-1.29 1.28c-.71 0-1.29-.57-1.29-1.28M20 15.14V16H4v-.86c0-.94 1.55-1.71 3-1.71c.55 0 1.11.11 1.6.3c.75-.69 2.1-1.16 3.4-1.16c1.3 0 2.65.47 3.4 1.16c.49-.19 1.05-.3 1.6-.3c1.45 0 3 .77 3 1.71Z"/></svg>
                        <span class="hide-menu px-2">Classes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>lessons" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M352 96c0-53.02-42.98-96-96-96s-96 42.98-96 96s42.98 96 96 96s96-42.98 96-96zM233.59 241.1c-59.33-36.32-155.43-46.3-203.79-49.05C13.55 191.13 0 203.51 0 219.14v222.8c0 14.33 11.59 26.28 26.49 27.05c43.66 2.29 131.99 10.68 193.04 41.43c9.37 4.72 20.48-1.71 20.48-11.87V252.56c-.01-4.67-2.32-8.95-6.42-11.46zm248.61-49.05c-48.35 2.74-144.46 12.73-203.78 49.05c-4.1 2.51-6.41 6.96-6.41 11.63v245.79c0 10.19 11.14 16.63 20.54 11.9c61.04-30.72 149.32-39.11 192.97-41.4c14.9-.78 26.49-12.73 26.49-27.06V219.14c-.01-15.63-13.56-28.01-29.81-27.09z" />
                        </svg>
                        <span class="hide-menu px-2">Lessons</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>messages" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M21 2H6a2 2 0 0 0-2 2v3H2v2h2v2H2v2h2v2H2v2h2v3a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm-8 2.999c1.648 0 3 1.351 3 3A3.012 3.012 0 0 1 13 11c-1.647 0-3-1.353-3-3.001c0-1.649 1.353-3 3-3zM19 18H7v-.75c0-2.219 2.705-4.5 6-4.5s6 2.281 6 4.5V18z" />
                        </svg>
                        <span class="hide-menu px-2">Help center</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>notification" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 22a2 2 0 0 1-2-2h4a2 2 0 0 1-2 2Zm8-3H4v-2l2-1v-5.5c0-3.462 1.421-5.707 4-6.32V2h4v2.18c2.579.612 4 2.856 4 6.32V16l2 1v2ZM12 5.75A3.6 3.6 0 0 0 8.875 7.2A5.692 5.692 0 0 0 8 10.5V17h8v-6.5a5.693 5.693 0 0 0-.875-3.3A3.6 3.6 0 0 0 12 5.75Z" />
                        </svg>
                        <span class="hide-menu px-2">Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>users" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36">
                            <path fill="currentColor" d="M12 16.14h-.87a8.67 8.67 0 0 0-6.43 2.52l-.24.28v8.28h4.08v-4.7l.55-.62l.25-.29a11 11 0 0 1 4.71-2.86A6.59 6.59 0 0 1 12 16.14Z" class="clr-i-solid clr-i-solid-path-1" />
                            <path fill="currentColor" d="M31.34 18.63a8.67 8.67 0 0 0-6.43-2.52a10.47 10.47 0 0 0-1.09.06a6.59 6.59 0 0 1-2 2.45a10.91 10.91 0 0 1 5 3l.25.28l.54.62v4.71h3.94v-8.32Z" class="clr-i-solid clr-i-solid-path-2" />
                            <path fill="currentColor" d="M11.1 14.19h.31a6.45 6.45 0 0 1 3.11-6.29a4.09 4.09 0 1 0-3.42 6.33Z" class="clr-i-solid clr-i-solid-path-3" />
                            <path fill="currentColor" d="M24.43 13.44a6.54 6.54 0 0 1 0 .69a4.09 4.09 0 0 0 .58.05h.19A4.09 4.09 0 1 0 21.47 8a6.53 6.53 0 0 1 2.96 5.44Z" class="clr-i-solid clr-i-solid-path-4" />
                            <circle cx="17.87" cy="13.45" r="4.47" fill="currentColor" class="clr-i-solid clr-i-solid-path-5" />
                            <path fill="currentColor" d="M18.11 20.3A9.69 9.69 0 0 0 11 23l-.25.28v6.33a1.57 1.57 0 0 0 1.6 1.54h11.49a1.57 1.57 0 0 0 1.6-1.54V23.3l-.24-.3a9.58 9.58 0 0 0-7.09-2.7Z" class="clr-i-solid clr-i-solid-path-6" />
                            <path fill="none" d="M0 0h36v36H0z" />
                        </svg>
                        <span class="hide-menu px-2">Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $baseUrl ?>" aria-expanded="false" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024">
                            <path fill="currentColor" d="M574 665.4a8.03 8.03 0 0 0-11.3 0L446.5 781.6c-53.8 53.8-144.6 59.5-204 0c-59.5-59.5-53.8-150.2 0-204l116.2-116.2c3.1-3.1 3.1-8.2 0-11.3l-39.8-39.8a8.03 8.03 0 0 0-11.3 0L191.4 526.5c-84.6 84.6-84.6 221.5 0 306s221.5 84.6 306 0l116.2-116.2c3.1-3.1 3.1-8.2 0-11.3L574 665.4zm258.6-474c-84.6-84.6-221.5-84.6-306 0L410.3 307.6a8.03 8.03 0 0 0 0 11.3l39.7 39.7c3.1 3.1 8.2 3.1 11.3 0l116.2-116.2c53.8-53.8 144.6-59.5 204 0c59.5 59.5 53.8 150.2 0 204L665.3 562.6a8.03 8.03 0 0 0 0 11.3l39.8 39.8c3.1 3.1 8.2 3.1 11.3 0l116.2-116.2c84.5-84.6 84.5-221.5 0-306.1zM610.1 372.3a8.03 8.03 0 0 0-11.3 0L372.3 598.7a8.03 8.03 0 0 0 0 11.3l39.6 39.6c3.1 3.1 8.2 3.1 11.3 0l226.4-226.4c3.1-3.1 3.1-8.2 0-11.3l-39.5-39.6z" />
                        </svg>
                        <span class="hide-menu px-2">Webpage</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= $adminBaseUrl ?>logout" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                            <path fill="currentColor" d="m224.5 136.5l-42 42a12 12 0 0 1-8.5 3.5a12.2 12.2 0 0 1-8.5-3.5a12 12 0 0 1 0-17L187 140h-83a12 12 0 0 1 0-24h83l-21.5-21.5a12 12 0 0 1 17-17l42 42a12 12 0 0 1 0 17ZM104 204H52V52h52a12 12 0 0 0 0-24H48a20.1 20.1 0 0 0-20 20v160a20.1 20.1 0 0 0 20 20h56a12 12 0 0 0 0-24Z" />
                        </svg>
                        <span class="hide-menu px-2">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
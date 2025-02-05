<div class="sidebar-menu">
    <div class="dashboard_profile_wrap">
        <div class="profile_photo">
            <img src="{{ getImage(getFilePath('userProfile').'/'.auth()->user()->image,getFileSize('userProfile')) }}" alt="agent">
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="photo_upload">
                    <label for="file_upload"><i class="fa-solid fa-pen"></i></label>
                    <input id="file_upload" name="image" type="file" class="upload_file" onchange="this.form.submit()">
                </div>
            </form>
        </div>
        <h3>{{auth()->user()->fullname}}</h3>
        <p>{{auth()->user()->designation}}</p>
    </div>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item">
            <a href="{{route('user.home')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
            <span>@lang('Dashboard')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-podcast"></i></span>
            <span class="text">@lang('Podcast')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.podcast.new')}}" class="sidebar-submenu-list__link">@lang('Create Podcast')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.podcast.list')}}" class="sidebar-submenu-list__link">@lang('All Podcast') </a>
                    </li>

                </ul>
            </div>
        </li>




        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-play-circle"></i></span>
            <span class="text">@lang('Episode')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.podcast.new.episode')}}" class="sidebar-submenu-list__link">@lang('Create Episode')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.podcast.episodes.list')}}" class="sidebar-submenu-list__link">@lang('Episodes') </a>
                    </li>

                </ul>
            </div>
        </li>


        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-wallet"></i></span>
            <span class="text">@lang('Balance')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.deposit')}}" class="sidebar-submenu-list__link">@lang('Add Balance')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.deposit.history')}}" class="sidebar-submenu-list__link">@lang('Balance History') </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-money-bill"></i></span>
            <span class="text">@lang('Withdraw')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.withdraw')}}" class="sidebar-submenu-list__link">@lang('Withdraw Balance')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.withdraw.history')}}" class="sidebar-submenu-list__link">@lang('Log Withdrawal') </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="sidebar-menu-list__item">
            <a href="{{route('user.transactions')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-exchange-alt"></i></span>
            <span class="text">@lang('Transactions')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-coins"></i></span>
            <span class="text">@lang('Subscribe')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.podcast.subscription')}}" class="sidebar-submenu-list__link">@lang('Subscription')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.podcast.subscriber.list')}}" class="sidebar-submenu-list__link">@lang('Subscriber\'s List') </a>
                    </li>

                </ul>
            </div>
        </li>

        <li class="sidebar-menu-list__item">
            <a href="{{route('user.podcast.bookmarks')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-bookmark"></i></span>
            <span class="text">@lang('Bookmark')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item">
            <a href="{{route('ticket')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-id-card-alt"></i></span>
            <span class="text">@lang('Support Tickets')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item">
            <a href="{{route('ticket.open')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fas fa-ticket-alt"></i></span>
            <span class="text">@lang('New Ticket')</span>
            </a>
        </li>


        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-user"></i></span>
            <span class="text">@lang('Profile')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item {{menuActive('user.profile.setting')}}">
                        <a href="{{route('user.profile.setting')}}" class="sidebar-submenu-list__link">@lang('Profile Setting')</a>
                    </li>
                    <li class="sidebar-submenu-list__item {{menuActive('user.change.password')}}">
                        <a href="{{route('user.change.password')}}" class="sidebar-submenu-list__link">@lang('Change Password') </a>
                    </li>
                    <li class="sidebar-submenu-list__item {{menuActive('user.twofactor')}}">
                        <a href="{{route('user.twofactor')}}" class="sidebar-submenu-list__link">@lang('2Fa Security') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.logout')}}" class="sidebar-submenu-list__link">@lang('Log Out') </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>

<div class="nav_profile">
    <div class="media profile-left">
        <a class="pull-left profile-thumb" href="#">
            @if(Sentinel::getUser()->pic)
                <img src="{!! url('/').'/uploads/users/'.Sentinel::getUser()->pic !!}" alt="img"
                     class="img-circle img-bor"/>
            @else
                <img src="http://api.adorable.io/avatars/54/{!! Sentinel::getUser()->email !!}"
                     alt="img" class="img-circle img-bor"/>
            @endif
        </a>

        <div class="content-profile">
            <h4 class="media-heading">
                {{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}
            </h4>
            <ul class="icon-list">
                <li>
                    <a href="{{ URL::to('admin/users/'.Sentinel::getUser()->id) }}">
                        <i class="fa fa-fw fa-user" title="User View"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ URL::route('lockscreen',Sentinel::getUser()->id) }}">
                        <i class="fa fa-fw fa-lock" title="Lockscreen"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.edit',Sentinel::getUser()->id) }}">
                        <i class="fa fa-fw fa-gear" title="Edit User"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ URL::to('admin/logout') }}">
                        <i class="fa fa-fw fa-sign-out" title="Logout"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
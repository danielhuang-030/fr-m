<aside class="menu">
    <ul>
        <li class="person active">
            <a href="{{ url('/user') }}">Member</a>
        </li>
        <li class="person">
            <ul>
                <li> <a href="{{ url('/user/setting') }}">Member</a></li>
                <li> <a href="{{ url('/user/password') }}">Password</a></li>
                <li> <a href="{{ url('/user/addresses') }}">Address</a></li>
            </ul>
        </li>
        <li class="person">
            <ul>
                <li><a href="{{ url('user/orders') }}">Order</a></li>
            </ul>
        </li>

        <?php /*
        <li class="person">
            <a href="#">我的小窝</a>
            <ul>
                <li> <a href="{{ url('/user/likes') }}">收藏</a></li>
                <li> <a href="foot.html">足迹</a></li>
                <li> <a href="comment.html">评价</a></li>
                <li> <a href="news.html">消息</a></li>
            </ul>
        </li>
        */ ?>
    </ul>

</aside>
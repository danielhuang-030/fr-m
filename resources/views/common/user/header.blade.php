<header>
    <article>
        <div class="mt-logo">
            <!--顶部导航条 -->
            <div class="am-container header">
                <ul class="message-r">
                    <div class="topMessage home">
                        <div class="menu-hd"><a href="{{ url('/') }}" target="_top" class="h">Home</a></div>
                    </div>
                    <div class="topMessage my-shangcheng">
                        <div class="menu-hd MyShangcheng"><a href="{{ url('/user') }}" target="_top"><i class="am-icon-user am-icon-fw"></i>Member</a></div>
                    </div>
                    <div class="topMessage mini-cart">
                        <div class="menu-hd"><a id="mc-menu-hd" href="{{ url('/home/cars') }}" target="_top"><i class="am-icon-shopping-cart  am-icon-fw"></i><span>Cart</span><strong id="J_MiniCartNum" class="h">0</strong></a></div>
                    </div>
                    <?php /*
                    <div class="topMessage favorite">
                        <div class="menu-hd"><a href="{{ url('/user/likes') }}" target="_top"><i class="am-icon-heart am-icon-fw"></i><span>Collection</span></a></div>
                    </div>
                    */ ?>
                </ul>
            </div>
        </div>
    </article>
</header>

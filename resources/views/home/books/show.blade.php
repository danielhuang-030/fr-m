@extends('layouts.shop')

@section('main')
    <div class="listMain">
        @inject('bookPresenter', 'App\Presenters\BookPresenter')
        <!--放大镜-->

        <div class="item-inform">
            <div class="clearfixLeft" id="clearcontent">

                <div class="box">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $(".jqzoom").imagezoom();
                            $("#thumblist li a").click(function() {
                                $(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
                                $("#jqzoom").attr('src', $(this).find("img").attr("src"));
                            });
                        });
                    </script>

                    <div class="tb-booth tb-pic tb-s310">
                        @inject('bookPresenter', 'App\Presenters\BookPresenter')
                        <img src="{{ $bookPresenter->getCover($book) }}" alt="{{ $book->name }}" id="jqzoom" />
                    </div>
                    <ul class="tb-thumb" id="thumblist">
                        @foreach ($bookPresenter->getImageLinks($book) as $key => $image)
                            <li class="{{ $key == 0 ? 'tb-selected' : '' }}">
                                <div class="tb-pic tb-s40">
                                    <a href="javascript: void(); ">
                                        <img src="{{ $image }}">
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clearfixRight">

                <!--规格属性-->
                <!--名称-->
                <div class="tb-detail-hd">
                    <h1>
                        {{ $book->title }}
                    </h1>
                </div>
                <div class="tb-detail-list">
                    <!--价格-->
                    <div class="tb-detail-price">
                        <li class="price iteminfo_price">
                            <dt>Price</dt>
                            <dd><b class="sys_item_price">{{ $book->conditions->first()->price }}</b>  </dd>
                        </li>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>

                    <!--各种规格-->
                    <dl class="iteminfo_parameter sys_item_specpara">
                        <dt class="theme-login"></dt>
                        <dd>
                        @foreach ($authors as $author)
                        {{ $author->name }}
                        @endforeach
                        </dd>

                        <dt class="theme-login"><div class="cart-title">Condition<span class="am-icon-angle-right"></span></div></dt>
                        <dd>
                            <!--操作页面-->

                            <div class="theme-popover-mask"></div>

                            <div class="theme-popover">
                                <div class="theme-span"></div>
                                <div class="theme-poptit">
                                    <a href="javascript:;" title="关闭" class="close">×</a>
                                </div>
                                <div class="theme-popbod dform">
                                    <form class="theme-signin" name="" action="" method="post">

                                        <div class="theme-signin-left">
                                            @foreach ($book->conditions as $condition)
                                                <div class="theme-options">
                                                    <div class="cart-title">Condition</div>
                                                    <ul>
                                                      <li title="{{ $condition->condition }}" class="sku-line">{{ $condition->condition }}<i></i></li>
                                                      <?php /*
                                                        @foreach ($attrs as $key => $attr)
                                                            <li title="价格浮动 {{ $attr['markup'] }}" class="sku-line {{ $key == 0 ? 'selected' : '' }}">{{ $attr['items'] }}<i></i></li>
                                                        @endforeach
                                                      */ ?>
                                                    </ul>
                                                </div>
                                            @endforeach
                                            <div class="theme-options">
                                                <div class="cart-title number">Quantity</div>
                                                <dd>
                                                    <input id="min" class="am-btn am-btn-default" type="button" value="-" />
                                                    <input id="text_box" name="numbers" type="text" value="1" style="width:30px;" />
                                                    <input id="add" class="am-btn am-btn-default"  type="button" value="+" />
                                                    <span id="Stock" class="tb-hidden">stock <span class="stock">{{ $book->conditions->first()->quantity }}</span></span>
                                                </dd>
                                            </div>
                                    <div class="clear"></div>
                                </div>
            </form>
        </div>
    </div>

    </dd>
    </dl>
    <div class="clear"></div>
    <!--活动	-->

    </div>

    <div class="pay">
        <?php /*
        <div class="pay-opt">
            <a href="{{ url('/') }}"><span class="am-icon-home am-icon-fw">首页</span></a>
            @auth
            @if ($book->users()->where('user_id', \Auth::user()->id)->count() > 0)
                <a href="javascript:;" style="display: none" id="likes_btn"><span class="am-icon-heart am-icon-fw" >收藏</span></a>
                <a href="javascript:;"  id="de_likes_btn"><span class="am-icon-heart am-icon-fw">取消收藏</span></a>
            @else
                <a href="javascript:;"  id="likes_btn"><span class="am-icon-heart am-icon-fw">收藏</span></a>
                <a href="javascript:;" style="display: none" id="de_likes_btn"><span class="am-icon-heart am-icon-fw" >取消收藏</span></a>
            @endif
            @endauth

            @guest
            <a href="javascript:;"  id="likes_btn"><span class="am-icon-heart am-icon-fw">收藏</span></a>
            @endguest

        </div>
        <li>
            <div class="clearfix tb-btn" id="nowBug">
                @auth
                <a href="javascript:;" >BUY NOW</a>
                @endauth
                @guest
                <a href="{{ url('login') }}?redirect_url={{ url()->current() }}">BUY NOW</a>
                @endguest
            </div>
        </li>
        */ ?>
        <li>
            <div class="clearfix tb-btn tb-btn-basket">
                <a title="ADD CART" href="javascript:;"  class="add-cart"><i></i>ADD CART</a>
            </div>
        </li>
    </div>
    <input type="hidden" name="book_id" value="{{ $book->id }}">
    <input type="hidden" name="condition_id" value="{{ $book->conditions->first()->id }}">

    </div>

    <div class="clear"></div>

    </div>

    <!-- introduce-->
    <div class="introduce">
        <div class="introduceMain">
            <div class="am-tabs" data-am-tabs>
                <ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">
                    <li class="am-active">
                        <a href="#"><span class="index-needs-dt-txt">DETAIL</span></a>
                    </li>
                </ul>

                <div class="am-tabs-bd">
                    <div class="am-tab-panel am-fade am-in am-active">
                        <div class="details">
                            <div class="attr-list-hd after-market-hd">
                                <h4>DETAIL</h4>
                            </div>
                            <div class="twlistNews">
                                {{ $book->description }}
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>

            <div class="clear"></div>

            <div class="footer">
                <div class="footer-hd">
                    <p>
                        <a href="{{ url('/') }}">Home</a>
                    </p>
                </div>
                @include('common.home.footer')
            </div>
        </div>

    </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('script')
<script type="text/javascript">
$(function() {
  // csrf-token
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // add cart
  $(".add-cart").on("click", function() {
    console.log('add cart', $("input[name=book_id]").val(), $("input[name=numbers]").val());

    $.post("/fr-m/cart", {
      id: $("input[name=condition_id]").val(),
      qty: $("input[name=numbers]").val(),
    }).done(function(json) {
      console.log(json);
      alert(json.message);
    });

    return false;
  });

});
</script>
@endsection
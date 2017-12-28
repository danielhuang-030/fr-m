@extends('layouts.home')

@section('main')
    <main id="mainContent" class="main-content">
    <div class="page-container ptb-10">
        <div class="container">
            <div class="section deals-header-area ptb-30">
                <div class="row row-tb-20">
                    <div class="col-xs-12 col-md-4 col-lg-3">
                        <aside>
                            <ul class="nav-coupon-category panel">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href='{{ url("/category/{$category->slug}") }}'>
                                            <i class="fa fa-product-hunt"></i>{{ $category->name }}
                                            <span>{{ $category->books()->count() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="all-cat">
                                    <a class="font-14" href="{{ url('/categories/tree') }}">See all categories</a>
                                </li>
                            </ul>
                        </aside>
                    </div>

                    <div class="col-xs-12 col-md-8 col-lg-9">
                        <div class="header-deals-slider owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">

                            @inject('bookPresenter', 'App\Presenters\BookPresenter')
                            @foreach ($hotProducts as $hotProduct)
                                <div class="deal-single panel item {{ $hotProduct->isbn13 }}}">
                                    <a href="{{ $bookPresenter->getLink($hotProduct) }}">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $bookPresenter->getCover($hotProduct) }}">
                                            <div class="label-discount top-10 right-10" style="width: auto;">
                                                {{ $bookPresenter->getPrice($hotProduct) }}
                                            </div>
                                        </figure>
                                    </a>
                                    <?php /*
                                    <div class="deal-about p-20 pos-a bottom-0 left-0">
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating">{{ $hotProduct->users->count() }}</span>
                                        </div>
                                        <h3 class="deal-title mb-10 ">
                                                {{ $hotProduct->name }}
                                        </h3>
                                    </div>
                                    */ ?>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <section class="section latest-deals-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">Latest Books</h3>
                    <a href="{{ url('/book') }}" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">Check all</a>
                </header>

                <div class="row row-masnory row-tb-20">
                    @foreach ($latestProducts as $latestProduct)
                        <div class="col-sm-6 col-lg-4">
                            <div class="deal-single panel">
                                <a href="{{ $bookPresenter->getLink($latestProduct) }}">
                                    <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $bookPresenter->getCover($latestProduct) }}">

                                    </figure>
                                </a>
                                <div class="bg-white pt-20 pl-20 pr-15">
                                    <div class="pr-md-10">
                                        <?php /*
                                        <div class="mb-10">
                                            收藏人数 <span class="rating-count rating">{{ $latestProduct->users->count() }}</span>
                                        </div>
                                        */ ?>
                                        <h3 class="deal-title mb-10">
                                            <a href="{{ $bookPresenter->getLink($latestProduct) }}">
                                                {{ $latestProduct->title }}
                                            </a>
                                        </h3>
                                        <p class="text-muted mb-20 text-right">
                                            @foreach ($latestProduct->authors as $author)
                                            <a href="{{ route('author', ['slug' => $author->slug]) }}">
                                                {{ $author->name }}
                                            </a>&nbsp;
                                            @endforeach
                                            <?php /*{!! mb_substr($latestProduct->description, 0, 40) !!}...*/ ?>
                                        </p>
                                    </div>
                                    <div class="deal-price pos-r mb-15">
                                        <h3 class="price ptb-5 text-right">
                                            <span class="price-sale" style="text-decoration: none; ">
                                                {{ $bookPresenter->getPrice($latestProduct) }}
                                            </span>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>


    </main>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/lib/lazyload/lazyload.js') }}"></script>
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script>

    </script>
@endsection
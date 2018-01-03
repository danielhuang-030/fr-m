@extends('layouts.user')

@section('style')
    <link href="{{ asset('assets/user/css/orstyle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main')
	<div class="main-wrap">

		<div class="user-orderinfo">

			<!--标题 -->
			<div class="am-cf am-padding">
				<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">Order&nbsp;details</strong></div>
			</div>
			<hr/>
			<!--进度条-->
			<div class="m-progress">
				<div class="m-progress-list">
								<span class="step-1 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">1<em class="bg"></em></i>
                                   <p class="stage-name">Place Order</p>
                                </span>
					<span class="step-2 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">2<em class="bg"></em></i>
                                   <p class="stage-name">Shipping</p>
                                </span>
					<span class="step-3 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">3<em class="bg"></em></i>
                                   <p class="stage-name">Delivered</p>
                                </span>
					<span class="step-4 step">
                                   <em class="u-progress-stage-bg"></em>
                                   <i class="u-stage-icon-inner">4<em class="bg"></em></i>
                                   <p class="stage-name">Completed</p>
                                </span>
					<span class="u-progress-placeholder"></span>
				</div>
				<div class="u-progress-bar total-steps-2">
					<div class="u-progress-bar-inner"></div>
				</div>
			</div>

			@inject('userPresenter', 'App\Presenters\UserPresenter')
			<div class="order-infoaside">
              <div class="order-logistics" style="width: 20%; ">
						<div class="icon-log">
							<i><img src="{{ $userPresenter->getAvatarLink($order->user->avatar) }}"></i>
						</div>
						<div class="latest-logistics">
							<p class="text">order ID: {{ $order->id }}</p>
							<div class="time-list">
								<span class="date">{{ $order->created_at }}</span>
							</div>
						</div>
						<span class="am-icon-angle-right icon"></span>
					<div class="clear"></div>
				</div>
				<div class="order-addresslist">
					<div class="order-address">
						<p class="new-tit new-p-re">
							<span class="new-txt">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</span>
							<span class="new-txt-rd2">{{ $order->shipping_phone }}</span>
						</p>
						<div class="new-mu_l2a new-p-re">
							<p class="new-mu_l2cw">
								<span class="title"></span>
								<span class="province">{{ $order->shippingState->name }}</span>
								<span class="city">{{ $order->shipping_city }}</span>
								<span class="dist">{{ $order->shipping_addr1 }}</span>
								<span class="street">{{ $order->shipping_addr2 }}</span></p>
						</div>
					</div>
                </div>

                <div class="order-addresslist">
                    <div class="order-address">
						<p class="new-tit new-p-re">
							<span class="new-txt">{{ $order->billing_first_name }} {{ $order->billing_last_name }}</span>
						</p>
						<div class="new-mu_l2a new-p-re">
							<p class="new-mu_l2cw">
								<span class="title"></span>
								<span class="province">{{ $order->billingState->name }}</span>
								<span class="city">{{ $order->billing_city }}</span>
								<span class="dist">{{ $order->billing_addr1 }}</span>
								<span class="street">{{ $order->billing_addr2 }}</span></p>
						</div>
					</div>

				</div>
			</div>
			<div class="order-infomain">

				<div class="order-top">
					<div class="th th-item">
						<td class="td-inner">Book</td>
					</div>
					<div class="th th-price">
						<td class="td-inner">Price</td>
					</div>
					<div class="th th-number">
						<td class="td-inner">Quantity</td>
					</div>
					<div class="th th-operation">
						<td class="td-inner">Status</td>
					</div>
					<div class="th th-amount">
						<td class="td-inner">Total</td>
					</div>
				</div>

				<div class="order-main">

					<div class="order-status3">
						<div class="order-content">

							<div class="order-left">
                                @inject('bookPresenter', 'App\Presenters\BookPresenter')
                                @foreach ($order->details as $orderDetail)
                                    <ul class="item-list">
                                        <li class="td td-item">
                                            <div class="item-pic">
                                              <a href="{{ $bookPresenter->getLink($orderDetail->book) }}" class="J_MakePoint" target="_blank">
                                                    <img src="{{ $bookPresenter->getCover($orderDetail->book) }}" class="itempic J_ItemImg">
                                                </a>
                                            </div>
                                            <div class="item-info">
                                                <div class="item-basic-info">
                                                    <a href="{{ $bookPresenter->getLink($orderDetail->book) }}" target="_blank">
                                                        <p>{!! $orderDetail->title !!}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="td td-price">
                                            <div class="item-price">
                                                {{ $orderDetail->price }}
                                            </div>
                                        </li>
                                        <li class="td td-number">
                                            <div class="item-number">
                                                <span>×</span>{{ $orderDetail->quantity }}
                                            </div>
                                        </li>
                                        <li class="td td-operation">
                                            <div class="item-operation">{{ $orderDetail->status }}</div>
                                        </li>
                                    </ul>
                                @endforeach
							</div>

                            <div class="order-left">
                                @foreach ($order->fees as $orderFee)
                                    <ul class="item-list">
                                        <li class="td td-item">
                                            <div>{{ $orderFee->name }}</div>
                                        </li>
                                        <li class="td td-price">
                                            <div class="item-price">
                                                {{ $orderFee->total }}
                                            </div>
                                        </li>
                                        <li class="td td-number">
                                            <div class="item-number">-</div>
                                        </li>
                                        <li class="td td-operation">
                                            <div class="item-operation">-</div>
                                        </li>
                                    </ul>
                                @endforeach
							</div>


							<div class="order-right">
								<li class="td td-amount">
									<div class="item-amount">
										Total：{{ $order->total }}
									</div>
								</li>
							</div>

						</div>

					</div>
				</div>

			</div>
		</div>

	</div>
@endsection
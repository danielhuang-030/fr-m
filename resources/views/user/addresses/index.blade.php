@extends('layouts.user')

@section('style')
    <link href="{{ asset('assets/user/css/addstyle.css') }}" rel="stylesheet" type="text/css">
    <style>
        .am-selected-list {
            height: 120px;
            overflow-y: scroll;
        }
    </style>
    <script src="{{ asset('assets/user/AmazeUI-2.4.2/assets/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/user/AmazeUI-2.4.2/assets/js/amazeui.js') }}"></script>
@endsection

@section('main')
	<div class="main-wrap">

		<div class="user-address">
			<!--标题 -->
			<div class="am-cf am-padding">
				<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">Address&nbsp;list</strong></div>
			</div>
			<hr/>
			<ul class="am-avg-sm-1 am-avg-md-3 am-thumbnails">
            @inject("addressPersenter", 'App\Presenters\AddressPresenter')
                @foreach ($addresses as $address)
                    <li class="user-addresslist {{ $address->is_default ? 'defaultAddr' : '' }}">
                        <p class="new-tit new-p-re">
                            <span class="new-txt">{{ $address->first_name }} {{ $address->last_name }}</span>
                            <span class="new-txt-rd2">{{ $address->phone }}</span>
                        </p>
                        <div class="new-mu_l2a new-p-re">
                            <p class="new-mu_l2cw">
                                <span class="title">address</span><br />
                                <span class="zipcode">{{ $address->zipcode }}</span>
                                <span class="street">{{ $address->addr2 }}</span>, <span class="street">{{ $address->addr1 }}</span>
                                <br>
                                <span class="city">{{ $address->city }}</span>, <span class="state">{{ $addressPersenter->getStateName($address) }}</span>
                            </p>
                        </div>
                        <div class="new-addr-btn">
                            <a href="{{ url("/user/addresses/{$address->id}/edit") }}"><i class="am-icon-edit"></i>Edit</a>
                            <span class="new-addr-bar">|</span>
                            <a href="javascript:;" data-id="{{ $address->id }}" class="delete_address">
                                <i class="am-icon-trash"></i>Delete
                            </a>
                        </div>
                    </li>
                @endforeach


			</ul>
			<div class="clear"></div>

            @if ($addresses->isEmpty())
			<a class="new-abtn-type" data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}">Add</a>
			<!--例子-->


                {{ csrf_field() }}
                <div class="am-modal am-modal-no-btn" id="doc-modal-1">

                    <div class="add-dress">

                        <!--标题 -->
                        <div class="am-cf am-padding">
                            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">Add&nbsp;address</strong></div>
                        </div>
                        <hr/>


                        @if (session()->has('status'))
                            <div class="am-alert am-alert-success" data-am-alert>
                                <button type="button" class="am-close">&times;</button>
                                <p>{{ session('status') }}</p>
                            </div>
                        @endif

                        @if ($errors->count())
                            <div class="am-alert am-alert-danger" data-am-alert>
                                <button type="button" class="am-close">&times;</button>
                                <p>{{ $errors->first() }}</p>
                            </div>
                        @endif


                        <div class="am-u-md-12 am-u-lg-8" style="margin-top: 20px;">
                            <form class="am-form am-form-horizontal" action="{{ url('/user/addresses') }}" method="post">
                                {{ csrf_field() }}

                                <div class="am-form-group">
                                    <label for="first_name" class="am-form-label">First Name</label>
                                    <div class="am-form-content">
                                        <input type="text" id="first_name" name="first_name" value="{{ old("first_name") }}" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="last_name" class="am-form-label">Last Name</label>
                                    <div class="am-form-content">
                                        <input type="text" id="last_name" name="last_name" value="{{ old("last_name") }}" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="phone" class="am-form-label">Phone</label>
                                    <div class="am-form-content">
                                        <input id="phone" name="phone" value="{{ old("phone") }}" placeholder="Phone" type="text" maxlength="11">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="zipcode" class="am-form-label">Zipcode</label>
                                    <div class="am-form-content">
                                        <input id="zipcode" name="zipcode" value="{{ old("zipcode") }}" placeholder="Zipcode" type="text" maxlength="11">
                                    </div>
                                </div>
                                <input name="country" type="hidden" value="US">
                                <div class="am-form-group">
                                    <label for="state_id" class="am-form-label">States</label>
                                    <div class="am-form-content">
                                        <select id="state_id" name="state_id">
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="city" class="am-form-label">City</label>
                                    <div class="am-form-content">
                                         <input id="city" name="city" value="{{ old("city") }}" placeholder="City" type="text">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="addr1" class="am-form-label">Address 1</label>
                                    <div class="am-form-content">
                                         <input id="addr1" name="addr1" value="{{ old('addr1') }}" placeholder="Address 1" type="text">
                                    </div>
                                    <?php /*
                                    <div class="am-form-content">
                                        <textarea id="addr" name="addr" rows="3" id="user-intro" placeholder="Addr">{{ $address->addr1 }}</textarea>
                                        <small></small>
                                    </div>
                                    */ ?>
                                </div>
                                <div class="am-form-group">
                                    <label for="addr2" class="am-form-label">Address 2</label>
                                    <div class="am-form-content">
                                         <input id="addr2" name="addr2" value="{{ old('addr2') }}" placeholder="Address 2" type="text">
                                    </div>
                                </div>

                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button class="am-btn am-btn-danger">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
                @endif
		</div>


		<script type="text/javascript">
            $(document).ready(function() {
                $(".new-option-r").click(function() {
                    $(this).parent('.user-addresslist').addClass("defaultAddr").siblings().removeClass("defaultAddr");
                });

                var $ww = $(window).width();
                if($ww>640) {
                    $("#doc-modal-1").removeClass("am-modal am-modal-no-btn")
                }

            })
		</script>

		<div class="clear"></div>
{{ method_field('PUT') }}
	</div>
@endsection

@section('script')
    <script src="{{ asset('assets/user/layer/2.4/layer.js') }}"></script>
    <script>
        $('.delete_address').click(function(){
            var id = $(this).data('id');
            var _url = "{{ url('/user/addresses') }}/" + id;
            var that = $(this);

            $.post(_url, {_token:'{{ csrf_token() }}', _method:'DELETE'}, function(res){
                if (res.code == 0) {
                    that.parent().parent().remove();
                }

                layer.msg(res.msg);
            });
        });
    </script>
    <script>
        $('.default_addr').click(function(){
            var id = $(this).data('id');
            var _url = "{{ url('/user/addresses/default') }}/" + id;

            $.post(_url, {_token:'{{ csrf_token() }}'}, function(res){
                if (res.code == 0) {

                }


                layer.msg(res.msg);
                location.reload();
            });
        });

        $('select[name=province]').change(function () {
            var id = $(this).val();
            var url = "{{ url('user/addresses/cities') }}/" + id;

            $.get(url, function(res){


                var text = '';
                for (var i in res) {

                    text += '<option value="'+ res[i].id +'">'+ res[i].name +'</option>';
                }

                $('select[name=city]').html(text);
            });
        });
    </script>
@endsection
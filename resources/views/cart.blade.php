@extends('layouts.app')
@section('title', 'Giỏ hàng')
@section('content')
<link href="{{ asset('css/product_detail.css') }}" rel="stylesheet">
<link href="{{ asset('css/cart.css') }}" rel="stylesheet">
@php
function sizeContent($size)
{
    $str = '';
    switch ($size) {
        case 'small':
            $str = 'Small';
            break;
        case 'medium':
            $str = 'Meidum (+3.000đ)';
            break;
        case 'big':
            $str = 'Large (+6.000đ)';
            break;
        default:
            break;
    }
    return $str;
}

function total($iems)
{
    $total = 0;
    foreach ($iems as $item) {
        $total += $item->extend_price * $item->quantity;
    }
    return $total;
}

@endphp
<div class="cart-page">
    <div class="cart-page__header">
        <h3>Giỏ hàng của bạn</h3>
    </div>

    <div class="cart-page__body">
        <div class="container">
            <div class="row gx-5">
                <div class="col-md-12 col-lg-8">
                    <div class="cart-page__content">
                        <div class="cart-page__content__header">
                            <div>Các món đã chọn</div>
                            <a class="more-item-button" href="/menu">
                                <h6>Thêm món</h6>
                            </a>
                        </div>
                        <div class="cart-page-divider"></div>
                        <div class="cart-page__content__body">
                            @if (count($items) == 0)
                            <div class="cart-page-item">
                                <div class="container">
                                    <h4>Giỏ hàng đang trống !</h4>
                                </div>
                            </div>
                            @else
                            @foreach ($items as $item)
                            <div class="cart-page-item">
                                <div id="update-form">
                                    <div class="container">
                                        <div class="row gy-2">
                                            <div class="col-lg-1 col-md-1 col-sm-2 col-4">
                                                <img class="cart-page__item-edit" src="{{ url('/images/pencil-fill.svg') }}" onclick="openForm()" id="{{$item->id}}"/>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                                                <img class="cart-page__item-image" src="{{ $item->image_url }}" />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-8 col-8">
                                                <h6>{{ $item->name }}</h6>
                                                <div>Số lượng: {{ $item->quantity }}</div>
                                                <div>Giá đơn vị: {{ number_format($item->price, 0, ',', '.') }}đ</div>
                                                <div>Size: {{ sizeContent($item->size) }}</div>
                                            </div>
                                        </div>
                                        <div class="form-popup" id="form-popup-{{$item->id}}">
                                            <form accept-charset="utf-8" method="POST" action="{{ route('cart.edit') }}" class="form-container">
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="button" class="btn-close" aria-label="Close" onclick="closeForm()" id="{{$item->id}}"></button>
                                                <div class="row gy-2 information">
                                                    <div class="col-lg-2 col-md-2 col-sm-4 col-4">
                                                        <img class="cart-page__item-image" src="{{ $item->image_url }}" />
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-8 col-8 item_information pt-4">
                                                        <h6>{{ $item->name }}</h6>
                                                        <div>
                                                            Giá đơn vị: {{ number_format($item->price, 0, ',', '.') }}đ
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-detail-footer">
                                                    <div class="product-detail-footer-quantity">
                                                        <button type="button" class="item-button-disabled increasebtn" onclick="decreaseQuantity()" id="decrease-quantity-button-{{$item->id}}">
                                                            <img class="item-button-image"
                                                                src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMiIgdmlld0JveD0iMCAwIDE2IDIiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNiIgaGVpZ2h0PSIyIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K"
                                                                alt=""/>
                                                        </button>
                                                        <input type="text" name="quantity" class="form-control quantity-input"
                                                            id="product-quantity-{{$item->id}}" value="{{ $item->quantity }}">
                                                        <button type="button" id="increase-quantity-button-{{$item->id}}" class="decreasebtn" onclick="increaseQuantity()">
                                                            <img class="item-button-image"
                                                                src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTYuODU3MTQgNi44NTcxNFYwSDkuMTQyODZWNi44NTcxNEgxNlY5LjE0Mjg2SDkuMTQyODZWMTZINi44NTcxNFY5LjE0Mjg2SDBWNi44NTcxNEg2Ljg1NzE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cg=="
                                                                alt="" />
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="product-detail-size">
                                                    <div class="product-detail-size-header">
                                                        Chọn size (bắt buộc)
                                                    </div>

                                                    <div class="product-detail-size-body">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="size"
                                                                id="exampleRadios2" value="small" checked>
                                                            <div class="form-check-label" for="size">
                                                                Nhỏ +
                                                            </div>
                                                            <div class="form-check-label" for="size">
                                                                0đ
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="size"
                                                                id="exampleRadios2" value="medium" checked>
                                                            <div class="form-check-label" for="size">
                                                                Vừa +
                                                            </div>
                                                            <div class="form-check-label" for="size">
                                                                3.000đ
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="size"
                                                                id="exampleRadios3" value="big">
                                                            <div class="form-check-label" for="size">
                                                                Lớn +
                                                            </div>
                                                            <div class="form-check-label" for="size">
                                                                6.000đ
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <label for="email"><b>Note</b></label>
                                                    <input name="note" type="text" id="cart-page__note" class="form-control"
                                                           placeholder="Ghi chú cho sản phẩm này" aria-label="note" aria-describedby="basic-addon1"
                                                           value="{{ ($item->note) }}">
                                                    <button type="submit" class="btn checkout-button" name="form2">
                                                        Thay đổi giỏ hàng
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="delete-form" class="col-lg-1 col-md-1 col-sm-4 col-4 pt-5">
                                    <form action="{{ route("cart.remove") }}" method="POST">
                                        <input class="btn btn-default" type="image"
                                            src="{{ url('/images/delete.svg') }}" value="delete" />
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                    </form>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <div class="cart-page__content__header">
                            <div>Tổng cộng</div>
                        </div>
                        <div class="cart-page-divider"></div>
                        <div class="cart-page__content__total">
                            <div>
                                <h6>Tạm tính</h6>
                            </div>
                            <div>
                                <h6>{{ number_format(total($items), 0, ',', '.') }}đ</h6>
                            </div>
                        </div>

                        <div class="cart-page__content__footer">
                            <div>
                                <div>
                                    <h6>Thành tiền</h6>
                                </div>
                                <div class="cart-page-total">
                                    <h6>{{ number_format(total($items), 0, ',', '.') }}đ</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <form accept-charset="utf-8" action="{{ route('cart.order') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="cart-page__info">
                            <div class="cart-page__content__header">
                                <div>Địa chỉ giao hàng</div>
                            </div>
                            <div class="cart-page-divider"></div>
                            <div class="cart-page__content__header">
                                <input name="delivery_address" type="text" class="form-control" id="delivery-address"
                                    placeholder="Nhập đỉa chỉ nhận hàng" value="{{ Auth::user()->address }}">
                            </div>
                            <div class="cart-page__content__header">
                                <div>Thông tin người nhận</div>
                            </div>
                            <div class="cart-page-divider"></div>
                            <div class="cart-page__content__header">
                                <input name="delivery_name" type="text" class="form-control" id="delivery-address"
                                    placeholder="Tên người nhận" value="{{ Auth::user()->name}}">
                            </div>
                            <div class="cart-page__content__header">
                                <input name="delivery_phone" type="text" class="form-control" id="delivery-address"
                                    placeholder="Số điện thoại" value="{{ Auth::user()->phone_number }}">
                            </div>
                            <div class="cart-page__content__header">
                                <div>Ghi chú</div>
                            </div>
                            <div class="cart-page-divider"></div>
                            <div class="cart-page__content__header">
                                <input name="delivery_note" type="text" class="form-control" id="delivery-note"
                                    placeholder="Ghi chú cho đơn hàng này" value="">
                            </div>
                            <div class="cart-page__content__header">
                                <div>Phương thức thanh toán</div>
                            </div>
                            <div class="cart-page-divider"></div>

                            <div class="cart-page__content__header__checkbox">
                                <input value="cash" class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    <img class="image-payment" src="{{ url('/images/payment/cash.jpeg') }}">
                                    Thanh toán khi nhận hàng (tiền mặt)
                                </label>
                            </div>
                            <div class="cart-page__content__header__checkbox">
                                <input value="momo-pay" class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    <img class="image-payment" src="{{ url('/images/payment/momo.png') }}">
                                    Momo
                                </label>
                            </div>
                            <div class="cart-page__content__header__checkbox">
                                <input value="zalo-pay" class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    <img class="image-payment" src="{{ url('/images/payment/zalo.png') }}">
                                    ZaloPay
                                </label>
                            </div>
                            <div class="cart-page__content__header__checkbox">
                                <input value="shopee-pay" class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    <img class="image-payment" src="{{ url('/images/payment/shopee.png') }}">
                                    ShopeePay
                                </label>
                            </div>
                            <div class="cart-page__content__header__checkbox">
                                <input value="credit" class="form-check-input" type="radio" name="payment_method"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    <img class="image-payment" src="{{ url('/images/payment/card.png') }}">
                                    Thẻ ngân hàng
                                </label>
                            </div>
                            <div>
                                @if(count($items) == 0)
                                    {{''}}
                                @else
                                <button type="submit" class="checkout-button">
                                    <h6>Đặt hàng</h6>
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="messageToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ url('/images/logo/logo-2.png') }}" width="30px" class="rounded me-2" alt="logo-2">
                <strong class="me-auto">Buy me store</strong>
                <small>Bây giờ</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session('message') }}
            </div>
        </div>
    </div>
</div>

@if (\Session::get('message'))
<script>
    const messageToast = document.getElementById('messageToast')
    const toast = new bootstrap.Toast(messageToast)
    toast.show()
</script>
@endif

<script>
    function openForm() {
        document.getElementById("form-popup-".concat(event.target.id)).style.display = 'block';
    }

    function closeForm() {
        console.log("form-popup-".concat(event.target.id));
        document.getElementById("form-popup-".concat(event.target.id)).style.display = 'none';
    }

    function increaseQuantity() {
        var id = event.target.id.match(/\d+/);
        console.log("product-quantity-".concat(id));
        var currentQuantity = parseInt(document.getElementById("product-quantity-".concat(id)).value, 10);
        if(currentQuantity == 1 ){

            document.getElementById("decrease-quantity-button-".concat(id)).disabled = false;
            document.getElementById("decrease-quantity-button-".concat(id)).classList.remove("item-button-disabled-".concat(id));
        }
        document.getElementById("product-quantity-".concat(id)).value = currentQuantity + 1;
    }

    function decreaseQuantity() {
        var id = event.target.id.match(/\d+/);
        console.log("product-quantity".concat(id));
        var currentQuantity = parseInt(document.getElementById("product-quantity-".concat(id)).value, 10);
        if(currentQuantity == 2 ){
        document.getElementById("decrease-quantity-button-".concat(id)).disabled = true;
        document.getElementById("decrease-quantity-button-".concat(id)).classList.add("item-button-disabled".concat(id));
        }
        document.getElementById("product-quantity-".concat(id)).value = currentQuantity - 1;
    };
</script>
@endsection

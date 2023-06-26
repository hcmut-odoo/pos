@extends('layouts.app')

@section('content')
<link href="{{ asset('css/product_detail.css') }}" rel="stylesheet">
<div class="page-container">
    <form accept-charset="utf-8" method="POST" action="">
        <div class="product-detail">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-md-12 col-lg-6">
                        <div class="main-image">
                            <img src=" {{ $product->image_url }} " alt="image-1" />
                        </div>
                        <div class="image-list">
                            <img class="image-option" src=" {{ $product->image_url }} " alt="image-1"
                                onclick="" />
                            <img class="image-option"
                                src="https://minio.thecoffeehouse.com/image/admin/Bottle_oolong_285082.jpg"
                                alt="image-1" onclick="" />
                            <img class="image-option"
                                src="https://minio.thecoffeehouse.com/image/admin/Bottle_oolong_285082.jpg"
                                alt="image-1" onclick="" />
                            <img class="image-option"
                                src="https://minio.thecoffeehouse.com/image/admin/Bottle_oolong_285082.jpg"
                                alt="image-1" onclick="" />
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 product-detail-right">
                        <div class="product-detail-name"> {{ $product->name }} </div>
                        <div class="product-detail-footer">
                            <div>
                                <span class="price">
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                </span>
                            </div>
                            <div class="product-detail-footer-quantity">
                                <button type="button" id="decrease-quantity-button" disabled
                                    class="item-button-disabled" onclick="decreaseQuantity()">
                                    <img class="item-button-image"
                                        src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMiIgdmlld0JveD0iMCAwIDE2IDIiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxNiIgaGVpZ2h0PSIyIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K"
                                        alt="" />
                                </button>
                                <input type="text" name="quantity" class="form-control quantity-input"
                                    id="product-quantity" value="1">
                                <button type="button" id="increase-quantity-button" onclick="increaseQuantity()">
                                    <img class="item-button-image"
                                        src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTYuODU3MTQgNi44NTcxNFYwSDkuMTQyODZWNi44NTcxNEgxNlY5LjE0Mjg2SDkuMTQyODZWMTZINi44NTcxNFY5LjE0Mjg2SDBWNi44NTcxNEg2Ljg1NzE0WiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cg=="
                                        alt="" />
                                </button>
                            </div>
                        </div>
                        <div class="product-detail-note">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">
                                    <img src="{{ url('/images/clipboard-solid.svg') }}" class="product-detail-clipboard"
                                        alt="clipboard" />
                                </span>
                                <input name="note" type="text" class="form-control"
                                    placeholder="Ghi chú thêm cho món này" aria-label="Note"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="product-detail-size">
                            <div class="product-detail-size-header">
                                Chọn size (bắt buộc)
                            </div>
                            <div class="product-detail-size-body">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios2"
                                        value="Small" checked>
                                    <div class="form-check-label" for="size">
                                        Nhỏ
                                    </div>
                                    <div class="form-check-label" for="size">
                                        + 0đ
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios2"
                                        value="Medium" checked>
                                    <div class="form-check-label" for="size">
                                        Vừa
                                    </div>
                                    <div class="form-check-label" for="size">
                                        + 3.000đ
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="size" id="exampleRadios3"
                                        value="Large">
                                    <div class="form-check-label" for="size">
                                        Lớn
                                    </div>
                                    <div class="form-check-label" for="size">
                                        + 6.000đ
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="product_id" value="{{ $product_id }}">
                                <input type="hidden" name="cart_id" value="{{ $product_id }}">
                            </div>
                        </div>
                        <div class="product-detail-button">
                            <button type="submit" id="liveToastBtn"><span
                                    class="price">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                -
                                Thêm
                                vào
                                giỏ hàng</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="product-detail-description">
                            {{ $product->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="notification" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="/images/logo/logo-2.png" width="30px" class="rounded me-2" alt="logo-2">
                <strong class="me-auto">Buy me store</strong>
                <small>Bây giờ</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Thêm vào giỏ hàng thành công.
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/product_detail.js') }}"></script>
@if (\Session::get('message'))
    <script>
        const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
    </script>
@endif
@endsection

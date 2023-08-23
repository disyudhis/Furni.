<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <!-- Search -->
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" placeholder="Search..."
                    aria-label="Search..." aria-describedby="button-addon2">
                <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
            </div>
            <!-- /Search -->

            <!-- Start Column 1 -->
            @foreach ($product as $products)
                <div class="col-12 col-md-4 col-lg-3 mb-5 mt-5">
                    <a class="product-item" href="#">
                        <img src="/product/{{ $products->image }}" class="img-fluid product-thumbnail">
                        <h3 class="product-title">{{ $products->title }}</h3>

                        @if ($products->discount_price != null)
                            <strong class="product-price">Discount Price
                                <span style="color: red">
                                    Rp. {{ $products->discount_price }}
                                </span>
                            </strong>
                            <br>
                            <strong class="product-price">
                                Price :
                                <span style="text-decoration: line-through; color: green">
                                    Rp. {{ $products->price }}
                                </span>
                            </strong>
                        @else
                            <strong class="product-price">
                                Price :
                                <span style="color: green">
                                    Rp. {{ $products->price }}
                                </span>
                            </strong>
                        @endif

                        <span class="icon-cross">
                            <img src="dashboard/images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
            @endforeach
            <!-- End Column 1 -->
            <span style="padding-top: 20px">
                {!! $product->withQueryString()->links('pagination::bootstrap-5') !!}
            </span>
        </div>
    </div>
</div>

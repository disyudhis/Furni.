<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row" id="shop">
            <!-- Search -->
            <div class="input-group mb-3">
                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search..."
                    aria-describedby="button-addon2">
                <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
            </div>
            <!-- /Search -->

            <!-- Start Column 1 -->
            @foreach ($product as $products)
                <div class="col-12 col-md-4 col-lg-3 mb-5 mt-5">
                    <a class="product-item" href="{{ url('/product_details', $products->id) }}">
                        <img src="/product/{{ $products->image }}" class="img-fluid product-thumbnail">
                        <h2 class="product-title">{{ $products->title }}</h2>
                        <figcaption class="blockquote-footer">
                            Category : {{ $products->category }}
                        </figcaption>
                        @if ($products->discount_price != null)
                            <p class="product-price fs-6 fw-medium">Discount Price
                                <span class="fw-bold" style="color: red">
                                    Rp. {{ number_format($products->discount_price, 0, ',', '.') }}
                                </span>
                            </p>
                            <p class="product-price fs-6 fw-medium">
                                Price :
                                <span class="fw-bold" style="text-decoration: line-through; color: green">
                                    Rp. {{ number_format($products->price, 0, ',', '.') }}
                                </span>
                            </p>
                        @else
                            <p class="product-price fs-6 fw-medium">
                                Price :
                                <span class="fw-bold" style="color: green">
                                    Rp. {{ number_format($products->price, 0, ',', '.') }}
                                </span>
                            </p>
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

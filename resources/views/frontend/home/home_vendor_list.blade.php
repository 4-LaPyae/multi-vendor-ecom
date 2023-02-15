@php
    $vendors =App\Models\User::where('status', 'active')
        ->where('role', 'vendor')
        ->orderBy('id', 'desc')
        ->limit(4)
        ->get();
@endphp
<div class="container">
    <div class="section-title wow animate__animated animate__fadeIn" data-wow-delay="0">
        <h3 class="">All Our Vendor List </h3>
<<<<<<< HEAD
        <a class="show-all" href="{{ route('vendor.all') }}">
=======
        <a class="show-all" href="{{route('vendor.all')}}">
>>>>>>> e8eada7
            All Vendors
            <i class="fi-rs-angle-right"></i>
        </a>
    </div>
    <div class="row vendor-grid">
        @foreach ($vendors as $vendor)
            <div class="col-lg-3 col-md-6 col-12 col-sm-6 justify-content-center">
                <div class="vendor-wrap mb-40">
                    <div class="vendor-img-action-wrap">
                        <div class="vendor-img">
<<<<<<< HEAD
                            <a href="vendor-details-1.html">
=======
                            <a href="{{ route('vendor.details',$vendor->id) }}">
>>>>>>> e8eada7
                                <img class="default-img"
                                    src="{{ !empty($vendor->photo) ? url('upload/vendor_images/' . $vendor->photo) : asset('storage/nophoto.webp') }}"
                                    style="width:120px;height: 120px;" alt="" />
                            </a>
                        </div>
                        <div class="product-badges product-badges-position product-badges-mrg">
                            <span class="hot">Mall</span>
                        </div>
                    </div>
                    <div class="vendor-content-wrap">
                        <div class="d-flex justify-content-between align-items-end mb-30">
                            <div>
                                <div class="product-category">
                                    @if (is_null($vendor->vendor_join))
                                        <span></span>
                                    @else
                                        <span class="text-muted">Since {{ $vendor->vendor_join }}</span>
                                    @endif
                                </div>
<<<<<<< HEAD
                                <h4 class="mb-5"><a href="vendor-details-1.html">{{ $vendor->name }}</a></h4>
                                <span class="font-small total-product">{{ count($vendor->products) }} products</span>
=======
                                <h4 class="mb-5"><a href="{{ route('vendor.details',$vendor->id) }}">{{ $vendor->name }}</a></h4>
                                @php
                                    $products = App\Models\Product::where('vendor_id',$vendor->id)->get();
                                @endphp
                                <span class="font-small total-product">{{ count($products) }} products</span>
>>>>>>> e8eada7
                            </div>
                        </div>
                    </div>
                    <div class="vendor-info mb-30">
                        <ul class="contact-infor text-muted">
                            <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}"
                                    alt="" /><strong>Call Us:</strong><span>{{ $vendor->phone }}</span></li>
                        </ul>
                    </div>
                    <a href="{{ route('vendor.details',$vendor->id) }}" class="btn btn-xs">Visit Store <i
                            class="fi-rs-arrow-small-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
        <!--end vendor card-->       
    </div>
</div>

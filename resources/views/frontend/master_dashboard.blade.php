<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest - Multipurpose eCommerce HTML Template</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
</head>

<body>
    <!-- Modal -->

    <!-- Quick view -->
    @include('frontend.body.quickview')
    <!-- Header  -->
    @include('frontend.body.header')
    <!-- End Header  -->
    <main class="main">
        @yield('main')
    </main>
    @include('frontend.body.footer')
    <!-- Preloader Start -->
    {{-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Vendor JS-->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script type="text/javascript">
        //PRODUCT VIEW MODEL
        function productView(id) {

            if (id) {
                $.ajax({
                    url: "{{ url('product/view/model') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#pname").text(data.product.product_name);
                        $("#pimage").attr('src', '/' + data.product.product_thambnail);
                        $('#cprice').text(data.product.selling_price);
                        $('#pcode').text(data.product.product_code);
                        $('#pcategory').text(data.product.category.category_name);
                        $('#pbrand').text(data.product.brand.brand_name);

                        $('#product_id').val(id);
                        $('#qty').val(1);

                        // Product Price 
                        if (data.product.discount_price == null) {
                            $('#cprice').text('');
                            $('#oldprice').text('');
                            $('#cprice').text(data.product.selling_price + 'MMK');
                        } else {
                            $('#cprice').text(data.product.discount_price + 'MMK');
                            $('#oldprice').text(data.product.selling_price + 'MMk');
                        } // end else
                        /// Start Stock Option
                        if (data.product.product_qty > 0) {
                            $('#aviable').text('');
                            $('#stockout').text('');
                            $('#aviable').text('aviable');
                        } else {
                            $('#aviable').text('');
                            $('#stockout').text('stockout');
                        }
                        ///End Start Stock Option
                        //SIZE
                        $('select[name="size"]').empty();
                        $.each(data.size, function(key, value) {
                            $('select[name="size"]').append('<option value="' + value + '">' + value +
                                '</option>');
                            if (data.size == "") {
                                $('#sizeArea').hide();
                            } else {
                                $('#sizeArea').show();
                            }
                        })
                        //END
                        ///Color 
                        $('select[name="color"]').empty();
                        $.each(data.color, function(key, value) {
                            $('select[name="color"]').append('<option value="' + value + ' ">' + value +
                                '  </option')
                            if (data.color == "") {
                                $('#colorArea').hide();
                            } else {
                                $('#colorArea').show();
                            }
                        }) // end size

                    }
                })
            } else {
                console.log('no id');
            }


        }
        //END

        //ADD TO CART
        function addToCart() {
            var product_name = $('#pname').text();
            var id = $('#product_id').val();
            var color = $('#color option:selected').text();
            var size = $('#size option:selected').text();
            var quantity = $('#qty').val();
            $.ajax({
                url: "{{ url('cart/data/store') }}",
                method: "POST",
                data: {
                    id: id,
                    product_name: product_name,
                    color: color,
                    size: size,
                    quantity: quantity,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    $('#closeModal').click();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }
                    miniCart();

                }
            });

        }
        //END
        //ADD TO CART DETAILS
        function addToCartDetails() {
            var product_name = $('#detailpname').text();
            var id = $('#detailproduct_id').val();
            var color = $('#detailcolor option:selected').text();
            var size = $('#detailsize option:selected').text();
            var quantity = $('#detailqty').val();
            $.ajax({
                url: "{{ url('detailcart/data/store') }}",
                method: "POST",
                data: {
                    id: id,
                    product_name: product_name,
                    color: color,
                    size: size,
                    quantity: quantity,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }
                    miniCart();

                }
            });

        }
        //END
        function miniCart() {
            $.ajax({
                type: 'GET',
                url: '/product/mini/cart',
                dataType: 'json',
                success: function(response) {
                    $('#cartQty').text(response.cartQty);
                    $('#cartTotal').text(response.cartTotal + 'MMK');
                    var miniCart = ""
                    $.each(response.carts, function(key, value) {
                        miniCart += ` <ul>
                                            <li>
                                                <div class="d-flex">
                                                    <div class="shopping-cart-img">
                                                        <a href="shop-product-right.html"><img alt="Nest" src="/${value.options.image} "/></a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4><a href="shop-product-right.html"> ${value.name} </a></h4>
                                                        <h4><span>${value.qty} × </span>${value.price}MMK</h4>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <a href="" id="${value.rowId}" onclick="miniCartRemove(this.id)"><i class="fi-rs-cross-small"></i></a>
                                                    </div>
                                                </div>
                                            </li> 
                                        </ul>
                                        <hr><br>  
                                            `
                    });
                    $('#miniCart').html(miniCart);
                }
            })
        }
        miniCart();

        //MINICART REMOVE
        function miniCartRemove(rowId) {
            $.ajax({
                url: "{{ url('minicart/product/remove') }}/" + rowId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }
                    miniCart();

                }
            })
        }
        //END
    </script>

    {{-- ADD TO WISHLIST --}}
    <script type="text/javascript">
        function addToWishlist(id) {
            $.ajax({
                url: "add/product/wishlist",
                type: "POST",
                dataType: 'json',
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  
                }


            })
        }
    </script>
    {{-- END --}}

    {{-- WISHLIST --}}
    <script type="text/javascript">
        function wishlist() {

            $.ajax({
                url: "/get-wishlist-product/",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('#wishQty').text(response.wishQty)
                    var rows = "";
                    $.each(response.wishlist, function(key, value) {
                        rows += `<tr class="pt-30">
                        <td class="custome-checkbox pl-30">
                            
                        </td>
                        <td class="image product-thumbnail pt-40"><img src="/${value.products.product_thambnail}" alt="#" /></td>
                        <td class="product-des product-name">
                            <h6><a class="product-name mb-10" href="shop-product-right.html">${value.products.product_name} </a></h6>
                            <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 90%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                            </div>
                        </td>
                        <td class="price" data-title="Price">
                        ${value.products.discount_price == null
                        ? `<h3 class="text-brand">${value.products.selling_price}MMK</h3>`
                        :`<h3 class="text-brand">${value.products.discount_price}MMK</h3>`
                        }
                            
                        </td>
                        <td class="text-center detail-info" data-title="Stock">
                            ${value.products.product_qty > 0 
                                ? `<span class="stock-status in-stock mb-0"> In Stock </span>`
                                :`<span class="stock-status out-stock mb-0">Stock Out </span>`
                            } 
                           
                        </td>
                       
                        <td class="action text-center" data-title="Remove">
                            <a type="submit" id="${value.id}" class="text-body" onclick="wishlistRemove(this.id)">
                            <i class="fi-rs-trash text-danger"></i></a>
                        </td>
                    </tr> `
                    });
                    $('#wishlist').html(rows);
                }
            })


        }

        function wishlistRemove(id) {
            $.ajax({
                url: "{{ url('/remove/product/wishlist') }}/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    wishlist();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }

                }
            })
        }
        wishlist();
    </script>
    {{-- END --}}

    {{-- ADD TO COMPARE --}}
    <script type="text/javascript">
        function addToCompare(id) {
            $.ajax({
                url: "add/product/compare",
                type: "POST",
                dataType: 'json',
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  
                }


            })
        }
    </script>
    {{-- END --}}
    {{-- comparelist --}}
    <script type="text/javascript">
        function compare() {
            $.ajax({
                url: "get/compare/product",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var rows = ""
                    $.each(data, function(key, value) {
                        rows += ` <tr class="pr_image">
                                    <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>
                                <td class="row_img"><img src="/${value.products.product_thambnail} " style="width:300px; height:300px;"  alt="compare-img" /></td>
                                    
                                </tr>
                                <tr class="pr_title">
                                    <td class="text-muted font-sm fw-600 font-heading">Name</td>
                                    <td class="product_name">
                                        <h6><a href="shop-product-full.html" class="text-heading">${value.products.product_name} </a></h6>
                                    </td>
                                   
                                </tr>
                                <tr class="pr_price">
                                    <td class="text-muted font-sm fw-600 font-heading">Price</td>
                                    <td class="product_price">
                      ${value.products.discount_price == null
                        ? `<h4 class="price text-brand">${value.products.selling_price}MMK</h4>`
                        :`<h4 class="price text-brand">${value.products.discount_price}MMK</h4>`
                        } 
                                    </td>
                                  
                                </tr>
                                
                                <tr class="description">
                                    <td class="text-muted font-sm fw-600 font-heading">Description</td>
                                    <td class="row_text font-xs">
                                        <p class="font-sm text-muted"> ${value.products.short_descp}</p>
                                    </td>
                                    
                                </tr>
                                <tr class="pr_stock">
                                    <td class="text-muted font-sm fw-600 font-heading">Stock status</td>
                                    <td class="row_stock">
                                ${value.products.product_qty > 0 
                                ? `<span class="stock-status in-stock mb-0"> In Stock </span>`
                                :`<span class="stock-status out-stock mb-0">Stock Out </span>`
                               } 
                              </td>
                                   
                                </tr>
                                
            <tr class="pr_remove text-muted">
                <td class="text-muted font-md fw-600"></td>
                <td class="row_remove">
                    <a type="submit" id="${value.id}" onclick="compareRemove(this.id)" class="text-danger"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                </td>
                
            </tr> `
                    });
                    $('#compare').html(rows);
                }
            })
        }
        compare();
    </script>
    {{-- end --}}

    {{-- remove compare --}}
    <script type="text/javascript">
        function compareRemove(id) {
            $.ajax({
                url: "remove/compare/product/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    compare();
                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  
                }
            })
        }
    </script>
    {{-- end --}}

    {{-- load mycart --}}
    <script type="text/javascript">
        function myCart() {
            $.ajax({
                url: "get/my/cart",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var rows = ""
                    $.each(data.carts, function(key, value) {
                        rows += `<tr class="pt-30">
            <td class="custome-checkbox pl-30">
                 
            </td>
            <td class="image product-thumbnail pt-40"><img src="/${value.options.image} " alt="#"></td>
            <td class="product-des product-name">
                <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${value.name} </a></h6>
                
            </td>
            <td class="price" data-title="Price">
                <h4 class="text-body">${value.price}MMK</h4>
            </td>
              <td class="price" data-title="Price">
              ${value.options.color == null
                ? `<span>.... </span>`
                : `<h6 class="text-body">${value.options.color} </h6>`
              } 
            </td>
               <td class="price" data-title="Price">
              ${value.options.size == null
                ? `<span>.... </span>`
                : `<h6 class="text-body">${value.options.size} </h6>`
              } 
            </td>
            <td class="text-center detail-info" data-title="Stock">
                <div class="detail-extralink mr-15">
                    <div class="detail-qty border radius">
                        <a type="submit" class="qty-up" id="${value.rowId}" onclick="cartIncrement(this.id)"><i class="fi-rs-angle-small-up"></i></a>
                        <p text-bold>${value.qty}</p>
                    ${value.qty == 1 ? ` `
                            : `<a type="submit" class="qty-down" id="${value.rowId}" onclick="cartDecrement(this.id)"><i class="fi-rs-angle-small-down"></i></a>`
                    }
                </div>
            </td>
            <td class="price" data-title="Price">
                <h4 class="text-brand">${value.subtotal}MMK</h4>
            </td>
            <td class="action text-center" data-title="Remove"><a type="submit" id="${value.rowId}" onclick="removeCart(this.id)" class="text-body"><i class="fi-rs-trash text-danger"></i></a></td>
            </tr>`
                    });
                    $('#cartpage').html(rows);
                }

            })
        }
        //remove cart
        function removeCart(rowId) {
            //console.log(rowId);
            $.ajax({
                url: "remove/cart/" + rowId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    myCart();
                    miniCart();i
                    //start message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                    // End Message  

                }
            })
        }
        //end
        myCart();
    </script>
    {{-- end --}}
    {{-- DECREASE CART --}}
    <script type="text/javascript">
        function cartDecrement(rowId){
            $.ajax({
                url:"cart/decrement/"+rowId,
                type:"GET",
                dataType:"json",
                success:function(data){
                    if(data.qty === 1){
                       console.log("disabled");
                    }
                   myCart();
                   miniCart();
                }
            })
        }
    </script>
    {{-- END --}}
    {{-- INCREMENT CART --}}
    <script type="text/javascript">
        function cartIncrement(rowId){
            $.ajax({
                url:"cart/increment/"+rowId,
                type:"GET",
                dataType:"json",
                success:function(data){
                   myCart();
                   miniCart();
                }
            })
        }
    </script>
    {{-- END --}}
</body>

</html>

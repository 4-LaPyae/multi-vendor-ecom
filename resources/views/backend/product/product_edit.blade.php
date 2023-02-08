@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Product</h5>
                <hr />
                <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded">
                                    <div class="form-group mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control"
                                            id="inputProductTitle" value="{{ $product->product_name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Tags</label>
                                        <input type="text" name="product_tags" class="form-control visually-hidden"
                                            data-role="tagsinput" value="{{ $product->product_tags }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Size</label>
                                        <input type="text" name="product_size" class="form-control visually-hidden"
                                            data-role="tagsinput" value="{{ $product->product_size }} ">
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Color</label>
                                        <input type="text" name="product_color" class="form-control visually-hidden"
                                            data-role="tagsinput" value="{{ $product->product_color }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="inputProductDescription" class="form-label">Short Description</label>
                                        <textarea name="short_descp" class="form-control" id="inputProductDescription" rows="3">
        {{ $product->short_descp }}
				</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Long Description</label>
                                        <textarea class="form-control" name="long_descp">
				 {!! $product->long_descp !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row g-3">
                                        <div class="form-group col-md-6">
                                            <label for="inputPrice" class="form-label">Product Price</label>
                                            <input type="text" name="selling_price" class="form-control" id="inputPrice"
                                                value="{{ $product->selling_price }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputCompareatprice" class="form-label">Discount Price </label>
                                            <input type="text" name="discount_price" class="form-control"
                                                id="inputCompareatprice" value="{{ $product->discount_price }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputCostPerPrice" class="form-label">Product Code</label>
                                            <input type="text" name="product_code" class="form-control"
                                                id="inputCostPerPrice" value="{{ $product->product_code }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputStarPoints" class="form-label">Product Quantity</label>
                                            <input type="text" name="product_qty" class="form-control"
                                                id="inputStarPoints" value="{{ $product->product_qty }}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="inputProductType" class="form-label">Product Brand</label>
                                            <select name="brand_id" class="form-select" id="inputProductType">
                                                <option></option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="inputVendor" class="form-label">Product Category</label>
                                            <select name="category_id" class="form-select" id="inputVendor">
                                                <option></option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                                        {{ $cat->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="inputCollection" class="form-label">Product SubCategory</label>
                                            <select name="subcategory_id" class="form-select" id="inputCollection">
                                                <option></option>
                                                @foreach ($subcategory as $subcat)
                                                    <option value="{{ $subcat->id }}"
                                                        {{ $subcat->id == $product->subcategory_id ? 'selected' : '' }}>
                                                        {{ $subcat->subcategory_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="inputCollection" class="form-label">Select Vendor</label>
                                            <select name="vendor_id" class="form-select" id="inputCollection">
                                                <option></option>
                                                @foreach ($activeVendor as $vendor)
                                                    <option value="{{ $vendor->id }}"
                                                        {{ $vendor->id == $product->vendor_id ? 'selected' : '' }}>
                                                        {{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="hot_deals" type="checkbox"
                                                            value="1" id="flexCheckDefault"
                                                            {{ $product->hot_deals == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexCheckDefault"> Hot
                                                            Deals</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="featured" type="checkbox"
                                                            value="1" id="flexCheckDefault"
                                                            {{ $product->featured == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="flexCheckDefault">Featured</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="special_offer"
                                                            type="checkbox" value="1" id="flexCheckDefault"
                                                            {{ $product->special_offer == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexCheckDefault">Special
                                                            Offer</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="special_deals"
                                                            type="checkbox" value="1" id="flexCheckDefault"
                                                            {{ $product->special_deals == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexCheckDefault">Special
                                                            Deals</label>
                                                    </div>
                                                </div>
                                            </div> <!-- // end row  -->
                                        </div>
                                        <hr>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <input type="submit" class="btn btn-primary px-4"
                                                    value="Save Changes" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
            </div>
            </form>
        </div>
    </div>
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">Update Main Image Thambnail </h6>
        <hr>
        <div class="card">
            <form method="post" action="{{ route('update.thambnail') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="old_image" value="{{ $product->product_thambnail }}">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Chose Thambnail Image </label>
                        <input name="product_thambnail" class="form-control" type="file" id="image"
                           >
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label"> </label>
                        <img class="rounded" id="mainThmb" src="{{ asset($product->product_thambnail) }}"
                            style="width:100px; height:100px">
                    </div>
                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                </div>
            </form>
        </div>
    </div>
    <!-- update multi image-->
    <div class="page-content">
        <h6 class="mb-0 text-uppercase">Update Multi Image </h6>
        <hr>
        <div class="card">
            <div class="card-body">
                <table class="table mb-0 table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#Sl</th>
                            <th scope="col">Image</th>
                            <th scope="col">Change Image </th>
                            <th scope="col">Delete </th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="{{ route('update.multi.images') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @foreach ($product->images as $key => $img)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td> <img  id="changemultiimage" src="{{ asset($img->photo_name) }}" style="width:70; height: 40px;"> </td>
                                    <td>
                                         <input type="file" id="multiimage" class="form-group" name="multi_img[{{ $img->id }}]" >
                                    </td>
                                    <td>
                                        <input type="submit" class="btn btn-primary px-4" value="Update Image " />
                                        <a href="{{ route('delete.multi.image',$img->id) }}" class="btn btn-danger" id="deleteinatag"> Delete </a>
                                    </td>
                                </tr>
                            @endforeach
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /// End Update Multi Image  ////// -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThmb').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#multiimage').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#changemultiimage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("select[name='category_id']").change(function() {
                var id = $(this).val();
                $.ajax({
                    url: "{{ url('postsubcategory') }}",
                    method: "POST",
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('select[name="subcategory_id"]').html('');
                        $.each(data, function(key, value) {
                            $('select[name="subcategory_id"]').append(
                                '<option value="' + value.id + '">' + value
                                .subcategory_name + '</option>');
                        })
                    }
                });
            })
        })
        // $(document).ready(function(){
        //     $("select[name='category_id']").on('change',function(){
        //          var category_id = $(this).val();
        //         if(category_id){
        //             $.ajax({
        //                 url:"{{ url('subcategory/ajax') }}/"+category_id,
        //                 type:"GET",
        //                 dataType:"json",
        //                 success:function(data){
        //                     console.log(data)
        //                     $('select[name="subcategory_id"]').html('');
        //                    $.each(data,function(key,value){
        //                     //console.log(value.subcategory_name);
        //                     $('select[name="subcategory_id"]').append('<option value="'+ value.id + '">' + value.subcategory_name + '</option>');
        //                    })
        //                 }
        //             })
        //         }else{
        //             console.log('no category_id');
        //         }

        //     })
        // })
    </script>
@endsection

@php
    $categories = App\Models\Category::with('products')->orderBy('category_name','ASC')->get();
@endphp
<section class="popular-categories section-padding">
    <div class="container wow animate__animated animate__fadeIn">
        <div class="section-title">
            <div class="title">
                <h3>Featured Categories</h3>
            </div>
            <div class="slider-arrow slider-arrow-2 flex-right carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
        </div>
        <div class="carausel-10-columns-cover position-relative">
            <div class="carausel-10-columns" id="carausel-10-columns">
                @foreach ($categories as $category)
                <div class="card-2 bg-11 wow animate__animated animate__fadeInUp" data-wow-delay="0s">
                    <figure class="img-hover-scale overflow-hidden">
                        <a href="{{url('product/category/'.$category->id.'/'.$category->category_slug)}}"><img src="{{ $category->category_image }}" alt="" /></a>
                    </figure>
                    <h6><a href="{{url('product/category/'.$category->id.'/'.$category->category_slug)}}">{{ $category->category_name }}</a></h6>
                    <span>{{ count($category->products) }}</span>
                </div>  
                @endforeach    
            </div>
        </div>
    </div>
</section>
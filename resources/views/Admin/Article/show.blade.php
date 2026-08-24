@extends('Admin.app')
@yield('title',"Dashboard - Articles")

@section('dashboard-header')

	<div class="row">
					<div class="col-sm-12">
						<h4 class="page-title">Details de l'article {{$article->title }}</h4> </div>
				</div>

@endsection

@section('dashboard-content')

	<div class="row mt-3">
					<div class="col-md-8">
						<div class="blog-view">
							<article class="blog blog-single-post">
								<h3 class="blog-title">{{$article->title }}</h3>
								<div class="blog-image">
									<a href="blog-details.html"><img src="{{ $article->imageUrl()}}" alt="{{ $article->slug}}" class="img-fluid mt-4"></a>
								</div>
								<div class="blog-content mt-4">
									{!! $article->description !!}
								</div>
							</article>

							<div class="widget">
								<h3 class="widget-title">Tags</h3>
								@foreach ($article->tags as $tag )
                                <label class="label label-info btn btn-primary">{{$tag->name}}</label>
             
                                   @endforeach


							</div>



							<div class="widget author-widget clearfix">
								<h3>A propos de l'auteur</h3>
								<div class="about-author">
									<div class="about-author-img">
										<div class="author-img-wrap"> <img class="img-fluid rounded-circle"  src="{{asset('back_auth/assets/Profile/'.$article->author->image)}}" alt="User Image"> </div>
									</div>
									<div class="author-details"> <span class="blog-author-name">{{ $article->author->name }}</span>
										<p>Date de publication : {{ $article->created_at->format('d/m/Y') }}</p>
									</div>
								</div>
							</div>
</div>
</div>

@endsection
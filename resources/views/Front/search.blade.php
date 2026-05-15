@extends('Front.app')
@section('title','ActuInfo-Recherche')

@section('Main_section')
 <div class="row">

              @if (count($articles))
               @foreach ($articles as $article)
              <div class="col-lg-6">  
                <div class="position-relative mb-3">
                  <img
                    class="img-fluid w-100"
                    src="{{ $article->imageUrl()}}"
                    style="object-fit: cover"
                  />
                  <div class="bg-white border border-top-0 p-4">
                    <div class="mb-2">
                      <a
                        class="badge badge-info text-uppercase font-weight-semi-bold p-2 mr-2"
                        href="{{ route('category.article', $article->category->slug)}}"
                        >{{ $article->category->name}}</a
                      >
                      <a class="text-body" href=""
                        ><small>@php
                          $time= $article->created_at
                        @endphp
                        {{ $time->isoFormat('LL') }}</small></a
                      >
                    </div>
                    <a
                      class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold"
                      href="{{ route('article.details', $article->slug) }}"
                      >{{ Str::limit($article->title, 50, '...') }}</a
                    >
                    <p class="m-0">
                       {{ Str::limit($article->description, 150, '...') }}
                    </p>
                  </div>
                  <div
                    class="d-flex justify-content-between bg-white border border-top-0 p-4"
                  >
                    <div class="d-flex align-items-center">
                      <img
                        class="rounded-circle mr-2"
                        src="{{asset('back_auth/assets/Profile/'.$article->author->image)}}"
                        width="25"
                        height="25"
                        alt=""
                      />
                      <small>{{ $article->author->name}}</small>
                    </div>
                    <div class="d-flex align-items-center">
                      <small class="ml-3"
                        ><i class="far fa-eye mr-2"></i>{{ $article->views}}</small >
                      <small class="ml-3" ><i class="far fa-comment mr-2"></i>{{ $article->comments->count()}}</small>
                    </div>
                  </div>
                </div>
              </div>
          @endforeach
                
          @else
          <p>Aucun resulats trouve</p>
          @endif
    
 </div>

@endsection

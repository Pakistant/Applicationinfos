@extends('Admin.app')
@section('title', "Dashboard - Ajouts Articles")

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col">
      <h3 class="page-title mt-5">@if (isset($article)) Modifier @else Ajouter @endif un article</h3>
    </div>
  </div>
@endsection

@section('dashboard-content')
<div class="col-lg-12">
  <form action="{{ isset($article) ? route('article.update', $article) : route('article.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if (isset($article))
      @method('PUT')
    @endif

    <div class="row formtype">

      <div class="col-12">
        @if(isset($article) && $article->imageUrl())
          <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}" style="width:100%; height:200px;">
        @endif
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Titre de l'article</label>
          <input
            class="form-control"
            type="text"
            name="title"
            value="{{ isset($article) ? old('title', $article->title) : old('title') }}"
          />
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Catégorie</label>
          <select class="form-control" id="category_id" name="category_id">
            @forelse ($categories as $category)
              <option value="{{ $category->id }}" 
                @selected(isset($article) && $article->category_id == $category->id)>
                {{ $category->name }}
              </option>
            @empty
              <option value="">Aucune catégorie active disponible</option>
            @endforelse
          </select>
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Uploader une image</label>
          <div class="custom-file mb-3">
            <input type="file" class="custom-file-input" id="image" name="image">
            <label class="custom-file-label" for="customFile">Choisir une image</label>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="form-group">
          <label>Description</label>
          <textarea class="form-control" rows="5" id="description" name="description">{{ isset($article) ? old('description', $article->description) : old('description') }}</textarea>
       
          @if (isset($article))

          <div class="col md 12 mt-3">
           @foreach ($article->tags as $tag )
            <label class="label label-info btn btn-primary">{{$tag->name}}</label>
             
           @endforeach

          </div>
            
          @endif

           <div class="col-md-12 mt-3">
            <input type="text" class="form-control" data-role="tagsinput" name="tags">
            @if ($errors->has('tags'))
              <spam> class="text-danger">{{ $errors->first('tags') }}</spam>
            @endif
          </div>
       
        </div>
      </div>
         
        

      {{-- Radios Publication, Partage, Commentaire (inchangés mais OK) --}}



      <div class="col-md-4">
                    <div class="form-group">
                      <label>Publication</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input  class="form-check-input" type="radio" id="isActive" name="isActive" value="1" @if(isset($article) && $article->isActive == 1) checked @endif checked>
                      <label class="form-check-label" for="isActive">Publier</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input  class="form-check-input" type="radio" id="isActive" name="isActive" value="0" @if(isset($article) && $article->isActive == 0) checked @endif   >
                      <label class="form-check-label" for="isActive">Ne pas publier</label>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Partages</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input  class="form-check-input" type="radio" id="isSharable" name="isSharable" value="1"  @if(isset($article) && $article->isSharable == 1) checked @endif checked>
                      <label class="form-check-label" for="isSharable">Partageable</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input  class="form-check-input" type="radio" id="isSharable" name="isSharable" value="0" @if(isset($article) && $article->isSharable == 0) checked @endif >
                      <label class="form-check-label" for="isSharable">Non Partageable</label>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Commentaires</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" id="isComment" name="isComment" value="1" @if(isset($article) && $article->isComment == 1) checked @endif checked>
                      <label class="form-check-label" for="isComment">Autorise</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input  class="form-check-input" type="radio" id="isComment" name="isComment" value="0" @if(isset($article) && $article->isComment == 0) checked @endif>
                      <label class="form-check-label" for="isComment">Non autorise</label>
                    </div>
                  </div>  

      <button type="submit" class="btn btn-primary buttonedit1">Enregistrer l'article</button>
    </div>
  </form>
</div>
@endsection

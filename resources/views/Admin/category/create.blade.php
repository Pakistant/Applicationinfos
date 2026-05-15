@extends('Admin.app')
@yield('title',"Dashboard - Creation d\' une Categories")

@section('dashboard-header')

 <div class="row align-items-center">
              <div class="col">
                <h3 class="page-title mt-5">@if (isset($category))Modifier @else Ajouter   @endif 
                  
               une categorie</h3>
              </div>
            </div>

@endsection

@section('dashboard-content')

 <div class="row">

            <div class="col-lg-12">
              <form action=" {{ isset($category) ? route('category.update', $category) : route('category.store') }}" method="POST" >
             @csrf

             @if (isset($category))

             @method('PUT')
               
             @endif
                <div class="row formtype">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Nom de la categorie</label>
                      <input
                        class="form-control"
                        type="text"
                        name="name"
                        value="{{isset($category)? old('name', $category->name): old('name')}}"
                      />
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Description</label>
                      <textarea
                        class="form-control"
                        rows="5"
                        id="comment"
                        name="description"
                       >{{ isset($article)? old('description', $article->description) : old('description') }}
                      </textarea>
                    </div>
                  </div>

                  <div class="col-md-4">
                        <div class="form-group">
                            <label>Activation</label>
                            <select class="form-control" id="sel2" name="isActive">
                                <option value="1" @if(isset($category) && $category->isActive == 1) selected @endif>Activer</option>
                                <option value="0" @if(isset($category) && $category->isActive == 0) selected @endif>Ne pas activer</option>

                            </select>
                        </div>
                    </div>
                </div>
      				<button type="submit" class="btn btn-primary buttonedit1">
                  Enregistrer
              </button>
              </form>
            </div>
          </div>



@endsection
@extends('Admin.app')
@yield('title',"Dashboard - Page gestion des reseaux sociaux")


@section('dashboard-content')

 <div class="row">
            <div class="col-lg-12">
              <form action="{{ route('setting.update')}}"  method="POST" enctype="multipart/form-data" >
                @csrf

                @method('put')
                <h3 class="page-title">Paramètres de base</h3>
                <div class="row mt-4">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label >Nom du site <span class="text-danger">*</span></label>
                      <input class="form-control" type="text" name="web_site_name" value="{{ isset($settings)? old('web_site_name', $settings->web_site_name) : old('web_site_name')}}" />
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Uploader une image</label>
                      <div class="custom-file mb-3">
                        <input
                          type="file"
                          class="custom-file-input"
                          id="customFile"
                          name="logo"
                        />
                        <label class="custom-file-label" for="customFile"
                          >Choisir une image</label
                        >
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Address</label>
                      <input
                        class="form-control"
                        type="text"
                        name="address"
                        value="{{ isset($settings)? old('address', $settings->address) : old('address')}}"
                      />
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Numero de telephone</label>
                      <input
                        class="form-control"
                        type="text"
                        name="phone"
                        value="{{isset($settings)? old('phone', $settings->phone): old('phone') }}"
                      />
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Email</label>
                      <input
                        class="form-control"
                        type="email"
                        name="email"
                        value="{{ isset($settings)? old('email', $settings->email): old('email') }}"
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
                        name="about"
                    
                      > {{ isset($settings)?  old('about', $settings->about ): old('about')}}
                    </textarea>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary buttonedit mr-5 mt-5"> Enregistre </button>
      </div>
    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        

@endsection
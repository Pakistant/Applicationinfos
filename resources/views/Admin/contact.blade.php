@extends('Admin.app')
@section('title', "Dashboard - page des commentaires")

@section('dashboard-header')

<div class="row align-items-center">
						<div class="col">
							<div class="mt-5">
								<h4 class="card-title float-left mt-2">Contacts</h4>
                            </div>
						</div>
					</div>


@endsection

@section('dashboard-content')
<div class="row">
					<div class="col-sm-12">
						<div class="card card-table">
							<div class="card-body booking_card">
								<div class="table-responsive">
									<table class="datatable table table-stripped table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>ID Contact</th>
												<th>Nom</th>
                                                 <th>Email</th>
                                                 <th>Sujet</th>
												<th>Message</th>
												<th>Date</th>
												<th class="text-right">Actions</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($contacts as $contact )
											<tr>
												<td>ART-000{{$contact->id}}</td>
												<td>{{$contact->name}}</td>
												<td>
													<a  href="mailto::{{$contact->email}}">{{$contact->email}}</a>
											    </td>
                                                <td>{{$contact->subject}}</td>
												<td>{{$contact->message}}</td>
												<td>{{ $contact->created_at->format('d/m/Y') }}</td>
                                                
												<td class="text-right">
													<div class="dropdown dropdown-action"> 
                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-ellipsis-v ellipse_color"></i>
                            </a>
						                                     <div class="dropdown-menu dropdown-menu-right"> 
                               
                                                                 <form action="{{route('contact.destroy',$contact)}}" method="POST">
																	@csrf
																	@method("DELETE")
                                                                  <button type="submit" class="btn btn-danger">

                                                                     	<i class="fas fa-trash-alt m-r-5"></i> Supprimer
																  </button>
                                                             </div>
													</div>
												</td>
											</tr>	
											@endforeach
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="delete_asset" class="modal fade delete-modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-body text-center"> <img src="assets/img/sent.png" alt="" width="50" height="46">
							<h3 class="delete_class">Etes vous sure de vouloir supprimer cet element?</h3>
							<div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
								<button type="submit" class="btn btn-danger">Delete</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection
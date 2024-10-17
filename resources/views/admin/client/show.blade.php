@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Client Details <i class="feather icon-film"></i></h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="feather icon-chevron-down"></i></a></li>
                            <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                            <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                            <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <div class="row" style="width: 100%;">
                                        <div class="col-6">
                                            <p><h5>Name: </h5>{!! $data->name !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>DOB: </h5>{!! $data->dob !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Address: </h5>{!! $data->address !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>PostCode: </h5>{!! $data->postcode !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Mobile Number: </h5>{!! $data->mobile_number !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Email: </h5>{!! $data->email !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Are You Pregnant: </h5>{!! $data->are_you_pregnant !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Surgery Name: </h5>{!! $data->surgery_name !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Contact Name: </h5>{!! $data->contact_name !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Any Allergies: </h5>{!! $data->any_allergies !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Reciving Medical Treatment: </h5>{!! $data->reciving_medical_treatment !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>PaceMaker: </h5>{!! $data->pacemaker !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>DNR: </h5>{!! $data->dnr !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Blood Thinner: </h5>{!! $data->blood_thinner !!}</p>
                                        </div>

                                        <div class="col-6">
                                            <p><h5>Current Medications: </h5>{!! $data->current_medications !!}</p>
                                        </div>

                                        <div class="col-6">
                                            <p><h5>Date: </h5>{!! $data->date !!}</p>
                                        </div>
                                        
                                        <div class="col-6">
                                            <p><h5>Signature: </h5>
                                            <td><img src="{{$data->image_url}}" height="50px;"></td>
                                                </p>
                                        </div>

                                        <div class="col-6">
                                            <p><h5>Created At: </h5>{!! $data->created_at->diffForHumans() !!}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><h5>Updated At: </h5>{!! $data->updated_at->diffForHumans() !!}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{!! route('admin.contact-us.index') !!}" style="margin-left: -1rem;
                                                    margin-top: 2rem;"
                                           class="btn btn-primary waves-effect waves-light">
                                            <i class="ti ti-check me-1"></i>Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

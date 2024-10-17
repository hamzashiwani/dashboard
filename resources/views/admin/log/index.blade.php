@extends('admin.layouts.app')

@section('content')
    <section id="column-selectors">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Logs </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-striped dataex-html5-selectors">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Module</th>
                                        <th>Target Id</th>
                                        <th>Author</th>
                                        <th>Created At</th>
                                        <!-- <th>Actions</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data as $key => $result)
                                    @php $target = str_replace('wp_bookly_', ' ', $result['target'])@endphp
                                        <tr>
                                            <td>{!! $result['action'] !!}</td>
                                            <td>{!! ucfirst($target) !!}</td>
                                            <td>{!! $result['target_id'] !!}</td>
                                            <td>{!! $result['author'] !!}</td>
                                            <td>{!! $result['created_at'] !!}</td>
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
    </section>
@endsection

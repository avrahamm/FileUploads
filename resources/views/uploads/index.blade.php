@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Uploads list</div>

                    <div class="card-body">

                        <a href="{{ route('uploads.create') }}" class="btn btn-primary">Add new upload</a>
                        <br /><br />

                        <table class="table">
                            <tr>
                                <th>File Name</th>
                                <th>Download file</th>
                            </tr>
                            @forelse ($userUploads as $upload)
                                <tr>
                                    <td>{{ $upload->name }}</td>
                                    <td><a href="{{ route('uploads.download', $upload->uuid) }}">{{ $upload->name }}</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">No uploads found.</td>
                                </tr>
                            @endforelse
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

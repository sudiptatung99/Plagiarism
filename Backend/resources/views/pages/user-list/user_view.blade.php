<x-app-layout>
    @section('title')
        users
    @endsection
    <style>
        #exampleModal2 .form-label {
            margin-right: 5px;
            width: 75px;
        }
    </style>

    <div class="col-xl-12 px-0">
        <div class="card">
            <div class="card-body">
                <div class="">
                    <div class="d-flex" style="justify-content: space-between;">
                        <h4 style="font-size: 20px;">User List</h4>
                    </div>
                    <div class="col-xl-12 mt-4">
                        <table id="myexpense" width="100%" class="datatable-init table"
                            data-nk-container="table-responsive table-border">
                            <thead>
                                <tr>
                                    <th><span class="overline-title">#</span></th>
                                    <th><span class="overline-title"> Name</span></th>
                                    <th><span class="overline-title">Email</span></th>
                                    <th><span class="overline-title">Phone Number</span></th>
                                    <th><span class="overline-title">Documents</span></th>
                                    <th><span class="overline-title">Action</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($user) > 0)
                                    @foreach ($user as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->firstname }} {{ $item->lastname }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone_number }}</td>
                                            <td>{{ $item->remain_doc }}</td>
                                            <th>
                                                <a href="{{ route('user.edit',encrypt($item->id)) }}" class="btn btn-primary btn-sm" style="color: #ffff" >Update</a>
                                                {{-- <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#planmodal{{ $item->id }}">Delete</button> --}}
                                            </th>
                                        </tr>
                                        {{-- <div class="modal fade" id="planmodal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Plan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this User?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <a href="{{ route('user.delete', encrypt($item->id)) }}"
                                                            type="button" class="btn btn-danger btn-sm">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

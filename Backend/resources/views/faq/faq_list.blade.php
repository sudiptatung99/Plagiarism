<x-app-layout>
    @section('title') plan  @endsection
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
                        <h4 style="font-size: 20px;">All FAQ List</h4>
                        <a href="{{ route('faq.create') }}" class="btn btn-primary">Create FAQ</a>
                    </div>
                    <div class="col-xl-12 mt-4">
                        <table id="myexpense" width="100%" class="datatable-init table"
                            data-nk-container="table-responsive table-border">
                            <thead>
                                <tr>
                                    <th><span class="overline-title">#</span></th>
                                    <th><span class="overline-title">FAQ Question</span></th>
                                    <th><span class="overline-title">FAQ Answer</span></th>
                                    <th><span class="overline-title">Action</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (count($faq) > 0)
                                    @foreach ($faq as $key => $item)
                                        <tr>

                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->question }}</td>
                                            <td>{!! $item->answer !!}</td>
                                            <td>
                                                <a href="{{ route('faq.edit', encrypt($item->id)) }}"
                                                    class="btn btn-primary btn-sm">Update</a>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#planmodal{{ $item->id }}">Delete</button>
                                            </td>
                                            <div class="modal fade" id="planmodal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete Plan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this FAQ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <a href="{{ route('faq.delete', encrypt($item->id)) }}"
                                                                type="button" class="btn btn-danger btn-sm">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
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

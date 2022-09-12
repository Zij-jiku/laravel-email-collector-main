@extends('layouts.master')

@section('content')
    <div class="container">
        @include('partials.messages')

        <div class="row">
            <div class="col-12 col-md-6">
                <form action="{{ route('emails.store') }}" method="POST">
                    @csrf
                    <label for="emails" class="form-label">Emails</label>
                    <textarea rows="5" cols="90" class="form-control" name="emails" id="emails"
                        placeholder="Write emails by comma separated. Ex: akash@example.com, jhon@gmail.com"></textarea>

                    <div class="my-3">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <div class="p-4 shadow bg-white">
                    <h2>Emails</h2>
                    <form action="" method="get" class="my-4">
                        <input type="search" value="{{ request()->s }}" name="s" placeholder="Search"
                            class="form-control">
                    </form>

                    <div class="table-responsive">
                        <table class="table table-border table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Email</th>
                                    <th>Updated at</th>
                                    <th>
                                        <span class="sr-only">
                                            Delete
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($emails as $email)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <a href="mailto:{{ $email->email }}" target="_blank">
                                                {{ $email->email }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $email->updated_at }}
                                        </td>
                                        <td>
                                            <form action="{{ route('emails.destroy', $email->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $emails->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

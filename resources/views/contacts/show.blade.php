@extends('base')
@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Show a contact</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action="{{ route('contacts.index') }}">
                @method('GET')
                @csrf
                <table class="table table-user-information">
                    <tbody>
                        <tr>
                            <td>Firstname:</td>
                            <td>{{ $contact->first_name }}</td>
                        </tr>
                        <tr>
                            <td>Lastname</td>
                            <td>{{ $contact->last_name }}</td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td>{{ $contact->email }}</td>
                        </tr>

                        <tr>
                            <td>City</td>
                            <td>{{ $contact->city }}</td>
                        </tr>

                        <tr>
                            <td>Country </td>
                            <td>{{ $contact->country }}</td>
                        </tr>

                        <tr>
                            <td>Job Title</td>
                            <td>{{ $contact->job_title }}</td>
                        </tr>

                        <tr>
                            <td><button type="submit" href="ayut" class="btn btn-primary">Back</button> </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

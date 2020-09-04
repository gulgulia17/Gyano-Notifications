@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Send Notifications</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form action="{{route('notification')}}" method="post">
                            @csrf
                            <div class="form-group">
                              <label for="notificationtitle">Please enter the title of notification.</label>
                              <input type="text" name="notificationtitle" id="notificationtitle" class="form-control" placeholder="Notification Title" value="{{old('notificationtitle')}}">
                              @error('notificationtitle')
                                  <span class="error">*{{$message}}</span>
                              @enderror
                            </div>
                            <div class="form-group">
                              <label for="notificationdesscript">Please enter the description of notification.</label>
                              <input type="text" name="notificationdesscript" id="notificationdesscript" class="form-control" placeholder="Notification Description" value="{{old('notificationdesscript')}}">
                              @error('notificationdesscript')
                                  <span class="error">*{{$message}}</span>
                              @enderror
                            </div>
                            <div class="form-group text-right mb-0">
                                <button class="btn btn-primary px-4">Send</button>
                              </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

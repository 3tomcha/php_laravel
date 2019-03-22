@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="name">
                                    {{$profiles->name}}
                                </div>
                                <div class="gender">
                                    {{$profiles->gender}}
                                </div>
                                <div class="hobby">
                                    {{$profiles->hobby}}
                                </div>
                                <div class="introduction">
                                    {{$profiles->introduction}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
            </div>
        </div>
    </div>
    </div>
@endsection

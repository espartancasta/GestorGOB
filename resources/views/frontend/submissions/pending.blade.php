@extends('frontend.master')

@section('content')

<div class="container mt-5">

    <h3>Revisiones con problema</h3>

    @foreach($submissions as $submission)

        @foreach($submission->reviewers as $review)

            @if($review->status === 'rejected' || $review->isExpired())

                <div class="card p-3 mt-3">

                    <h5>{{ $submission->title }}</h5>

                    <p>
                        Estado: {{ $review->status }}
                    </p>

                    <a href="{{ route('submissions.show', $submission->id) }}"
                       class="btn btn-warning">
                        Reasignar
                    </a>

                </div>

            @endif

        @endforeach

    @endforeach

</div>

@endsection
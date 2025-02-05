@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="login-area py-60" >
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1">
                <div class="single-terms mb-30">
                    @php
                        echo $cookie->data_values->description
                    @endphp
                </div>

            </div>
        </div>
    </div>
</section>


@endsection

@push('style')
<style>
 p {
        color: hsl(var(--dark));
    }

    ul,
    ol {
        margin-left: 40px;
    }

    .single-terms ul li {
        list-style-type: disc;
        color: hsl(var(--dark));
        ;
    }

    .single-terms ol li {
        list-style-type: disc;
        color: hsl(var(--dark));
        ;
    }

    .single-terms ol li {
        list-style-type: decimal;
    }
</style>
@endpush

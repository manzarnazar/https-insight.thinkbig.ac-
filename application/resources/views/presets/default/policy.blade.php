@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="login-area py-60" >
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1">
                <div class="single-terms mb-30">
                    @php
                        echo $policy->data_values->details
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
        font-family: var(--body-font);
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

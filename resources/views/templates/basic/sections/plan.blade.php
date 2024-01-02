@php
    $plan = getContent('plan.content', true);
    if (Auth::user() && Auth::user()->is_landlord == 1) {
        $plans = App\Models\Plan::where('plan_type', 'landlord')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());
    } elseif (Auth::user() && Auth::user()->is_landlord == 0) {
        $plans = App\Models\Plan::where('plan_type', 'user')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());
    } else {
        $plans = App\Models\Plan::orderBy('id', 'desc')->paginate(getPaginate());
    }
    $user = App\Models\PlanSubscribe::where('user_id', @auth()->user()->id)
        ->with('getUserPlanSubscribe')
        ->orderBy('id', 'desc')
        ->first();

@endphp
<!--=======-**  Plan  Start **-=======-->
<section class="primary-linear-bg pt-100 pb-60 md-pt-60 md-pb-30">
    <div class="container">
        <div class="row">
            <div class="section_tilte text-center pb-50">
                <span>{{ __($plan->data_values->top_heading) }}</span>
                <h3 class="py-2">{{ __($plan->data_values->heading) }}</h3>
                <p class="subheading">{{ __($plan->data_values->subheading) }}</p>
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            @foreach ($plans as $item)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="single_plan text-center mb-30 ">
                        <div class="single_plan__head">
                            <h4>{{ __($item->name) }}</h4>
                            <span>{{ __($general->cur_sym) }}{{ showAmount(__($item->price)) }}</span>
                        </div>
                        <span>
                            @if ($item->plan_type == 'user')
                                <span class="text-sm badge bg-info">For Users</span>
                            @else
                                <span class="text-sm badge bg-info">For Landlords</span>
                            @endif
                        </span>
                        <hr>
                        <div class="single_plan__body mb-35">
                            <ul>
                                @if ($item->plan_type == 'landlord')
                                    <li><i class="fa-solid fa-check"></i>{{ __($item->listing_limit) }}
                                        @lang('Listings Per ') {{ $item->validity }} days</li>
                                @endif
                                <li><i class="fa-solid fa-check"></i>{{ __($item->inquiries_limit) }} @lang('Inquiries Per ')
                                    {{ $item->validity }} days</li>
                                <li><i class="fa-solid fa-check"></i>@lang('Lifetime Support')</li>
                            </ul>
                        </div>
                        <div class="single_plan__foter mb-20">
                            <a href="{{ route('user.payment', $item->id) }}" class="theme_btn style_1"><span
                                    class="btn_title">@lang('Buy
                                                                                        Now ')<i class="fa-solid fa-angles-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</section>
<!--=======-**  Plan  End **-=======-->
@push('style')
    <style>
        .package-disabled {
            opacity: 0.5;
        }
    </style>
@endpush

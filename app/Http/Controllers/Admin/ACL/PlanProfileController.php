<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected $plan;
    protected $profile;

    public function __construct(Plan $plan, Profile $profile)
    {
        $this->plan = $plan;
        $this->profile = $profile;
    }

    public function profiles(Plan $plan)
    {
        $profiles = $plan->profiles()->paginate();

        return view('admin.pages.plans.profiles.profiles', compact('plan', 'profiles'));
    }

    public function plans(Profile $profile)
    {
        $plans = $profile->plans()->paginate();

        return view('admin.pages.profiles.plans.plans', compact('profile', 'plans'));
    }

    public function create(Request $request, Plan $plan)
    {
        $filters = $request->except('_token');
        $profiles = $plan->profilesAvailable($request->filter);

        return view('admin.pages.plans.profiles.create', compact('plan', 'profiles', 'filters'));
    }

    public function store(Request $request, Plan $plan)
    {
        $data = $request->profiles ?: [];

        if (count($data) == 0) {
            return redirect()->back()->with('warning', 'Selecione um perfil.');
        }

        $plan->profiles()->attach($data);

        return redirect()->route('plans.profiles', $plan);
    }

    public function delete(Plan $plan, Profile $profile)
    {
        $plan->profiles()->detach($profile);

        return redirect()->route('plans.profiles', $plan);
    }
}

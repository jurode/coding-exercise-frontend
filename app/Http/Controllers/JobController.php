<?php

namespace App\Http\Controllers;

use App\Company;
use App\Job;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobController extends Controller
{
    public function index(): Factory|View|Application
    {
        // FIXME: hier schon Abfrage nach < 7 Tage
        return view('index', ['jobs' => Job::all()->toArray()]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'company_id' => 'required|integer|gt:0'
        ]);

        $company = Company::findOrFail($request->company_id);
        $job = $company->jobs()->create($request->only('title', 'description', 'location'));

        return response()->json($job, Response::HTTP_CREATED);
    }

    public function getJobs()
    {
        return response()->json(['jobs' => Job::all()]);
    }
}

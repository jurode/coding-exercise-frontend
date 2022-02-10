<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(['companies' => Company::all()]);
    }
}

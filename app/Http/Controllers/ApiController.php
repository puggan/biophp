<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as C;

class ApiController extends Controller
{
    /**
     * @param int $id
     * @return null|Cinema
     */
    public function cinema(int $id): ?Cinema
    {
        return Cinema::find($id);
    }

    /**
     * @return C|Cinema[]
     */
    public function cinemas(): C
    {
        return Cinema::all();
    }
}

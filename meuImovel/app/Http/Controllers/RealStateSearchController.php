<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Models\RealState;
use App\Repository\RealStateRepository;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class RealStateSearchController extends Controller
{
    private $realState;
    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }


    public function index(Request $request)
    {


        $repository = new RealStateRepository($this->realState);

        if ($request->has('conditions')) {
            $repository->selectConditions($request->get('conditions'));
        }

        if ($request->has('fields')) {
            $repository->selectFilter($request->get('fields'));
        }
        $repository->setLocation($request->all(['state', 'city']));

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }

 
    public function show($id)
    {
        try {

            $realState = $this->realState->with('address')->with('photos')->findOrFail($id);

            return response()->json([
                'data' => $realState
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);

        }
    }

    
}

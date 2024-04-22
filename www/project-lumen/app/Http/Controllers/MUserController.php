<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Models\{MUser};

class MUserController extends Controller{

    public function __construct()
    {
        
    }

    public function getData(Request $request): JsonResponse{
        try{

        // $todos = (new MUser())->getData();
        //$todos = MUser::get();
        $perPage = $request->input('per_page', 6);
        $todos = MUser::orderBy('id','ASC')->paginate($perPage);
        
        return response()->json([
            'code' => 200,
            'status' => true,
            'data' => $todos
        ], 200);
        } catch(\Exception $e){
            return response()->json([
                'status' => false,
                'massage' => 'failed get data',
                
            ], 409);
        }
                
    }
    public function store(Request $request): JsonResponse
    {
        $user_id = 'USER TEST';
        $data = $this->validate($request, [
            'nama' =>'required',
            'nik' =>'required',
            'telp' =>'required',
            'alamat' =>'required',
        ]);
        try {
            $data['created_by'] = $user_id;
            $todos = MUser::create($data);

            return response()->json([
                'code' => 201,
                'status' => true,
                'message' => 'created successfully',
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                'code' =>403,
                'status' => false,
                'message' => 'created failed',
            ],403);
        }
    }
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user_id = 'USER TEST';
        
        try {
            $todo = MUser::findOrFail($id);
            
            MUser::where('id', $id)->update(['deleted_by' => $user_id]);
            $todo->delete();

            return response()->json([
                'code' => 201,
                'status' => true,
                'message' => 'deleted successfully',
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                'code' =>409,
                'status' => false,
                'message' => 'failed delete',
            ],409);
        }
    }
    public function show(int $id): JsonResponse
    {
        try {
            $todos = MUser::find($id);
            if ($todos) {
                return response()->json([
                    'code' => 200,
                    'status' => true,
                    'data' => $todos
                ],200);
            } else {
                return response()->json([
                    'code' =>404,
                    'status' => false,
                    'message' => 'data not found',
                ],404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' =>409,
                'status' => false,
                'message' => 'failed get data',
            ],409);
        }
    }
    public function update(Request $request, int $id): JsonResponse
	{
		DB::beginTransaction();
		$user_id = 'USER TEST';
		$data = $this->validate($request, [
			'nama' => 'regex:/^[a-zA-Z0-9\s]+$/',
			'nik' => 'regex:/^[a-zA-Z0-9\s]+$/',
			// 'alamat' => 'regex:/^[a-zA-Z0-9\s]+$/',
			'alamat' => 'required',
			'telp' => 'regex:/^[a-zA-Z0-9\s]+$/',
		]);

		try {
			$todo = MUser::findOrFail($id);
			$todo->fill($data);
			$todo->save();

			MUser::where('id', $id)->update(['updated_by' => $user_id, 'updated_at' => date('Y-m-d H:i:s')]);

			DB::commit();
			return response()->json([
				'code' => 201,
				'status' => true,
				'message' => 'updated successfully.',
				'data' => $todo
			], 201);
		} catch (\Exception $e) {
			DB::rollback();
			return response()->json([
				'code' => 409,
				'status' => false,
				'message' => 'failed update.',
			], 409);
		}
	}
    

}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\SemesterRepository;
use App\Http\Resources\SemesterResource;
use Validator;

use App\Semester;

class SemesterController extends ApiController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(SemesterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return the users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $limit = $request->get('paginate') ? $request->get('paginate') : 25;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy = $request->get('sortBy') ? $request->get('sortBy') : 'created_at';

        return SemesterResource::collection(
            $this->repository->getForDataTable(1, false)->orderBy($sortBy, $orderBy)->paginate($limit)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validateSemester($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->create($request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Semester Created Successfully"
        ]);
    }

    /**
     * Return the specified resource.
     *
     * @param int $course
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $semester = Semester::find($id);
        return new SemesterResource($semester);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $semester = Semester::find($id);
        $validation = $this->validateSemester($request, 'edit', $semester->id);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->update($semester, $request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Semester Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $semester = Semester::find($id);
        $semesterId = $semester->id;
        $this->repository->delete($semester);

        return $this->respond([
            'success'   => true,
            'data'      => $semesterId,
            'message'   => 'Semester Successfully Deleted!'
        ]);
    }

    /**
     * validateSemester
     *
     * @param $request
     * @param $action
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateSemester(Request $request, $action = '', $id = 0)
    {
        $validation = Validator::make($request->all(), [
            'name'            => 'required|max:255|unique:semesters,name,'.$id,
        ]);

        return $validation;
    }
}

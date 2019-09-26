<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\CourseRepository;
use App\Http\Resources\CourseResource;
use Validator;

use App\Course;

class CourseController extends ApiController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(CourseRepository $repository)
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

        return CourseResource::collection(
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
        $validation = $this->validateCourse($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->create($request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Course Created Successfully"
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
        $course = Course::find($id);
        return new CourseResource($course);
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
        $course = Course::find($id);
        $validation = $this->validateCourse($request, 'edit', $course->id);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->update($course, $request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Course Updated Successfully"
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
        $course = Course::find($id);
        $courseId = $course->id;
        $this->repository->delete($course);

        return $this->respond([
            'success'   => true,
            'data'      => $courseId,
            'message'   => 'Course Successfully Deleted!'
        ]);
    }

    /**
     * validateCourse
     *
     * @param $request
     * @param $action
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateCourse(Request $request, $action = '', $id = 0)
    {
        $validation = Validator::make($request->all(), [
            'name'            => 'required|max:255|unique:courses,name,'.$id,
        ]);

        return $validation;
    }
}

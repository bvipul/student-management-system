<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\MarksRepository;
use App\Http\Resources\MarksResource;
use Illuminate\Validation\Rule;
use Validator;

use App\Marks;

class MarksController extends ApiController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(MarksRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('paginate') ? $request->get('paginate') : 100;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy = $request->get('sortBy') ? $request->get('sortBy') : 'created_at';

        return MarksResource::collection(
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
        $validation = $this->validateMarks($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        if($request->input('marksAvailable')) {
            $marks = Marks::find($request->input('marksAvailable'));
            $this->repository->update($marks, $request->all());
        } else {
            $this->repository->create($request->all());
        }

        return $this->respond([
            'success'   => true,
            'message'   => "Marks Added Successfully"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marks = Marks::with(['course', 'student', 'semester', 'subject'])->find($id);
        $marks->courseName = $marks->course->name;
        $marks->studentName = $marks->student->name;
        $marks->semesterName = $marks->semester->name;
        $marks->subjectName = $marks->subject->name;
        return new MarksResource($marks);
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
        $marks = Marks::find($id);
        $validation = $this->validateMarks($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $this->repository->update($marks, $request->all());

        return $this->respond([
            'success'   => true,
            'message'   => "Marks Updated Successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marks = Marks::find($id);
        $marksId = $marks->id;
        $this->repository->delete($marks);

        return $this->respond([
            'success'   => true,
            'data'      => $marksId,
            'message'   => 'Marks Successfully Deleted!'
        ]);
    }

    /**
     * validateMarks
     *
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateMarks(Request $request)
    {
        $rules = [
            'course_id'       => 'required',
            'student_id'      => 'required',
            'semester_id'     => 'required',
            'subject_id'      => 'required',
            'marks'           => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        return $validation;
    }

    /**
     * getMarks
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMarks(Request $request) {
        $course = $request->input('course');
        $student = $request->input('student');
        $semester = $request->input('semester');
        $subject = $request->input('subject');

        $data = $this->repository->getMarks($course, $student, $semester, $subject);

        if($data) {
            $data = [
                'id' => $data->id,
                'marks' => $data->marks
            ];
        }

        return $this->respond([
            'success' => true,
            'data' => $data 
        ]);
    }
}
